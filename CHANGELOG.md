# Changelog

All notable changes to `laravel-ban` will be documented in this file.

## [2.1.0] - 2017-03-21

### Added

- `withBanned`, `withoutBanned`, `onlyBanned` scopes added to all bannable models

### Changed

- `HasBans` is a collection of traits `HasBannedAtHelpers`, `HasBannedAtScope`, `HasBansRelation` now.

## [2.0.1] - 2017-03-19

### Changed

- Events properties are public now: [#4](https://github.com/cybercog/laravel-ban/pull/4)

## [2.0.0] - 2017-03-06

### Changed

- Contract `CanBeBanned` renamed to `HasBans`
- Trait `CanBeBanned` renamed to `HasBans`

## 1.0.0 - 2017-03-05

- Initial release

[2.1.0]: https://github.com/cybercog/laravel-ban/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/cybercog/laravel-ban/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/cybercog/laravel-ban/compare/1.0.0...2.0.0
