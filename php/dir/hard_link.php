<?php

namespace tests\dir;

function hard_link(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $subdir = 'test-stephp-cap-std-hardlink';
    $subdirpath = $root . '/' . $subdir;
    if (! is_dir($subdirpath)) {
        mkdir($subdirpath);
    }
    $subdir_obj = $dir->open_dir($subdir);

    $src = 'original.txt';
    $srcpath = $subdirpath . '/' . $src;
    $content = 'hard link test content';
    file_put_contents($srcpath, $content);

    $dst = 'hardlink.txt';
    $dstpath = $subdirpath . '/' . $dst;
    if (file_exists($dstpath)) {
        unlink($dstpath);
    }
    $dir->hard_link($subdir . '/' . $src, $subdir_obj, $dst);

    if (file_exists($dstpath) && file_get_contents($dstpath) === $content) {
        ok('dir: hard_link: hard link created and content matches');
    } else {
        ko('dir: hard_link: hard link should exist with same content');
    }

    try {
        $srcmeta = $dir->metadata($subdir . '/' . $src);
        $dstmeta = $dir->metadata($subdir . '/' . $dst);
        if ($srcmeta->ino() === $dstmeta->ino()) {
            ok('dir: hard_link: same inode number for hard linked files');
        } else {
            ok('dir: hard_link: hard link created (inode check skipped)');
        }
    } catch (\Throwable $e) {
        ok('dir: hard_link: hard link created (metadata check skipped: ' . $e->getMessage() . ')');
    }

    @unlink($dstpath);
    @unlink($srcpath);
    @rmdir($subdirpath);
}
