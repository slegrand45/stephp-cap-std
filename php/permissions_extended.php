<?php

namespace tests;

function permissions_extended(string $root) {
    if (PHP_OS_FAMILY === 'Windows') {
        warning('permissions_extended: skipped on Windows');
        return;
    }

    $mode = 0644;
    $p = \StephpCapStdPermissions::new($mode);
    
    if ($p->mode() === $mode) {
        ok("permissions: mode() returns $mode");
    } else {
        ko("permissions: mode() expected $mode, got " . $p->mode());
    }

    $p->set_mode(0755);
    if ($p->mode() === 0755) {
        ok("permissions: set_mode(0755) works");
    } else {
        ko("permissions: set_mode(0755) failed, got " . $p->mode());
    }

    if (method_exists($p, 'readonly')) {
        $p->set_readonly(true);
        if ($p->readonly()) {
            ok("permissions: set_readonly(true) works");
        } else {
            ko("permissions: set_readonly(true) failed");
        }
        
        // On Unix, readonly usually means removing write bits (0755 -> 0555)
        $m = $p->mode() & 0777;
        if (($m & 0222) === 0) {
            ok("permissions: readonly(true) removed write bits (mode=$m)");
        } else {
            warning("permissions: readonly(true) did not remove all write bits (mode=$m)");
        }
    }
}
