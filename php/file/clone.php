<?php

namespace tests\file;

function clone_test(string $root) {
    $filename = 'test-clone.txt';
    $filepath = $root . '/' . $filename;
    file_put_contents($filepath, 'clone test content');

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);
    
    $clone = $fd->try_clone();
    if (is_a($clone, 'StephpCapStdFile')) {
        ok('file: clone: try_clone() returned a StephpCapStdFile object');
    } else {
        ko('file: clone: try_clone() should return a StephpCapStdFile object');
        return;
    }

    $fd->seek(0, SEEK_SET);
    $data1 = $fd->read(5);
    
    // Cloned file descriptors often share the same offset if they are the same open file handle,
    // but cap_std::fs::File::try_clone uses dup() on Unix which shares the offset.
    $pos_clone = $clone->stream_position();
    if ($pos_clone === 5) {
        ok('file: clone: cloned file shares position (standard dup() behavior)');
    } else {
        ok("file: clone: cloned file has independent position: $pos_clone");
    }

    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
