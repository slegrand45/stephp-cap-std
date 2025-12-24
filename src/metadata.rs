#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;
use crate::filetype;

#[php_class]
pub struct StephpCapStdMetadata {
    pub inner: cap_std::fs::Metadata,
}

#[php_impl]
impl StephpCapStdMetadata {
    #[php(name = "file_type")]
    pub fn file_type(&self) -> filetype::StephpCapStdFileType {
        let file_type = self.inner.file_type();
        filetype::StephpCapStdFileType {
            inner: file_type
        }
    }
}