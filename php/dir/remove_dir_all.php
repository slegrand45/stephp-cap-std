<?php

namespace tests\dir;

function remove_dir_all(string $root) {
    $dirname = 'test-stephp-cap-std';
    $dirpath = $root . '/' . $dirname;
    if (! is_dir($dirpath . '/a/b/c')) {
        mkdir($dirpath . '/a/b/c', 0700, true);
        if (! is_dir($dirpath . '/a/b/c')) {
            ko("dir: remove_dir_all: unable to create dir $dirpath/a/b/c");
            exit;
        }
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $dir->remove_dir_all($dirname);
    if (! $dir->is_dir($dirname)) {
        ok('dir: remove_dir_all: directory has been deleted (rust side check)');
    } else {
        ko("dir: remove_dir_all: directory $dirpath has not been deleted (rust side check)");
    }
    // /!\ clearstatcache() is mandatory or the PHP functions will still "see" the directory as not deleted !!
    clearstatcache();
    if (! is_dir($dirpath)) {
        ok('dir: remove_dir_all: directory has been deleted (php side check)');
    } else {
        ko("dir: remove_dir_all: directory $dirpath has not been deleted (php side check)");
    }
}