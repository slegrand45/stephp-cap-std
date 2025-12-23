<?php

namespace tests;

function ambient_authority() {
    $ambient_auth = stephp_cap_std_ambient_authority();
    if (is_a($ambient_auth, 'StephpCapStdAmbientAuthority')) {
        ok('stephp_cap_std_ambient_authority() returned an StephpCapStdAmbientAuthority object');
    } else {
        ko('stephp_cap_std_ambient_authority() should return an StephpCapStdAmbientAuthority object');
    }
}