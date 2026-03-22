<?php

namespace tests\dir;

function traversal_blocked(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $blocked = false;
    try {
        $dir->open('../etc/passwd');
    } catch (\Throwable $e) {
        $blocked = true;
    }
    if ($blocked) {
        ok('dir: traversal_blocked: open("../etc/passwd") is blocked');
    } else {
        ko('dir: traversal_blocked: open("../etc/passwd") should be blocked');
    }

    $blocked = false;
    try {
        $dir->read_to_string('../../etc/passwd');
    } catch (\Throwable $e) {
        $blocked = true;
    }
    if ($blocked) {
        ok('dir: traversal_blocked: read_to_string("../../etc/passwd") is blocked');
    } else {
        ko('dir: traversal_blocked: read_to_string("../../etc/passwd") should be blocked');
    }

    $blocked = false;
    try {
        $dir->write('../escaping.txt', 'data');
    } catch (\Throwable $e) {
        $blocked = true;
    }
    if ($blocked) {
        ok('dir: traversal_blocked: write("../escaping.txt") is blocked');
    } else {
        ko('dir: traversal_blocked: write("../escaping.txt") should be blocked');
    }

    $blocked = false;
    try {
        $dir->create_dir('..');
    } catch (\Throwable $e) {
        $blocked = true;
    }
    if ($blocked) {
        ok('dir: traversal_blocked: create_dir("..") is blocked');
    } else {
        ko('dir: traversal_blocked: create_dir("..") should be blocked');
    }
}
