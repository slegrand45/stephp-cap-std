<?php

namespace tests\dir;

function create_dir_all(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $newdirall = 'test-stephp-cap-std/a/b/🐘/c';
    $newdirall_path = $root . '/' . $newdirall;
    if (! is_dir($newdirall_path)) {
        $dir->create_dir_all($newdirall);
        if (is_dir($newdirall_path)) {
            ok("dir: create_dir_all: all directories $newdirall created");
        } else {
            ko("dir: create_dir_all: unable to create all directories $newdirall");
        }
    }
    if (is_dir($newdirall_path)) {
        $dirs = explode('/', $newdirall);
        for($i = count($dirs) - 1; $i >= 0; $i--) {
            $slice = array_slice($dirs, 0, $i + 1);
            $subdir = implode('/', $slice);
            $path = $root . '/' . $subdir;
            rmdir($path);
        }
    }
}