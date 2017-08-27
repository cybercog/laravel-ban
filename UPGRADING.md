# Upgrade Guide

- [From v2 to v3](#from-v2-to-v3)

## From v2 to v3

Because there are many breaking changes an upgrade is not that easy. There are many edge cases this guide does not cover.
We accept PRs to improve this guide.

Find and replace: 

- Find all `Cog\Ban\Contracts\Ban` and replace with `Cog\Contracts\Ban\Ban`
- Find all `Cog\Ban\Contracts\HasBans` and replace with `Cog\Contracts\Ban\Bannable`
- Find all `Cog\Ban\Contracts\BanService` and replace with `Cog\Contracts\Ban\BanService`
- Find all `Cog\Ban\Traits\HasBans` and replace with `Cog\Laravel\Ban\Traits\Bannable`
- Find all `Cog\Ban` and replace with `Cog\Laravel\Ban`

In classes which works with bans:

- Find `Ban::whereOwnedBy` replace with `Ban::whereBannable`
- Find calls of methods or attributes on the Ban model like `ownedBy`, `owner`, `getOwner` and replace them with `bannable`

These database changes should be performed:

- Rename `ban` table to `bans`
- Rename `bans` database column `owned_by_id` to `bannable_id`
- Rename `bans` database column `owned_by_type` to `bannable_type`
- Update name of migration file:
```mysql
UPDATE migrations SET migration = '2017_03_04_000000_create_bans_table' WHERE migration = '2017_03_04_000000_create_ban_table';
```

Migration files:

- Delete `database/migrations/2017_03_04_000000_create_ban_table.php` migration file (from v3 service provider automatically loading migration files or republish it if custom changes are required to be done).
