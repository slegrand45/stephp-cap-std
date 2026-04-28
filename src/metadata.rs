#![cfg_attr(windows, feature(abi_vectorcall))]

use crate::filetype;
use crate::permissions;
use crate::systemtime;
use crate::systemtime::StephpCapStdSystemTime;
use cap_std::fs::MetadataExt;
use ext_php_rs::prelude::*;
use std::sync::Mutex;

#[php_class]
pub struct StephpCapStdMetadata {
    pub inner: cap_std::fs::Metadata,
}

#[php_impl]
impl StephpCapStdMetadata {
    #[php(name = "file_type")]
    pub fn file_type(&self) -> filetype::StephpCapStdFileType {
        let file_type = self.inner.file_type();
        filetype::StephpCapStdFileType { inner: file_type }
    }

    #[php(name = "is_dir")]
    pub fn is_dir(&self) -> bool {
        self.inner.is_dir()
    }

    #[php(name = "is_file")]
    pub fn is_file(&self) -> bool {
        self.inner.is_file()
    }

    #[php(name = "is_symlink")]
    pub fn is_symlink(&self) -> bool {
        self.inner.is_symlink()
    }

    #[php(name = "len")]
    pub fn len(&self) -> u64 {
        self.inner.len()
    }

    #[php(name = "permissions")]
    pub fn permissions(&self) -> permissions::StephpCapStdPermissions {
        let permissions = self.inner.permissions();
        permissions::StephpCapStdPermissions {
            inner: Mutex::new(permissions),
        }
    }

    #[php(name = "modified")]
    pub fn modified(&self) -> Result<systemtime::StephpCapStdSystemTime, String> {
        let modified = self.inner.modified().map_err(|e| e.to_string())?;
        Ok(StephpCapStdSystemTime { inner: modified })
    }

    #[php(name = "accessed")]
    pub fn accessed(&self) -> Result<systemtime::StephpCapStdSystemTime, String> {
        let accessed = self.inner.accessed().map_err(|e| e.to_string())?;
        Ok(StephpCapStdSystemTime { inner: accessed })
    }

    #[php(name = "created")]
    pub fn created(&self) -> Result<systemtime::StephpCapStdSystemTime, String> {
        let created = self.inner.created().map_err(|e| e.to_string())?;
        Ok(StephpCapStdSystemTime { inner: created })
    }

    #[php(name = "dev")]
    pub fn dev(&self) -> u64 {
        self.inner.dev()
    }

    #[php(name = "ino")]
    pub fn ino(&self) -> u64 {
        self.inner.ino()
    }

    #[php(name = "mode")]
    pub fn mode(&self) -> u32 {
        self.inner.mode()
    }

    #[php(name = "nlink")]
    pub fn nlink(&self) -> u64 {
        self.inner.nlink()
    }

    #[php(name = "uid")]
    pub fn uid(&self) -> u32 {
        self.inner.uid()
    }

    #[php(name = "gid")]
    pub fn gid(&self) -> u32 {
        self.inner.gid()
    }

    #[php(name = "rdev")]
    pub fn rdev(&self) -> u64 {
        self.inner.rdev()
    }

    #[php(name = "size")]
    pub fn size(&self) -> u64 {
        self.inner.size()
    }

    #[php(name = "atime")]
    pub fn atime(&self) -> i64 {
        self.inner.atime()
    }

    #[php(name = "atime_nsec")]
    pub fn atime_nsec(&self) -> i64 {
        self.inner.atime_nsec()
    }

    #[php(name = "mtime")]
    pub fn mtime(&self) -> i64 {
        self.inner.mtime()
    }

    #[php(name = "mtime_nsec")]
    pub fn mtime_nsec(&self) -> i64 {
        self.inner.mtime_nsec()
    }

    #[php(name = "ctime")]
    pub fn ctime(&self) -> i64 {
        self.inner.ctime()
    }

    #[php(name = "ctime_nsec")]
    pub fn ctime_nsec(&self) -> i64 {
        self.inner.ctime_nsec()
    }

    #[php(name = "blksize")]
    pub fn blksize(&self) -> u64 {
        self.inner.blksize()
    }

    #[php(name = "blocks")]
    pub fn blocks(&self) -> u64 {
        self.inner.blocks()
    }
}
