#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;

#[php_class]
pub struct StephpCapStdFile {
    pub inner: cap_std::fs::File,
}

#[php_impl]
impl StephpCapStdFile {
    #[php(name = "sync_all")]
    pub fn sync_all(&self) -> Result<(), String> {
        self.inner.sync_all().map_err(|e| e.to_string())?;
        Ok(())
    }
}