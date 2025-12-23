<?php

namespace tests\dir;

function create_dir(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $newdir = 'test-stephp-cap-std';
    $newdir_path = $root . '/' . $newdir;
    if (! is_dir($newdir_path)) {
        $dir->create_dir($newdir);
        if (is_dir($newdir_path)) {
            ok("dir: create_dir($newdir)");
        } else {
            ko("dir: unable to create dir $newdir");
        }
    }
    try {
        $forbidden_path = $root . '/../' . $newdir;
        $dir->create_dir($forbidden_path);
        ko("dir: create_dir($forbidden_path) is forbidden and must fail");
    } catch (\Exception $e) {
        ok("dir: unable to create forbidden $forbidden_path");
    }
    if (is_dir($newdir_path)) {
        rmdir($newdir_path);
    }
}