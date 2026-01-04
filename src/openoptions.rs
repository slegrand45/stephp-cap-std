#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;
use std::sync::Mutex;

#[php_class]
pub struct StephpCapStdOpenOptions {
    pub inner: Mutex<cap_std::fs::OpenOptions>,
}

#[php_impl]
impl StephpCapStdOpenOptions {
    pub fn new() -> Self {
        Self {
            inner: Mutex::new(cap_std::fs::OpenOptions::new()),
        }
    }

    #[php(name = "read")]
    pub fn read(&mut self, read: bool) {
        if let Ok(mut options) = self.inner.lock() {
            options.read(read);
        }
    }

    #[php(name = "write")]
    pub fn write(&mut self, read: bool) {
        if let Ok(mut options) = self.inner.lock() {
            options.write(read);
        }
    }

    #[php(name = "append")]
    pub fn append(&mut self, read: bool) {
        if let Ok(mut options) = self.inner.lock() {
            options.append(read);
        }
    }

    #[php(name = "truncate")]
    pub fn truncate(&mut self, read: bool) {
        if let Ok(mut options) = self.inner.lock() {
            options.truncate(read);
        }
    }

    #[php(name = "create")]
    pub fn create(&mut self, read: bool) {
        if let Ok(mut options) = self.inner.lock() {
            options.create(read);
        }
    }

    #[php(name = "create_new")]
    pub fn create_new(&mut self, read: bool) {
        if let Ok(mut options) = self.inner.lock() {
            options.create_new(read);
        }
    }
}
