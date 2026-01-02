# stephp-cap-std

**Version 0.1.0**

`stephp-cap-std` is an experimental PHP extension written in Rust. It provides bindings to the [cap-std](https://github.com/bytecodealliance/cap-std) crate, offering a capability-based security approach for filesystem access.

The primary goal is to enable robust **sandboxing** within PHP scripts. Unlike native PHP filesystem functions, this extension ensures that once a directory is opened, it is impossible to access files outside of that directory tree (e.g., via `../../`), providing strong protection against directory traversal attacks.

## Prerequisites

*   **Linux** (or a compatible Unix system)
*   **Rust** (via `rustup`, 2021 edition)
*   **PHP** (version 8.0+, with development headers installed, e.g., `php-dev` or `php-devel`)
*   **Clang** (required for binding generation by `ext-php-rs`)

## Compilation and Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd php-cap-std
    ```

2.  **Build the project:**
    Use Cargo to build the dynamic library.
    ```bash
    cargo build --release
    ```
    The generated artifact will be located at `target/release/libstephp_cap_std.so`.

3.  **Enable the extension:**
    You can either add the extension to your `php.ini` file or include it dynamically during CLI execution.

    **Option A: Command line (for testing)**
    ```bash
    php -d extension=target/release/libstephp_cap_std.so your_script.php
    ```

    **Option B: Permanent configuration**
    Copy the `.so` file to your PHP extensions directory and add the following line to your `php.ini`:
    ```ini
    extension=libstephp_cap_std.so
    ```

## Usage Example

Here is a simple example showing how to open a directory securely and manipulate files within it.

```php
<?php

// 1. Obtain the ambient authority (entry point for system resources)
$auth = stephp_cap_std_ambient_authority();

// 2. Open a root directory for the sandbox (e.g., /tmp/sandbox)
// If the path does not exist, an exception (String) will be thrown.
try {
    $dir = stephp_cap_std_open_ambient_dir($auth, '/tmp/sandbox');
    
    // From this point, $dir can ONLY act within /tmp/sandbox.
    
    // Write a file
    $dir->write_file("message.txt", "Hello Secure World!");
    
    // Read a file
    echo $dir->read_file("message.txt"); // Outputs: Hello Secure World!
    
    // Create a subdirectory
    $dir->create_dir("logs");
    
    // Attempting to access the parent directory will fail (cap-std security)
    // $dir->read_file("../passwd"); // This will trigger a Rust error/Permission denied
    
    // List contents
    $entries = $dir->read_dir(".");
    var_dump($entries);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Available API

The main exposed classes are:

*   **`StephpCapStdAmbientAuthority`**: Represents the authority to access global system resources.
*   **`StephpCapStdDir`**: Represents an opened directory. Main methods:
    *   `open_dir(string $path)`
    *   `create_dir(string $path)`
    *   `read_file(string $path)`
    *   `write_file(string $path, string $content)`
    *   `remove_file(string $path)`
    *   `remove_dir(string $path)`
    *   `metadata(string $path)`
    *   `canonicalize(string $path)`

## Limitations and Warnings

### ⚠️ PHP Stat Cache (`clearstatcache`)

This extension performs system operations via Rust, bypassing PHP's standard streams. However, PHP maintains an internal cache for file metadata operations (functions like `file_exists`, `is_file`, `stat`, etc.).

If you mix this extension with native PHP functions on the same files, you **must** be aware of this cache.

**Potential conflict example:**

```php
$dir->write_file("test.txt", "data");

// If you use the native PHP function immediately after:
if (file_exists("/tmp/sandbox/test.txt")) {
    // This might return FALSE if PHP cached the file's absence 
    // before the Rust write operation.
}
```

**Solution:**
If you encounter inconsistencies when using both systems together, call the native PHP function:

```php
clearstatcache();
```

It is recommended to use the methods provided by the `$dir` object (such as `$dir->exists()`, `$dir->is_file()`) whenever possible, as they query the filesystem directly via Rust, ensuring up-to-date data.

### Performance

While Rust is extremely fast, crossing the FFI (Foreign Function Interface) boundary between PHP and Rust has a cost. For massive reads/writes of very small files, this might be less performant than a pure native solution, but it provides superior security guarantees.

## License

This project is licensed under the MIT License.