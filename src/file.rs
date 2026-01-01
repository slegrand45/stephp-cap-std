#![cfg_attr(windows, feature(abi_vectorcall))]

use crate::metadata;
use crate::permissions::StephpCapStdPermissions;
use ext_php_rs::prelude::*;
use std::io::Read;
use std::sync::Mutex;

#[php_class]
pub struct StephpCapStdFile {
    pub inner: Mutex<cap_std::fs::File>,
}

#[php_impl]
impl StephpCapStdFile {
    #[php(name = "sync_all")]
    pub fn sync_all(&self) -> Result<(), String> {
        let file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.sync_all().map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "sync_data")]
    pub fn sync_data(&self) -> Result<(), String> {
        let file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.sync_data().map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "set_len")]
    pub fn set_len(&self, size: u64) -> Result<(), String> {
        let file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.set_len(size).map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "metadata")]
    pub fn metadata(&self) -> Result<metadata::StephpCapStdMetadata, String> {
        let file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let metadata = file.metadata().map_err(|e| e.to_string())?;
        Ok(metadata::StephpCapStdMetadata { inner: metadata })
    }

    #[php(name = "set_permissions")]
    pub fn set_permissions(&self, permissions: &StephpCapStdPermissions) -> Result<(), String> {
        let permissions = permissions.inner.borrow();
        let file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.set_permissions(permissions.clone())
            .map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "read")]
    pub fn read(&self, length: usize) -> Result<ext_php_rs::binary::Binary<u8>, String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let mut data = vec![0u8; length];
        let bytes_read = file.read(&mut data).map_err(|e| e.to_string())?;
        data.truncate(bytes_read);
        Ok(ext_php_rs::binary::Binary::from(data))
    }
}
