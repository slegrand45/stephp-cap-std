<?php

namespace tests\dir;

function remove_file(string $root) {
    $filename = 'test-stephp-cap-std';
    $filepath = $root . '/' . $filename;
    if (! is_file($filepath)) {
        file_put_contents($filepath, 'test');
        if (! is_file($filepath)) {
            ko("dir: remove_file: unable to create file $filepath");
            exit;
        }
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $dir->remove_file($filename);
    if (! $dir->is_file($filename)) {
        ok('dir: remove_file: file has been deleted (rust side check)');
    } else {
        ko("dir: remove_file: file $filepath has not been deleted (rust side check)");
    }
    // /!\ clearstatcache() is mandatory or the PHP functions will still "see" the file as not deleted !!
    clearstatcache();
    if (! is_file($filepath)) {
        ok('dir: remove_file: file has been deleted (php side check)');
    } else {
        ko("dir: remove_file: file $filepath has not been deleted (php side check)");
    }
}