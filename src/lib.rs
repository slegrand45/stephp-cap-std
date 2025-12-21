#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;

#[php_class]
pub struct PhpAmbientAuthority {
    pub authority: cap_std::AmbientAuthority,
}

#[php_function]
pub fn get_ambient_authority() -> PhpAmbientAuthority {
    PhpAmbientAuthority {
        authority: cap_std::ambient_authority(),
    }
}

#[php_module]
pub fn get_module(module: ModuleBuilder) -> ModuleBuilder {
    module.function(wrap_function!(get_ambient_authority))
}
