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