# Upgrade Guide

- [From v2 to v3](#from-v2-to-v3)

## From v2 to v3

Because there are many breaking changes an upgrade is not that easy. There are many edge cases this guide does not cover.
We accept PRs to improve this guide.

You can upgrade from v2 to v3 by performing these renames in your bannable models:

- `Cog\Ban\Traits\HasBans` has been renamed to `Cog\Ban\Traits\Bannable`
- `Cog\Ban\Contracts\HasBans` has been renamed to `Cog\Ban\Contracts\Bannable`

These database changes should be performed:

- Rename `ban` table to `bans`
- Rename `bans` database column `owned_by_id` to `bannable_id`
- Rename `bans` database column `owned_by_type` to `bannable_type`
