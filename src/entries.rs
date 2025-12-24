#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::{prelude::*, zend::ce};

#[php_class]
#[php(implements(ce = ce::countable, stub = "\\Countable"))]
#[php(implements(ce = ce::iterator, stub = "\\Iterator"))]
pub struct StephpCapStdEntries {
    entries: Vec<String>,
    current_index: usize,
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
