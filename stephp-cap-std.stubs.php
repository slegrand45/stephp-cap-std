<?php

// Stubs for stephp-cap-std

namespace {
    function stephp_cap_std_ambient_authority(): \StephpCapStdAmbientAuthority {}

    function stephp_cap_std_open_ambient_dir(\StephpCapStdAmbientAuthority $auth, string $path): \StephpCapStdDir {}

    class StephpCapStdAmbientAuthority {
        public function __construct() {}
    }

    class StephpCapStdDir {
        public function entries(): \StephpCapStdEntries {}

        public function read_dir(string $path): \StephpCapStdEntries {}

        public function open_dir(string $path): \StephpCapStdDir {}

        public function open(string $path): \StephpCapStdFile {}

        public function open_with(string $path, \StephpCapStdOpenOptions $options): \StephpCapStdFile {}

        public function create(string $path): \StephpCapStdFile {}

        public function create_dir(string $path): void {}

        public function create_dir_all(string $path): void {}

        public function copy(string $from, \StephpCapStdDir $to_dir, string $to): int {}

        public function rename(string $from, \StephpCapStdDir $to_dir, string $to): void {}

        public function dir_metadata(): \StephpCapStdMetadata {}

        public function canonicalize(string $path): string {}

        public function read(string $path): string {}

        public function read_to_string(string $path): string {}

        public function write(string $path, string $data): void {}

        public function remove_dir(string $path): void {}

        public function remove_dir_all(string $path): void {}

        public function remove_file(string $path): void {}

        public function is_file(string $path): bool {}

        public function is_dir(string $path): bool {}

        public function exists(string $path): bool {}

        public function hard_link(string $src, \StephpCapStdDir $dst_dir, string $dst): void {}

        public function metadata(string $path): \StephpCapStdMetadata {}

        public function read_link(string $path): string {}

        public function symlink_metadata(string $path): \StephpCapStdMetadata {}

        public function set_permissions(string $path, \StephpCapStdPermissions $perm): void {}

        public function symlink(string $original, string $link): void {}

        public function try_clone(): \StephpCapStdDir {}

        public function __construct() {}
    }

    class StephpCapStdEntries implements \Countable, \Iterator {
        public static function new(array $entries): \StephpCapStdEntries {}

        public function count(): int {}

        public function rewind(): void {}

        public function current(): ?string {}

        public function key(): int {}

        public function next(): void {}

        public function valid(): bool {}

        public function __construct() {}
    }

    class StephpCapStdMetadata {
        public function file_type(): \StephpCapStdFileType {}

        public function is_dir(): bool {}

        public function is_file(): bool {}

        public function is_symlink(): bool {}

        public function len(): int {}

        public function permissions(): \StephpCapStdPermissions {}

        public function modified(): \StephpCapStdSystemTime {}

        public function accessed(): \StephpCapStdSystemTime {}

        public function created(): \StephpCapStdSystemTime {}

        public function dev(): int {}

        public function ino(): int {}

        public function mode(): int {}

        public function nlink(): int {}

        public function uid(): int {}

        public function gid(): int {}

        public function rdev(): int {}

        public function size(): int {}

        public function atime(): int {}

        public function atime_nsec(): int {}

        public function mtime(): int {}

        public function mtime_nsec(): int {}

        public function ctime(): int {}

        public function ctime_nsec(): int {}

        public function blksize(): int {}

        public function blocks(): int {}

        public function __construct() {}
    }

    class StephpCapStdFile {
        public function sync_all(): void {}

        public function sync_data(): void {}

        public function set_len(int $size): void {}

        public function metadata(): \StephpCapStdMetadata {}

        public function set_permissions(\StephpCapStdPermissions $permissions): void {}

        public function read(int $length): string {}

        public function read_to_end(): string {}

        public function read_to_string(): string {}

        public function write(string $data): int {}

        public function flush(): void {}

        public function rewind(): void {}

        public function stream_position(): int {}

        public function seek_relative(int $offset): void {}

        public function seek(int $offset, int $whence): int {}

        public function stream_len(): int {}

        public function try_clone(): \StephpCapStdFile {}

        public function set_times(?\StephpCapStdSystemTime $atime = null, ?\StephpCapStdSystemTime $mtime = null): void {}

        public function __construct() {}
    }

    class StephpCapStdFileType {
        public function is_dir(): bool {}

        public function is_file(): bool {}

        public function is_symlink(): bool {}

        public function __construct() {}
    }

    class StephpCapStdSystemTime {
        public static function from_unix_timestamp(int $seconds): \StephpCapStdSystemTime {}

        public function to_unix_timestamp_seconds_utc(): int {}

        public function __construct() {}
    }

    class StephpCapStdPermissions {
        public static function new(int $mode): \StephpCapStdPermissions {}

        public function readonly(): bool {}

        public function set_readonly(bool $readonly): void {}

        public function mode(): int {}

        public function set_mode(int $mode): void {}

        public function __construct() {}
    }

    class StephpCapStdOpenOptions {
        public static function new(): \StephpCapStdOpenOptions {}

        public function read(bool $read): void {}

        public function write(bool $enable): void {}

        public function append(bool $enable): void {}

        public function truncate(bool $enable): void {}

        public function create(bool $enable): void {}

        public function create_new(bool $enable): void {}

        public function mode(int $mode): void {}

        public function __construct() {}
    }
}
