<?php

// php -d extension=./target/debug/libphp_cap_std.so php/test.php

$ROOT = '/tmp';

$ambient_auth = cap_std_ambient_authority();
if (! is_a($ambient_auth, 'CapStdAmbientAuthority')) {
    die('cap_std_ambient_authority() should return an CapStdAmbientAuthority object');
}

$dir = cap_std_open_ambient_dir($ambient_auth, $ROOT);
if (! is_a($dir, 'CapStdDir')) {
    die('cap_std_open_ambient_dir() should return an CapStdDir object');
}