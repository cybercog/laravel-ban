# Changelog

All notable changes to `cybercog/laravel-ban` will be documented in this file.

## [Unreleased]

## [4.9.0] - 2024-03-05

### Added

- ([#95]) Added Laravel 11 support

## [4.8.0] - 2023-02-24

### Added

- ([#89]) Added Laravel 10 support

### Removed

- ([#89]) Dropped PHP 7.x support
- ([#89]) Dropped Laravel 5.5 support
- ([#89]) Dropped Laravel 5.6 support
- ([#89]) Dropped Laravel 5.7 support
- ([#89]) Dropped Laravel 5.8 support
- ([#89]) Dropped Laravel 6 support
- ([#89]) Dropped Laravel 7 support
- ([#89]) Dropped Laravel 8 support

## [4.7.0] - 2022-02-05

### Added

- ([#81]) Added Laravel 9 support

## [4.6.1] - 2021-03-18

### Fixed

- ([#72]) Fixed typo in `LogsOutBannedUser` middleware variable

## [4.6.0] - 2021-03-08

### Added

- ([#71]) Added Inertia support

## [4.5.0] - 2020-12-05

### Added

- ([#66]) Added PHP 8.x support

## [4.4.0] - 2020-09-26

### Added

- ([#63]) Added configurable redirect url for the banned users

## [4.3.0] - 2020-09-09

### Added

- ([#61]) Added Laravel 8.x support

## [4.2.1] - 2020-03-06

### Added

- Added Laravel 7.x support

## [4.2.0] - 2019-09-26

### Added

- ([#50]) Added publishable configuration file
- ([#50]) Added ability to ignore default migrations

## [4.1.0] - 2019-09-04

### Added

- ([#48]) Laravel 6.0 support

## [4.0.0] - 2019-02-26

### Added

- Laravel 5.8 support

### Changed

- All methods are strict typed now

### Removed

- Laravel 5.1, 5.2, 5.3 and 5.4 support

## [3.5.0] - 2018-10-07

### Added

- ([#35]) Ban `created_by_type` & `created_by_id` are fillable now

## [3.4.0] - 2018-09-21

### Added

- ([#29]) Add `datetime` cast for the `deleted_at` attribute

### Fixed

- ([#30]) Fixed bannable models ban & unban with applied BannedAtScope

## [3.3.0] - 2018-09-16

### Added

- ([#27]) Add `isPermanent` & `isTemporary` ban checks

### Fixed

- ([#27]) Stop trying to parse `null` value for `expired_at` as Carbon value

## [3.2.0] - 2018-09-09

### Added

- ([#26]) Laravel 5.7 support
- ([#25]) Middleware to force logout banned users

## [3.1.0] - 2018-02-08

### Added

- ([#18]) Laravel 5.6 support

## [3.0.0] - 2017-08-27

### Added

- ([#7]) Laravel 5.5 support
- ([#8]) Add package auto discovery for L5.5
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

- ([#9]) Dropped Laravel Ownership Dependency
- Removed `owner` method from Ban model
- Removed `getOwner` method from Ban model

## [2.1.0] - 2017-03-21

### Added

- `withBanned`, `withoutBanned`, `onlyBanned` scopes added to all bannable models

### Changed

- `HasBans` is a collection of traits `HasBannedAtHelpers`, `HasBannedAtScope`, `HasBansRelation` now

## [2.0.1] - 2017-03-19

### Changed

- ([#4]) Events properties are public now

## [2.0.0] - 2017-03-06

### Changed

- Contract `CanBeBanned` renamed to `HasBans`
- Trait `CanBeBanned` renamed to `HasBans`

## 1.0.0 - 2017-03-05

- Initial release

[Unreleased]: https://github.com/cybercog/laravel-ban/compare/4.9.0...master
[4.9.0]: https://github.com/cybercog/laravel-ban/compare/4.8.0...4.9.0
[4.8.0]: https://github.com/cybercog/laravel-ban/compare/4.7.0...4.8.0
[4.7.0]: https://github.com/cybercog/laravel-ban/compare/4.6.1...4.7.0
[4.6.1]: https://github.com/cybercog/laravel-ban/compare/4.6.0...4.6.1
[4.6.0]: https://github.com/cybercog/laravel-ban/compare/4.5.0...4.6.0
[4.5.0]: https://github.com/cybercog/laravel-ban/compare/4.4.0...4.5.0
[4.4.0]: https://github.com/cybercog/laravel-ban/compare/4.3.0...4.4.0
[4.3.0]: https://github.com/cybercog/laravel-ban/compare/4.2.1...4.3.0
[4.2.1]: https://github.com/cybercog/laravel-ban/compare/4.2.0...4.2.1
[4.2.0]: https://github.com/cybercog/laravel-ban/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/cybercog/laravel-ban/compare/4.0.0...4.1.0
[4.0.0]: https://github.com/cybercog/laravel-ban/compare/3.5.0...4.0.0
[3.5.0]: https://github.com/cybercog/laravel-ban/compare/3.4.0...3.5.0
[3.4.0]: https://github.com/cybercog/laravel-ban/compare/3.3.0...3.4.0
[3.3.0]: https://github.com/cybercog/laravel-ban/compare/3.2.0...3.3.0
[3.2.0]: https://github.com/cybercog/laravel-ban/compare/3.1.0...3.2.0
[3.1.0]: https://github.com/cybercog/laravel-ban/compare/3.0.0...3.1.0
[3.0.0]: https://github.com/cybercog/laravel-ban/compare/2.1.1...3.0.0
[2.1.0]: https://github.com/cybercog/laravel-ban/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/cybercog/laravel-ban/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/cybercog/laravel-ban/compare/1.0.0...2.0.0

[#95]: https://github.com/cybercog/laravel-ban/pull/95
[#89]: https://github.com/cybercog/laravel-ban/pull/89
[#81]: https://github.com/cybercog/laravel-ban/pull/81
[#72]: https://github.com/cybercog/laravel-ban/pull/72
[#71]: https://github.com/cybercog/laravel-ban/pull/71
[#66]: https://github.com/cybercog/laravel-ban/pull/66
[#63]: https://github.com/cybercog/laravel-ban/pull/63
[#61]: https://github.com/cybercog/laravel-ban/pull/61
[#50]: https://github.com/cybercog/laravel-ban/pull/50
[#48]: https://github.com/cybercog/laravel-ban/pull/48
[#35]: https://github.com/cybercog/laravel-ban/pull/35
[#30]: https://github.com/cybercog/laravel-ban/pull/30
[#29]: https://github.com/cybercog/laravel-ban/pull/29
[#27]: https://github.com/cybercog/laravel-ban/pull/27
[#26]: https://github.com/cybercog/laravel-ban/pull/26
[#25]: https://github.com/cybercog/laravel-ban/pull/25
[#18]: https://github.com/cybercog/laravel-ban/pull/18
[#9]: https://github.com/cybercog/laravel-ban/pull/9
[#8]: https://github.com/cybercog/laravel-ban/pull/8
[#7]: https://github.com/cybercog/laravel-ban/pull/7
[#4]: https://github.com/cybercog/laravel-ban/pull/4
