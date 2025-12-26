#![cfg_attr(windows, feature(abi_vectorcall))]

use crate::filetype;
use crate::permissions;
use ext_php_rs::prelude::*;
use std::cell::RefCell;

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
        permissions::StephpCapStdPermissions { inner: RefCell::new(permissions) }
    }
}
