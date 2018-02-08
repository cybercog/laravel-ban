# Changelog

All notable changes to `laravel-ban` will be documented in this file.

## [3.1.0] - 2018-02-08

### Added

- Laravel 5.6 support ([#18](https://github.com/cybercog/laravel-ban/pull/18))

## [3.0.0] - 2017-08-27

### Added

- Laravel 5.5 support ([#7](https://github.com/cybercog/laravel-ban/pull/7))
- Add package auto discovery for L5.5 ([#8](https://github.com/cybercog/laravel-ban/pull/8))
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

- Dropped Laravel Ownership Dependency ([#9](https://github.com/cybercog/laravel-ban/pull/9))
- Removed `owner` method from Ban model
- Removed `getOwner` method from Ban model

## [2.1.0] - 2017-03-21

### Added

- `withBanned`, `withoutBanned`, `onlyBanned` scopes added to all bannable models

### Changed

- `HasBans` is a collection of traits `HasBannedAtHelpers`, `HasBannedAtScope`, `HasBansRelation` now

## [2.0.1] - 2017-03-19

### Changed

- Events properties are public now: [#4](https://github.com/cybercog/laravel-ban/pull/4)

## [2.0.0] - 2017-03-06

### Changed

- Contract `CanBeBanned` renamed to `HasBans`
- Trait `CanBeBanned` renamed to `HasBans`

## 1.0.0 - 2017-03-05

- Initial release

[3.1.0]: https://github.com/cybercog/laravel-ban/compare/3.0.0...3.1.0
[3.0.0]: https://github.com/cybercog/laravel-ban/compare/2.1.1...3.0.0
[2.1.0]: https://github.com/cybercog/laravel-ban/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/cybercog/laravel-ban/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/cybercog/laravel-ban/compare/1.0.0...2.0.0
