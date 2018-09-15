# Changelog

All notable changes to `laravel-ban` will be documented in this file.

## [3.3.0] - 2018-09-16

### Added

- ([#27](https://github.com/cybercog/laravel-ban/pull/27)) Add `isPermanent` & `isTemporary` ban checks

## [3.2.0] - 2018-09-09

### Added

- ([#26](https://github.com/cybercog/laravel-ban/pull/26)) Laravel 5.7 support
- ([#25](https://github.com/cybercog/laravel-ban/pull/25)) Middleware to force logout banned users

## [3.1.0] - 2018-02-08

### Added

- ([#18](https://github.com/cybercog/laravel-ban/pull/18)) Laravel 5.6 support

## [3.0.0] - 2017-08-27

### Added

- ([#7](https://github.com/cybercog/laravel-ban/pull/7)) Laravel 5.5 support
- ([#8](https://github.com/cybercog/laravel-ban/pull/8)) Add package auto discovery for L5.5
- Auto-loading migrations

### Changed

- `Cog\Ban\Contracts\Ban` moved to `Cog\Contracts\Ban\Ban`
- `Cog\Ban\Contracts\HasBans` moved to `Cog\Contracts\Ban\HasBans`
- `Cog\Ban\Contracts\BanService` moved to `Cog\Contracts\Ban\BanService`
- All classes namespaces moved from `Cog\Ban\*` to `Cog\Laravel\Ban\*`
- Renamed database table `ban` to `bans`
- Renamed database column `owned_by_id` to `bannable_id`
- Renamed database column `owned_by_type` to `bannable_type`
- Renamed trait `HasBans` to `Bannable`
- Renamed contract `HasBans` to `Bannable`
- Renamed `Ban::whereOwnedBy($bannable)` to `Ban::whereBannable($bannable)`
- Renamed Ban model relation `ownedBy` to `bannable`

### Removed

- ([#9](https://github.com/cybercog/laravel-ban/pull/9)) Dropped Laravel Ownership Dependency
- Removed `owner` method from Ban model
- Removed `getOwner` method from Ban model

## [2.1.0] - 2017-03-21

### Added

- `withBanned`, `withoutBanned`, `onlyBanned` scopes added to all bannable models

### Changed

- `HasBans` is a collection of traits `HasBannedAtHelpers`, `HasBannedAtScope`, `HasBansRelation` now

## [2.0.1] - 2017-03-19

### Changed

- [#4](https://github.com/cybercog/laravel-ban/pull/4) Events properties are public now

## [2.0.0] - 2017-03-06

### Changed

- Contract `CanBeBanned` renamed to `HasBans`
- Trait `CanBeBanned` renamed to `HasBans`

## 1.0.0 - 2017-03-05

- Initial release

[3.2.0]: https://github.com/cybercog/laravel-ban/compare/3.1.0...3.2.0
[3.1.0]: https://github.com/cybercog/laravel-ban/compare/3.0.0...3.1.0
[3.0.0]: https://github.com/cybercog/laravel-ban/compare/2.1.1...3.0.0
[2.1.0]: https://github.com/cybercog/laravel-ban/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/cybercog/laravel-ban/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/cybercog/laravel-ban/compare/1.0.0...2.0.0
