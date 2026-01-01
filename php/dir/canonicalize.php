<?php

namespace tests\dir;

function canonicalize(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $canon = $dir->canonicalize('.');
    if ($canon === '.') {
        ok("canonicalize: canonicalize: returned '.'");
    } else {
        ko("canonicalize: canonicalize: returned '$canon' but should have returned '.'");
    }
}