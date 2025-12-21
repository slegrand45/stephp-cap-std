#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::{prelude::*, zend::ce};
use std::sync::Mutex;

#[php_class]
pub struct StephpCapStdAmbientAuthority {
    pub authority: Mutex<cap_std::AmbientAuthority>,
}

#[php_class]
pub struct StephpCapStdDir {
    pub inner: Mutex<cap_std::fs::Dir>,
}

#[php_class]
#[php(implements(ce = ce::countable, stub = "\\Countable"))]
#[php(implements(ce = ce::iterator, stub = "\\Iterator"))]
pub struct StephpCapStdEntries {
    entries: Vec<String>,
    current_index: usize,
}

#[php_impl]
impl StephpCapStdDir {
    #[php(name = "entries")]
    pub fn entries(&self) -> Result<StephpCapStdEntries, String> {
        let inner = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let read_dir = inner.entries().map_err(|e| e.to_string())?;
        let mut entries = Vec::new();
        for entry in read_dir {
            let entry = entry.map_err(|e| e.to_string())?;
            if let Ok(name) = entry.file_name().into_string() {
                entries.push(name);
            }
        }
        Ok(StephpCapStdEntries::new(entries))
    }

    #[php(name = "read_dir")]
    pub fn read_dir(&self, path: String) -> Result<StephpCapStdEntries, String> {
        let inner = self
            .inner
            .lock()
            .map_err(|_| "Mutex lock error".to_string())?;
        let read_dir = inner.read_dir(path).map_err(|e| e.to_string())?;
        let mut entries = Vec::new();
        for entry in read_dir {
            let entry = entry.map_err(|e| e.to_string())?;
            if let Ok(name) = entry.file_name().into_string() {
                entries.push(name);
            }
        }
        Ok(StephpCapStdEntries::new(entries))
    }
}

#[php_impl]
impl StephpCapStdEntries {
    pub fn new(entries: Vec<String>) -> Self {
        Self {
            entries,
            current_index: 0,
        }
    }

    pub fn count(&self) -> usize {
        self.entries.len()
    }

    pub fn rewind(&mut self) {
        self.current_index = 0;
    }

    pub fn current(&self) -> Option<String> {
        self.entries.get(self.current_index).cloned()
    }

    pub fn key(&self) -> usize {
        self.current_index
    }

    pub fn next(&mut self) {
        self.current_index += 1;
    }

    pub fn valid(&self) -> bool {
        self.current_index < self.entries.len()
    }
}

#[php_function]
pub fn stephp_cap_std_ambient_authority() -> StephpCapStdAmbientAuthority {
    StephpCapStdAmbientAuthority {
        authority: Mutex::new(cap_std::ambient_authority()),
    }
}

#[php_function]
pub fn stephp_cap_std_open_ambient_dir(
    auth: &StephpCapStdAmbientAuthority,
    path: String,
) -> Result<StephpCapStdDir, String> {
    let authority = auth
        .authority
        .lock()
        .map_err(|_| "Mutex lock error".to_string())?;
    let dir = cap_std::fs::Dir::open_ambient_dir(&path, *authority)
        .map_err(|e| format!("Unable to open '{}' : {}", path, e))?;
    Ok(StephpCapStdDir {
        inner: Mutex::new(dir),
    })
}

#[php_module]
pub fn get_module(module: ModuleBuilder) -> ModuleBuilder {
    module
        .function(wrap_function!(stephp_cap_std_ambient_authority))
        .function(wrap_function!(stephp_cap_std_open_ambient_dir))
        .class::<StephpCapStdAmbientAuthority>()
        .class::<StephpCapStdDir>()
        .class::<StephpCapStdEntries>()
}
