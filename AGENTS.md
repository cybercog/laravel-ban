# AGENTS.md

This file provides guidance to LLM Agents when working with code in this repository.

## Project Overview

Laravel Ban (`cybercog/laravel-ban`) is a Laravel package for banning/unbanning any Eloquent model. It uses a polymorphic `bans` table with soft deletes to maintain ban history, and a `banned_at` timestamp flag on the bannable model for quick status checks.

## Commands

All commands run inside Docker. Use the `php84` service (or any other PHP version service from `compose.yml`).

```bash
# Build and start the container
docker compose up -d php85

# Install dependencies
docker compose exec php85 composer install

# Run all tests
docker compose exec php85 composer test

# Run a single test file
docker compose exec php85 vendor/bin/phpunit tests/Unit/Models/BanTest.php

# Run a single test method
docker compose exec php85 vendor/bin/phpunit --filter test_method_name

# Run tests with details
docker compose exec php85 vendor/bin/phpunit --testdox
```

Available PHP services: `php81`, `php82`, `php83`, `php84`, `php85`.

No dedicated lint or build commands are configured. Code style follows the Laravel StyleCI preset (PSR-2 based).

## Architecture

### Namespace layout

- `Cog\Contracts\Ban\` (`contracts/`) — Interfaces: `Ban`, `Bannable`, `BanService`
- `Cog\Laravel\Ban\` (`src/`) — Implementations
- `Cog\Tests\Laravel\Ban\` (`tests/`) — Tests using Orchestra Testbench

### How banning works (the flow)

1. **User calls** `$model->ban($attributes)` (from `HasBannedAtHelpers` trait)
2. **Delegates to** `BanService::ban()` which creates a `Ban` morph record via `$bannable->bans()->create()`
3. **BanObserver::created()** fires, sets `banned_at` on the bannable model, dispatches `ModelWasBanned` event
4. **On unban**: `BanService::unban()` soft-deletes all ban records → `BanObserver::deleted()` fires → clears `banned_at` flag, dispatches `ModelWasUnbanned` event

### Key design decisions

- **Contracts-first**: All core types have interfaces in `contracts/`. The service provider binds `BanContract` → `Ban` model and `BanServiceContract` → `BanService` as singleton.
- **Composite trait**: `Bannable` trait composes `HasBannedAtHelpers` (ban/unban/isBanned methods), `HasBannedAtScope` (auto-apply global scope), and `HasBansRelation` (morphMany relationship).
- **Observer pattern**: `BanObserver` handles setting/unsetting the `banned_at` flag and firing events—logic is not in the model or service.
- **Bans use SoftDeletes**: Unbanning soft-deletes ban records, keeping history. The `bans()` relation only returns active (non-deleted) bans.

### Testing

Tests extend `AbstractTestCase` (Orchestra Testbench). The base class handles publishing migrations, running them on an in-memory SQLite database, and registering model factories. Test stubs live in `tests/Stubs/Models/`, factories in `tests/database/factories/`.

## Supported versions

PHP 8.0+, Laravel 9–13, with corresponding Orchestra Testbench versions. CI tests against PHP 8.0–8.5 with prefer-lowest and prefer-stable dependency resolution.
