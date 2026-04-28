<?php

namespace tests\dir;

function symlink_safety(string $root) {
    if (PHP_OS_FAMILY === 'Windows') {
        warning('dir: symlink_safety: skipped on Windows');
        return;
    }

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    // Create a symlink pointing to /etc/passwd
    $linkname = 'evil-link-to-passwd';
    $linkpath = $root . '/' . $linkname;
    if (file_exists($linkpath)) {
        unlink($linkpath);
    }
    
    // We use native PHP symlink to create the "trap"
    if (! @symlink('/etc/passwd', $linkpath)) {
        warning('dir: symlink_safety: unable to create symlink for test (maybe permissions?)');
        return;
    }

    // Attempting to read /etc/passwd through the capability-wrapped directory should fail
    $failed = false;
    try {
        $dir->read($linkname);
    } catch (\Throwable $e) {
        $failed = true;
    }

    if ($failed) {
        ok('dir: symlink_safety: access to external file through symlink is blocked');
    } else {
        ko('dir: symlink_safety: access to external file through symlink should be blocked!');
    }

    // Test with open()
    $failed = false;
    try {
        $dir->open($linkname);
    } catch (\Throwable $e) {
        $failed = true;
    }
    if ($failed) {
        ok('dir: symlink_safety: open() through external symlink is blocked');
    } else {
        ko('dir: symlink_safety: open() through external symlink should be blocked!');
    }

    // Cleanup
    unlink($linkpath);
}
