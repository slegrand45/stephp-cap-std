#![cfg_attr(windows, feature(abi_vectorcall))]

use ext_php_rs::prelude::*;

#[php_class]
pub struct StephpCapStdSystemTime {
    pub inner: cap_std::time::SystemTime,
}

#[php_impl]
impl StephpCapStdSystemTime {
    #[php(name = "from_unix_timestamp")]
    pub fn from_unix_timestamp(seconds: u64) -> Self {
        let std_time = std::time::UNIX_EPOCH + std::time::Duration::from_secs(seconds);
        Self {
            inner: cap_std::time::SystemTime::from_std(std_time),
        }
    }

    #[php(name = "to_unix_timestamp_seconds_utc")]
    pub fn to_unix_timestamp_seconds_utc(&self) -> u64 {
        let std_epoch = std::time::UNIX_EPOCH;
        let cap_epoch = cap_std::time::SystemTime::from_std(std_epoch);
        match self.inner.duration_since(cap_epoch) {
            Ok(duration) => duration.as_secs(),
            Err(_) => 0,
        }
    }
}
