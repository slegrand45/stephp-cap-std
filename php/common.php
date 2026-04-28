<?php

$nbKO = 0;

function ok(string $msg) {
    echo ' ✅ OK: ' . $msg . "\n";
}

function warning(string $msg) {
    echo '⚠️  WARNING: ' . $msg . "\n";
}

function ko(string $msg) {
    global $nbKO;
    echo ' ❌ KO: ' . $msg . "\n";
    $nbKO++;
}

function result() {
    global $nbKO;
    if ($nbKO === 0) {
        echo '🥳 🎉  SUCCESS!' . "\n";
    } else {
        echo '💥 🔥  FAILURE!: ' . $nbKO . ' failure(s)' . "\n";
    }
}

function recursive_rmdir(string $dir) {
    if (! is_dir($dir)) {
        return;
    }
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? recursive_rmdir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}