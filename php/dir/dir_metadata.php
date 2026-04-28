<?php

namespace tests\dir;

function dir_metadata(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $metadata = $dir->dir_metadata();
    if (is_a($metadata, 'StephpCapStdMetadata')) {
        ok('dir: dir_metadata: dir_metadata() returned an StephpCapStdMetadata object');
    } else {
        ko('dir: dir_metadata: dir_metadata() should return an StephpCapStdMetadata object');
    }
    if ($metadata->file_type()->is_dir()) {
        ok('dir: dir_metadata: file_type() is dir');
    } else {
        ko('dir: dir_metadata: file_type() should be dir');
    }
    if (! $metadata->is_file()) {
        ok('dir: dir_metadata: is_file() is false');
    } else {
        ko('dir: dir_metadata: is_file() should be false');
    }
    if (! $metadata->is_symlink()) {
        ok('dir: dir_metadata: is_symlink() is false');
    } else {
        ko('dir: dir_metadata: is_symlink() should be false');
    }
    $len = $metadata->len();
    if ($len > 0) {
        ok('dir: dir_metadata: len() > 0, = ' . $len);
    } else {
        ko('dir: dir_metadata: len() should be greater than zero, returned ' . $len);
    }
    $ts = (int) $metadata->modified()->to_unix_timestamp_seconds_utc();
    $dt = (new \DateTimeImmutable())->setTimestamp($ts);
    if ($ts > 0 && (int) $dt->format('U') > 0 && $ts === (int) $dt->format('U')) {
        ok('dir: dir_metadata: modified timestamp (' . $ts . ', ' . $dt->format('Y-m-d H:i:s') . ')');
    } else {
        ko('dir: dir_metadata: wrong modified timestamp(' . $ts . ', ' . $dt->format('Y-m-d H:i:s') . ')');
    }
    $uid = $metadata->uid();
    if ($uid >= 0) {
        ok('dir: dir_metadata: uid() >= 0, = ' . $uid);
    } else {
        ko('dir: dir_metadata: uid() should be greater or equal to zero, returned ' . $uid);
    }
    $gid = $metadata->gid();
    if ($gid >= 0) {
        ok('dir: dir_metadata: gid() >= 0, = ' . $gid);
    } else {
        ko('dir: dir_metadata: gid() should be greater or equal to zero, returned ' . $gid);
    }

    if ($metadata->ino() > 0) {
        ok('dir: dir_metadata: ino() > 0');
    } else {
        ko('dir: dir_metadata: ino() should be > 0');
    }

    if ($metadata->nlink() >= 1) {
        ok('dir: dir_metadata: nlink() >= 1');
    } else {
        ko('dir: dir_metadata: nlink() should be >= 1');
    }

    $atime = $metadata->accessed()->to_unix_timestamp_seconds_utc();
    if ($atime > 0) {
        ok('dir: dir_metadata: accessed() timestamp > 0');
    } else {
        ko('dir: dir_metadata: accessed() timestamp should be > 0');
    }

    $size = $metadata->size();
    if ($size >= 0) {
        ok('dir: dir_metadata: size() > 0, = ' . $size);
    } else {
        ko('dir: dir_metadata: size() should be greater than zero, returned ' . $size);
    }
}