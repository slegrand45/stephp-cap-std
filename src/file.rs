#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;
use crate::metadata;
use crate::permissions::StephpCapStdPermissions;

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

    #[php(name = "sync_data")]
    pub fn sync_data(&self) -> Result<(), String> {
        self.inner.sync_data().map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "set_len")]
    pub fn set_len(&self, size: u64) -> Result<(), String> {
        self.inner.set_len(size).map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "metadata")]
    pub fn metadata(&self) -> Result<metadata::StephpCapStdMetadata, String> {
        let metadata = self.inner.metadata().map_err(|e| e.to_string())?;
        Ok(metadata::StephpCapStdMetadata { inner: metadata })
    }

    #[php(name = "set_permissions")]
    pub fn set_permissions(&self, permissions: &StephpCapStdPermissions) -> Result<(), String> {
        let permissions = permissions.inner.borrow();
        self.inner.set_permissions(permissions.clone()).map_err(|e| e.to_string())?;
        Ok(())
    }
}