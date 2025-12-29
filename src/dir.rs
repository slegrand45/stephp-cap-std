#![cfg_attr(windows, feature(abi_vectorcall))]

use crate::entries;
use crate::file;
use crate::metadata;
use ext_php_rs::prelude::*;

#[php_class]
pub struct StephpCapStdDir {
    pub inner: cap_std::fs::Dir,
}

#[php_impl]
impl StephpCapStdDir {
    #[php(name = "entries")]
    pub fn entries(&self) -> Result<entries::StephpCapStdEntries, String> {
        let read_dir = self.inner.entries().map_err(|e| e.to_string())?;
        let mut entries = Vec::new();
        for entry in read_dir {
            let entry = entry.map_err(|e| e.to_string())?;
            if let Ok(name) = entry.file_name().into_string() {
                entries.push(name);
            }
        }
        Ok(entries::StephpCapStdEntries::new(entries))
    }

    #[php(name = "read_dir")]
    pub fn read_dir(&self, path: String) -> Result<entries::StephpCapStdEntries, String> {
        let read_dir = self.inner.read_dir(path).map_err(|e| e.to_string())?;
        let mut entries = Vec::new();
        for entry in read_dir {
            let entry = entry.map_err(|e| e.to_string())?;
            if let Ok(name) = entry.file_name().into_string() {
                entries.push(name);
            }
        }
        Ok(entries::StephpCapStdEntries::new(entries))
    }

    #[php(name = "open_dir")]
    pub fn open_dir(&self, path: String) -> Result<Self, String> {
        let dir = self.inner.open_dir(path).map_err(|e| e.to_string())?;
        Ok(StephpCapStdDir { inner: dir })
    }

    #[php(name = "open")]
    pub fn open(&self, path: String) -> Result<file::StephpCapStdFile, String> {
        let fd = self.inner.open(path).map_err(|e| e.to_string())?;
        Ok(file::StephpCapStdFile { inner: fd })
    }

    #[php(name = "create_dir")]
    pub fn create_dir(&self, path: String) -> Result<(), String> {
        match self.inner.create_dir(path) {
            Ok(_) => Ok(()),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "create_dir_all")]
    pub fn create_dir_all(&self, path: String) -> Result<(), String> {
        match self.inner.create_dir_all(path) {
            Ok(_) => Ok(()),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "copy")]
    pub fn copy(&self, from: String, to_dir: &StephpCapStdDir, to: String) -> Result<u64, String> {
        match self.inner.copy(from, &to_dir.inner, to) {
            Ok(size) => Ok(size),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "dir_metadata")]
    pub fn dir_metadata(&self) -> Result<metadata::StephpCapStdMetadata, String> {
        let metadata = self.inner.dir_metadata().map_err(|e| e.to_string())?;
        Ok(metadata::StephpCapStdMetadata { inner: metadata })
    }
}
