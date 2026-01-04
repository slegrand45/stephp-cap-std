<?php

namespace tests\file;

function set_permissions(string $root) {
    if (method_exists('StephpCapStdPermissions', 'new')) {
        $filename = 'test-stephp-cap-std-file';
        $filepath = $root . '/' . $filename;
        if (! file_exists($filepath)) {
            file_put_contents($filepath, '');
        }
        $ambient_auth = stephp_cap_std_ambient_authority();
        $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
        $fd = $dir->create($filename);
        $permissions = \StephpCapStdPermissions::new(0);
        $mode = 0o640;
        $permissions->set_mode($mode);
        $r = $fd->set_permissions($permissions);
        $perms = fileperms($filepath) & 0777; // https://www.php.net/manual/en/function.fileperms.php#113060
        if (file_exists($filepath)) {
            unlink($filepath);
        }
        if ($r === null) {
            ok('file: set_permissions: returned null');
        } else {
            ko('file: set_permissions: should have returned null, returned ' . var_export($r, false));
        }
        if ($perms === $mode) {
            ok('file: set_permissions: permissions are right');
        } else {
            ko('file: set_permissions: permissions are wrong, equal to ' . $perms . ' but should be ' . $mode);
        }
    } else {
        warning('file: set_permissions: not available on your operating system');
    }
}