#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;

#[php_class]
pub struct CapStdAmbientAuthority {
    pub authority: cap_std::AmbientAuthority,
}

#[php_function]
pub fn cap_std_ambient_authority() -> CapStdAmbientAuthority {
    CapStdAmbientAuthority {
        authority: cap_std::ambient_authority(),
    }
}

#[php_module]
pub fn get_module(module: ModuleBuilder) -> ModuleBuilder {
    module
        .function(wrap_function!(cap_std_ambient_authority))
        .class::<CapStdAmbientAuthority>()
}
