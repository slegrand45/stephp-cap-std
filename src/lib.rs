#![cfg_attr(windows, feature(abi_vectorcall))]

mod dir;
mod entries;
mod file;
mod filetype;
mod metadata;
mod permissions;
mod systemtime;

use std::cell::RefCell;
use ext_php_rs::prelude::*;

#[php_class]
pub struct StephpCapStdAmbientAuthority {
    pub authority: cap_std::AmbientAuthority,
}

#[php_function]
pub fn stephp_cap_std_ambient_authority() -> StephpCapStdAmbientAuthority {
    StephpCapStdAmbientAuthority {
        authority: cap_std::ambient_authority(),
    }
}

#[php_function]
pub fn stephp_cap_std_open_ambient_dir(
    auth: &StephpCapStdAmbientAuthority,
    path: String,
) -> Result<dir::StephpCapStdDir, String> {
    let dir = cap_std::fs::Dir::open_ambient_dir(&path, auth.authority)
        .map_err(|e| format!("Unable to open '{}' : {}", path, e))?;
    Ok(dir::StephpCapStdDir { inner: dir })
}

#[cfg(unix)]
#[php_function]
pub fn stephp_cap_std_permissions_from_mode(mode: u32) -> permissions::StephpCapStdPermissions {
    permissions::StephpCapStdPermissions {
        inner: RefCell::new(cap_std::fs::PermissionsExt::from_mode(mode))
    }
}

#[php_module]
pub fn get_module(module: ModuleBuilder) -> ModuleBuilder {
    module
        .function(wrap_function!(stephp_cap_std_ambient_authority))
        .function(wrap_function!(stephp_cap_std_open_ambient_dir))
        .function(wrap_function!(stephp_cap_std_permissions_from_mode))
        .class::<StephpCapStdAmbientAuthority>()
        .class::<dir::StephpCapStdDir>()
        .class::<entries::StephpCapStdEntries>()
        .class::<metadata::StephpCapStdMetadata>()
        .class::<file::StephpCapStdFile>()
        .class::<filetype::StephpCapStdFileType>()
        .class::<systemtime::StephpCapStdSystemTime>()
        .class::<permissions::StephpCapStdPermissions>()
}
