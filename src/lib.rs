#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::{prelude::*, zend::ce};

#[php_class]
pub struct StephpCapStdAmbientAuthority {
    pub authority: cap_std::AmbientAuthority,
}

#[php_class]
pub struct StephpCapStdDir {
    pub inner: cap_std::fs::Dir,
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
        let read_dir = self.inner.entries().map_err(|e| e.to_string())?;
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
        let read_dir = self.inner.read_dir(path).map_err(|e| e.to_string())?;
        let mut entries = Vec::new();
        for entry in read_dir {
            let entry = entry.map_err(|e| e.to_string())?;
            if let Ok(name) = entry.file_name().into_string() {
                entries.push(name);
            }
        }
        Ok(StephpCapStdEntries::new(entries))
    }

    #[php(name = "open_dir")]
    pub fn open_dir(&self, path: String) -> Result<Self, String> {
        let dir = self.inner.open_dir(path).map_err(|e| e.to_string())?;
        Ok(StephpCapStdDir { inner: dir })
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
        authority: cap_std::ambient_authority(),
    }
}

#[php_function]
pub fn stephp_cap_std_open_ambient_dir(
    auth: &StephpCapStdAmbientAuthority,
    path: String,
) -> Result<StephpCapStdDir, String> {
    let dir = cap_std::fs::Dir::open_ambient_dir(&path, auth.authority)
        .map_err(|e| format!("Unable to open '{}' : {}", path, e))?;
    Ok(StephpCapStdDir {
        inner: dir,
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
