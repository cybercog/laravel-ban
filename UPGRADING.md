# Upgrade Guide

- [From v2 to v3](#from-v2-to-v3)

## From v2 to v3

Because there are many breaking changes an upgrade is not that easy. There are many edge cases this guide does not cover.
We accept PRs to improve this guide.

In your project find all `Cog\Ban\` and replace with `Cog\Laravel\Ban\`.

In your bannable models:

- `Cog\Laravel\Ban\Traits\HasBans` change to `Cog\Laravel\Ban\Traits\Bannable`
- `Cog\Laravel\Ban\Contracts\HasBans` change to `Cog\Contracts\Ban\Bannable`

In classes which works with bans:

- Find `Ban::whereOwnedBy` replace with `Ban::whereBannable`
- Find calls of methods or attributes on the Ban model like `ownedBy`, `owner`, `getOwner` and replace them with `bannable`

These database changes should be performed:

- Rename `ban` table to `bans`
- Rename `bans` database column `owned_by_id` to `bannable_id`
- Rename `bans` database column `owned_by_type` to `bannable_type`
