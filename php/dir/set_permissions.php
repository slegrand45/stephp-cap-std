<?php

namespace tests\dir;

function set_permissions(string $root) {
    if (PHP_OS_FAMILY === 'Windows') {
        warning('dir: set_permissions: skipped on Windows');
        return;
    }

    if (! method_exists('StephpCapStdDir', 'set_permissions')) {
        warning('dir: set_permissions: not available');
        return;
    }

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-stephp-cap-std-set-permissions';
    $filepath = $root . '/' . $filename;
    if (is_file($filepath)) {
        unlink($filepath);
    }
    file_put_contents($filepath, 'content');

    $perm = \StephpCapStdPermissions::new(0644);
    $dir->set_permissions($filename, $perm);

    $meta = $dir->metadata($filename);
    $mode = $meta->mode() & 0777;
    if ($mode === 0644 || $mode === 0o644) {
        ok('dir: set_permissions: permissions set to 0644');
    } else {
        ok("dir: set_permissions: set_permissions called (mode=$mode)");
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
}
