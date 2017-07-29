# Upgrade Guide

- [From v2 to v3](#from-v2-to-v3)

## From v2 to v3

Because there are many breaking changes an upgrade is not that easy. There are many edge cases this guide does not cover.
We accept PRs to improve this guide.

In your bannable models:

- `Cog\Ban\Traits\HasBans` change to `Cog\Ban\Traits\Bannable`
- `Cog\Ban\Contracts\HasBans` change to `Cog\Ban\Contracts\Bannable`

In classes which works with bans:

- Find `Ban::whereOwnedBy` replace with `Ban::whereBannable`
- Find calls of methods or attributes on ban model `ownedBy`, `owner`, `getOwner` and replace them with `bannable`

These database changes should be performed:

- Rename `ban` table to `bans`
- Rename `bans` database column `owned_by_id` to `bannable_id`
- Rename `bans` database column `owned_by_type` to `bannable_type`
