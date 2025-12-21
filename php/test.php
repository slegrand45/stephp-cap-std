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
    echo "first pass: $count !== " . count($firstPass) . "\n";
}

$secondPass = [];
foreach ($rdir as $key => $name) {
    $secondPass[$key] = $name;
}
if ($firstPass !== $secondPass) {
    echo "second pass: $firstPass !== " . $secondPass . "\n";
}

$rdir->rewind();
if ($rdir->valid()) {
    $name = $rdir->current();
    $rdir->next();
    echo "OK (first file : $name)\n";
} else {
    echo "FAIL (empty directory or wrong valid() method)\n";
}
