<?php

namespace tests\dir;

function remove_dir(string $root) {
    $dirname = 'test-stephp-cap-std';
    $dirpath = $root . '/' . $dirname;
    if (! is_dir($dirpath)) {
        mkdir($dirpath);
        if (! is_dir($dirpath)) {
            ko("dir: remove_dir: unable to create dir $dirpath");
            exit;
        }
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $dir->remove_dir($dirname);
    if (! $dir->is_dir($dirname)) {
        ok('dir: remove_dir: directory has been deleted (rust side check)');
    } else {
        ko("dir: remove_dir: directory $dirpath has not been deleted (rust side check)");
    }
    // /!\ clearstatcache() is mandatory or the PHP functions will still "see" the directory as not deleted !!
    clearstatcache();
    if (! is_dir($dirpath)) {
        ok('dir: remove_dir: directory has been deleted (php side check)');
    } else {
        ko("dir: remove_dir: directory $dirpath has not been deleted (php side check)");
    }
}