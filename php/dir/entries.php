<?php

namespace tests\dir;

function entries(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $subdir = 'test-stephp-cap-std-entries';
    $subdirpath = $root . '/' . $subdir;
    if (! is_dir($subdirpath)) {
        mkdir($subdirpath);
    }
    $subdir_obj = $dir->open_dir($subdir);

    $entries = $subdir_obj->entries();
    if (is_a($entries, 'StephpCapStdEntries')) {
        ok('dir: entries: returns StephpCapStdEntries object');
    } else {
        ko('dir: entries: should return StephpCapStdEntries object');
    }

    $entries_count = count($entries);
    $read_dir_result = $subdir_obj->read_dir('.');
    $read_dir_count = count($read_dir_result);
    if ($entries_count === $read_dir_count) {
        ok("dir: entries: entries() count ($entries_count) matches read_dir('.') count");
    } else {
        ko("dir: entries: entries count $entries_count !== read_dir count $read_dir_count");
    }

    $entries_names = [];
    foreach ($entries as $name) {
        $entries_names[] = $name;
    }
    $read_dir_names = [];
    foreach ($read_dir_result as $name) {
        $read_dir_names[] = $name;
    }
    sort($entries_names);
    sort($read_dir_names);
    if ($entries_names === $read_dir_names) {
        ok('dir: entries: entries() and read_dir(".") return same names');
    } else {
        ko('dir: entries: entries and read_dir names differ');
    }

    rmdir($subdirpath);
}
