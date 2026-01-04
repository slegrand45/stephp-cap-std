#![cfg_attr(windows, feature(abi_vectorcall))]

use crate::metadata;
use crate::permissions::StephpCapStdPermissions;
use ext_php_rs::binary::Binary;
use ext_php_rs::binary_slice::BinarySlice;
use ext_php_rs::prelude::*;
use std::io::Read;
use std::io::Seek;
use std::io::Write;
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
    pub fn read(&self, length: usize) -> Result<Binary<u8>, String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let mut data = vec![0u8; length];
        let bytes_read = file.read(&mut data).map_err(|e| e.to_string())?;
        data.truncate(bytes_read);
        Ok(Binary::from(data))
    }

    #[php(name = "read_to_end")]
    pub fn read_to_end(&self) -> Result<Binary<u8>, String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let mut data = Vec::new();
        let bytes_read = file.read_to_end(&mut data).map_err(|e| e.to_string())?;
        data.truncate(bytes_read);
        Ok(Binary::from(data))
    }

    #[php(name = "read_to_string")]
    pub fn read_to_string(&self) -> Result<String, String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let mut data = String::new();
        let bytes_read = file.read_to_string(&mut data).map_err(|e| e.to_string())?;
        data.truncate(bytes_read);
        Ok(data)
    }

    #[php(name = "write")]
    pub fn write(&self, data: BinarySlice<u8>) -> Result<usize, String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.write(&data).map_err(|e| format!("Write error: {}", e))
    }

    #[php(name = "flush")]
    pub fn flush(&self) -> Result<(), String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.flush().map_err(|e| format!("Flush error: {}", e))?;
        Ok(())
    }

    #[php(name = "rewind")]
    pub fn rewind(&self) -> Result<(), String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.rewind().map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "stream_position")]
    pub fn stream_position(&self) -> Result<u64, String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let pos = file.stream_position().map_err(|e| e.to_string())?;
        Ok(pos)
    }

    #[php(name = "seek_relative")]
    pub fn seek_relative(&self, offset: i64) -> Result<(), String> {
        let mut file = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        file.seek_relative(offset).map_err(|e| e.to_string())?;
        Ok(())
    }
}
