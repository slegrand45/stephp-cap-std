#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;

#[php_class]
pub struct StephpCapStdFileType {
    pub inner: cap_std::fs::FileType,
}

#[php_impl]
impl StephpCapStdFileType {
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
}
