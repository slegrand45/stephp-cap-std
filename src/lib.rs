#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;

#[php_class]
pub struct CapStdAmbientAuthority {
    pub authority: cap_std::AmbientAuthority,
}

#[php_class]
pub struct CapStdDir {
    pub inner: cap_std::fs::Dir,
}

#[php_function]
pub fn cap_std_ambient_authority() -> CapStdAmbientAuthority {
    CapStdAmbientAuthority {
        authority: cap_std::ambient_authority(),
    }
}

#[php_function]
pub fn cap_std_open_ambient_dir(auth: &CapStdAmbientAuthority, path: String) -> Result<CapStdDir, String> {
    let dir = cap_std::fs::Dir::open_ambient_dir(&path, auth.authority)
        .map_err(|e| format!("Unable to open '{}' : {}", path, e))?;
    Ok(CapStdDir { inner: dir })
}

#[php_module]
pub fn get_module(module: ModuleBuilder) -> ModuleBuilder {
    module
        .function(wrap_function!(cap_std_ambient_authority))
        .function(wrap_function!(cap_std_open_ambient_dir))
        .class::<CapStdAmbientAuthority>()
        .class::<CapStdDir>()
}
