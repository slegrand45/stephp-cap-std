<?php

namespace tests\file;

function sync_data(string $root) {
    $filename = 'test-sync-data.txt';
    $filepath = $root . '/' . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }
    
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->create($filename);
    $fd->write('sync data test');
    
    try {
        $fd->sync_data();
        ok('file: sync_data: sync_data() called successfully');
    } catch (\Throwable $e) {
        ko('file: sync_data: sync_data() failed: ' . $e->getMessage());
    }

    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
