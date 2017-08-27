# Changelog

All notable changes to `laravel-ban` will be documented in this file.

## [3.0.0] - WIP

### Changed

- `Cog\Ban\Contracts\Ban` moved to `Cog\Contracts\Ban\Ban`
- `Cog\Ban\Contracts\HasBans` moved to `Cog\Contracts\Ban\HasBans`
- `Cog\Ban\Contracts\BanService` moved to `Cog\Contracts\Ban\BanService`
- All classes namespaces changed from `Cog\Ban\*` to `Cog\Laravel\Ban\*`
- Renamed database table `ban` to `bans`
- Renamed database column `owned_by_id` to `bannable_id`
- Renamed database column `owned_by_type` to `bannable_type`
- Renamed trait `HasBans` to `Bannable`
- Renamed contract `HasBans` to `Bannable`
- Renamed `Ban::whereOwnedBy($bannable)` to `Ban::whereBannable($bannable)`
- Renamed Ban model relation `ownedBy` to `bannable`

### Removed

- Dependency Laravel Ownership
- Removed Ban model `owner` method
- Removed Ban model `getOwner` method

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

[3.0.0]: https://github.com/cybercog/laravel-ban/compare/2.1.1...3.0.0
[2.1.0]: https://github.com/cybercog/laravel-ban/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/cybercog/laravel-ban/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/cybercog/laravel-ban/compare/1.0.0...2.0.0
