#![cfg_attr(windows, feature(abi_vectorcall))]

#[cfg(unix)]
use cap_std::fs::PermissionsExt;

use ext_php_rs::prelude::*;
use std::cell::RefCell;

#[php_class]
pub struct StephpCapStdPermissions {
    pub inner: RefCell<cap_std::fs::Permissions>,
}

#[php_impl]
impl StephpCapStdPermissions {
    #[php(name = "readonly")]
    pub fn readonly(&self) -> bool {
        self.inner.borrow().readonly()
    }

    #[php(name = "set_readonly")]
    pub fn set_readonly(&self, readonly: bool) {
        self.inner.borrow_mut().set_readonly(readonly)
    }

    #[php(name = "mode")]
    pub fn mode(&self) -> u32 {
        #[cfg(unix)]
        {
            self.inner.borrow().mode()
        }
        #[cfg(not(unix))]
        0
    }

    #[php(name = "set_mode")]
    pub fn set_mode(&self, mode: u32) {
        #[cfg(unix)]
        {
            self.inner.borrow_mut().set_mode(mode)
        }
    }
}
