#![cfg_attr(windows, feature(abi_vectorcall))]

use crate::entries;
use crate::file;
use crate::metadata;
use ext_php_rs::prelude::*;
use std::sync::Mutex;
use ext_php_rs::binary::Binary;
use ext_php_rs::binary_slice::BinarySlice;

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
    pub fn read_dir(&self, path: &str) -> Result<entries::StephpCapStdEntries, String> {
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
    pub fn open_dir(&self, path: &str) -> Result<Self, String> {
        let dir = self.inner.open_dir(path).map_err(|e| e.to_string())?;
        Ok(StephpCapStdDir { inner: dir })
    }

    #[php(name = "open")]
    pub fn open(&self, path: &str) -> Result<file::StephpCapStdFile, String> {
        let fd = self.inner.open(path).map_err(|e| e.to_string())?;
        Ok(file::StephpCapStdFile {
            inner: Mutex::new(fd),
        })
    }

    #[php(name = "create")]
    pub fn create(&self, path: &str) -> Result<file::StephpCapStdFile, String> {
        let fd = self.inner.create(path).map_err(|e| e.to_string())?;
        Ok(file::StephpCapStdFile {
            inner: Mutex::new(fd),
        })
    }

    #[php(name = "create_dir")]
    pub fn create_dir(&self, path: &str) -> Result<(), String> {
        match self.inner.create_dir(path) {
            Ok(_) => Ok(()),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "create_dir_all")]
    pub fn create_dir_all(&self, path: &str) -> Result<(), String> {
        match self.inner.create_dir_all(path) {
            Ok(_) => Ok(()),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "copy")]
    pub fn copy(&self, from: &str, to_dir: &StephpCapStdDir, to: &str) -> Result<u64, String> {
        match self.inner.copy(from, &to_dir.inner, to) {
            Ok(size) => Ok(size),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "rename")]
    pub fn rename(&self, from: &str, to_dir: &StephpCapStdDir, to: &str) -> Result<(), String> {
        match self.inner.rename(from, &to_dir.inner, to) {
            Ok(_) => Ok(()),
            Err(e) => Err(e.to_string()),
        }
    }

    #[php(name = "dir_metadata")]
    pub fn dir_metadata(&self) -> Result<metadata::StephpCapStdMetadata, String> {
        let metadata = self.inner.dir_metadata().map_err(|e| e.to_string())?;
        Ok(metadata::StephpCapStdMetadata { inner: metadata })
    }

    #[php(name = "canonicalize")]
    pub fn canonicalize(&self, path: &str) -> Result<String, String> {
        let canon = self.inner.canonicalize(path).map_err(|e| e.to_string())?;
        Ok(canon.to_string_lossy().to_string())
    }

    #[php(name = "read")]
    pub fn read(&self, path: &str) -> Result<Binary<u8>, String> {
        let data = self.inner.read(path).map_err(|e| e.to_string())?;
        Ok(Binary::from(data))
    }

    #[php(name = "read_to_string")]
    pub fn read_to_string(&self, path: &str) -> Result<String, String> {
        let s = self.inner.read_to_string(path).map_err(|e| e.to_string())?;
        Ok(s)
    }

    #[php(name = "write")]
    pub fn write(&self, path: &str, data: BinarySlice<u8>) -> Result<(), String> {
        self.inner.write(path, data.as_ref()).map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "remove_dir")]
    pub fn remove_dir(&self, path: &str) -> Result<(), String> {
        self.inner.remove_dir(path).map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "remove_dir_all")]
    pub fn remove_dir_all(&self, path: &str) -> Result<(), String> {
        self.inner.remove_dir_all(path).map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "remove_file")]
    pub fn remove_file(&self, path: &str) -> Result<(), String> {
        self.inner.remove_file(path).map_err(|e| e.to_string())?;
        Ok(())
    }

    #[php(name = "is_file")]
    pub fn is_file(&self, path: &str) -> bool {
        self.inner.is_file(path)
    }

    #[php(name = "is_dir")]
    pub fn is_dir(&self, path: &str) -> bool {
        self.inner.is_dir(path)
    }

    #[php(name = "exists")]
    pub fn exists(&self, path: &str) -> bool {
        self.inner.exists(path)
    }
}
