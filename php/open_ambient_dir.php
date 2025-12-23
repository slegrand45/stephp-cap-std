<?php

namespace tests;

function open_ambient_dir(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    if (is_a($dir, 'StephpCapStdDir')) {
        ok('stephp_cap_std_open_ambient_dir() returned an StephpCapStdDir object');
    } else {
        ko('stephp_cap_std_open_ambient_dir() should return an StephpCapStdDir object');
    }
}