<?php

// php -d extension=./target/debug/libphp_cap_std.so php/test.php

$ambient_auth = cap_std_ambient_authority();
var_export($ambient_auth);

if (! is_a($ambient_auth, 'CapStdAmbientAuthority')) {
    die('cap_std_ambient_authority() should return an CapStdAmbientAuthority object');
}