<?php

namespace tests\file;

function set_times(string $root) {
    $filename = 'test-set-times.txt';
    $filepath = $root . '/' . $filename;
    file_put_contents($filepath, 'times test');

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);

    $now = time();
    $atime = \StephpCapStdSystemTime::from_unix_timestamp($now - 3600); // 1 hour ago
    $mtime = \StephpCapStdSystemTime::from_unix_timestamp($now - 7200); // 2 hours ago

    try {
        $fd->set_times($atime, $mtime);
        ok('file: set_times: set_times() called successfully');
        
        clearstatcache();
        $stats = stat($filepath);
        // Check if timestamps are close to what we set (some filesystems have low precision)
        if (abs($stats['atime'] - ($now - 3600)) <= 2) {
            ok('file: set_times: atime matches');
        } else {
            ko("file: set_times: atime mismatch, expected " . ($now - 3600) . " got " . $stats['atime']);
        }
        
        if (abs($stats['mtime'] - ($now - 7200)) <= 2) {
            ok('file: set_times: mtime matches');
        } else {
            ko("file: set_times: mtime mismatch, expected " . ($now - 7200) . " got " . $stats['mtime']);
        }
    } catch (\Throwable $e) {
        ko('file: set_times: failed: ' . $e->getMessage());
    }

    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
