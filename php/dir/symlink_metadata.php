<?php

namespace tests\dir;

function symlink_metadata(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-stephp-cap-std-symlink-meta';
    $filepath = $root . '/' . $filename;
    if (is_file($filepath)) {
        unlink($filepath);
    }
    file_put_contents($filepath, 'content');

    $meta = $dir->symlink_metadata($filename);
    if (is_a($meta, 'StephpCapStdMetadata')) {
        ok('dir: symlink_metadata: returns StephpCapStdMetadata for file');
    } else {
        ko('dir: symlink_metadata: should return StephpCapStdMetadata');
    }

    if (! $meta->is_symlink()) {
        ok('dir: symlink_metadata: regular file is_symlink() returns false');
    } else {
        ko('dir: symlink_metadata: regular file is_symlink() should return false');
    }

    if (PHP_OS_FAMILY !== 'Windows') {
        $linkname = 'test-stephp-cap-std-symlink-meta-link';
        $linkpath = $root . '/' . $linkname;
        if (file_exists($linkpath)) {
            unlink($linkpath);
        }
        symlink($filename, $linkpath);

        $linkmeta = $dir->symlink_metadata($linkname);
        if ($linkmeta->is_symlink()) {
            ok('dir: symlink_metadata: symlink is_symlink() returns true');
        } else {
            ko('dir: symlink_metadata: symlink is_symlink() should return true');
        }

        unlink($linkpath);
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
}
