<?php

namespace tests\dir;

function read_dir(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $rdir = $dir->read_dir(".");
    if (is_a($rdir, 'StephpCapStdEntries')) {
        ok('dir: read_dir() returned an StephpCapStdEntries object');
    } else {
        ko('dir: read_dir() should return an StephpCapStdEntries object');
    }

    $count = count($rdir);
    if ($count >= 0) {
        ok('dir: count(rdir) = ' . $count);
    } else {
        ko('dir: count(rdir) = ' . count($rdir) . ', should be >= 0');
    }

    $firstPass = [];
    foreach ($rdir as $key => $name) {
        $firstPass[$key] = $name;
    }
    if (count($firstPass) === $count) {
        ok('dir: count(firstPass) === count');
    } else {
        ko("dir: first pass: $count !== " . count($firstPass));
    }

    $secondPass = [];
    foreach ($rdir as $key => $name) {
        $secondPass[$key] = $name;
    }
    if ($firstPass === $secondPass) {
        ok('dir: firstPass === secondPass');
    } else {
        ko('dir: firstPass (' . var_export($firstPass) . ') !== secondPass (' . var_export($secondPass) . ')');
    }

    $rdir->rewind();
    if ($rdir->valid()) {
        $name = $rdir->current();
        $rdir->next();
        ok("dir: rewind: first file = $name");
    } else {
        ko('dir: rewind: empty directory or wrong valid() method');
    }
}
