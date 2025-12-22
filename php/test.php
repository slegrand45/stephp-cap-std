<?php

// php -d extension=./target/debug/libstephp_cap_std.so php/test.php

$ROOT = '/tmp';

$ambient_auth = stephp_cap_std_ambient_authority();
if (! is_a($ambient_auth, 'StephpCapStdAmbientAuthority')) {
    die('stephp_cap_std_ambient_authority() should return an StephpCapStdAmbientAuthority object');
}

$dir = stephp_cap_std_open_ambient_dir($ambient_auth, $ROOT);
if (! is_a($dir, 'StephpCapStdDir')) {
    die('stephp_cap_std_open_ambient_dir() should return an StephpCapStdDir object');
}

$rdir = $dir->read_dir(".");
if (! is_a($rdir, 'StephpCapStdEntries')) {
    die('dir->read_dir() should return an StephpCapStdEntries object');
}

$count = count($rdir);
echo "count(rdir): " . $count . "\n";
if ($count < 0) {
    die('count(rdir) = ' . count($rdir) . ' should be >= 0');
}

$firstPass = [];
foreach ($rdir as $key => $name) {
    $firstPass[$key] = $name;
}
if (count($firstPass) !== $count) {
    die("first pass: $count !== " . count($firstPass) . "\n");
}

$secondPass = [];
foreach ($rdir as $key => $name) {
    $secondPass[$key] = $name;
}
if ($firstPass !== $secondPass) {
    die("second pass: $firstPass !== " . $secondPass . "\n");
}

$rdir->rewind();
if ($rdir->valid()) {
    $name = $rdir->current();
    $rdir->next();
    echo "OK (first file : $name)\n";
} else {
    die("FAIL (empty directory or wrong valid() method)\n");
}

$newdir = 'test-stephp-cap-std';
$newdir_path = $ROOT . '/' . $newdir;
if (! is_dir($newdir_path)) {
    $dir->create_dir($newdir);
    if (! is_dir($newdir_path)) {
        die("unable to create dir $newdir\n");
    }
}
try {
    $forbidden_path = $ROOT . '/../' . $newdir;
    $dir->create_dir($forbidden_path);
    die("create_dir($forbidden_path) must fail");
} catch (\Exception $e) {
    // ok
}

$newdirall = 'test-stephp-cap-std/a/b/🐘/c';
$newdirall_path = $ROOT . '/' . $newdirall;
if (! is_dir($newdirall_path)) {
    $dir->create_dir_all($newdirall);
    if (! is_dir($newdirall_path)) {
        die("unable to create dir $newdirall\n");
    }
}

$testdir = $dir->open_dir($newdir);
if (! is_a($testdir, 'StephpCapStdDir')) {
    die('dir->open_dir() should return an StephpCapStdDir object');
}
