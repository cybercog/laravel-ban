# Laravel Ban

![cog-laravel-ban](https://user-images.githubusercontent.com/1849174/44558308-1d8e0580-a74c-11e8-8e2a-ec297bbc3f12.png)

<p align="center">
<a href="https://discord.gg/nAZBEkH"><img src="https://img.shields.io/static/v1?logo=discord&label=&message=Discord&color=36393f&style=flat-square" alt="Discord"></a>
<a href="https://github.com/cybercog/laravel-ban/releases"><img src="https://img.shields.io/github/release/cybercog/laravel-ban.svg?style=flat-square" alt="Releases"></a>
<a href="https://github.com/cybercog/laravel-ban/actions/workflows/tests.yml"><img src="https://img.shields.io/github/actions/workflow/status/cybercog/laravel-ban/tests.yml?style=flat-square" alt="Build"></a>
<a href="https://styleci.io/repos/83971055"><img src="https://styleci.io/repos/83971055/shield" alt="StyleCI"></a>
<a href="https://scrutinizer-ci.com/g/cybercog/laravel-ban/?branch=master"><img src="https://img.shields.io/scrutinizer/g/cybercog/laravel-ban.svg?style=flat-square" alt="Code Quality"></a>
<a href="https://github.com/cybercog/laravel-ban/blob/master/LICENSE"><img src="https://img.shields.io/github/license/cybercog/laravel-ban.svg?style=flat-square" alt="License"></a>
</p>

## Introduction

Laravel Ban simplify management of Eloquent model's ban. Make any model bannable in a minutes!

Use case is not limited to User model, any Eloquent model could be banned: Organizations, Teams, Groups and others.

## Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
  - [Prepare bannable model](#prepare-bannable-model)
  - [Prepare bannable model database table](#prepare-bannable-model-database-table)
  - [Available methods](#available-methods)
  - [Scopes](#scopes)
  - [Events](#events)
  - [Middleware](#middleware)
  - [Scheduling](#scheduling)
- [Integrations](#integrations)
- [Changelog](#changelog)
- [Upgrading](#upgrading)
- [Contributing](#contributing)
- [Testing](#testing)
- [Security](#security)
- [Contributors](#contributors)
- [Alternatives](#alternatives)
- [License](#license)
- [About CyberCog](#about-cybercog)

## Features

- Model can have many bans.
- Removed bans kept in history as soft deleted records.
- Most parts of the logic is handled by the `BanService`.
- Has middleware to prevent banned user route access.
- Use case is not limited to `User` model, any Eloquent model could be banned.
- Events firing on models `ban` and `unban`.
- Designed to work with Laravel Eloquent models.
- Has [Laravel Nova support](https://github.com/cybercog/laravel-nova-ban).
- Using contracts to keep high customization capabilities.
- Using traits to get functionality out of the box.
- Following PHP Standard Recommendations:
  - [PSR-1 (Basic Coding Standard)](http://www.php-fig.org/psr/psr-1/).
  - [PSR-2 (Coding Style Guide)](http://www.php-fig.org/psr/psr-2/).
  - [PSR-4 (Autoloading Standard)](http://www.php-fig.org/psr/psr-4/).
- Covered with unit tests.

## Installation

First, pull in the package through Composer:

```shell
composer require cybercog/laravel-ban
```

#### Registering package

> The package will automatically register itself. This step required for Laravel 5.4 or earlier releases only.

Include the service provider within `app/config/app.php`:

```php
'providers' => [
    Cog\Laravel\Ban\Providers\BanServiceProvider::class,
],
```

#### Apply database migrations

At last, you need to publish and run database migrations:

```shell
php artisan vendor:publish --provider="Cog\Laravel\Ban\Providers\BanServiceProvider" --tag="migrations"
php artisan migrate
```

## Usage

### Prepare bannable model

```php
use Cog\Contracts\Ban\Bannable as BannableInterface;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements BannableInterface
{
    use Bannable;
}
```

### Prepare bannable model database table

Bannable model must have `nullable timestamp` column named `banned_at`. This value used as flag and simplify checks if user was banned. If you are trying to make default Laravel User model to be bannable you can use example below.

#### Create a new migration file

```shell
php artisan make:migration add_banned_at_column_to_users_table
```

Then insert the following code into migration file:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('banned_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('banned_at');
        });
    }
};
```

### Available methods

#### Apply ban for the entity

```php
$user->ban();
```

#### Apply ban for the entity with reason comment

```php
$user->ban([
    'comment' => 'Enjoy your ban!',
]);
```

#### Apply ban for the entity which will be deleted over time

```php
$user->ban([
    'expired_at' => '2086-03-28 00:00:00',
]);
``` 

`expired_at` attribute could be `\Carbon\Carbon` instance or any string which could be parsed by `\Carbon\Carbon::parse($string)` method:

```php
$user->ban([
    'expired_at' => '+1 month',
]);
``` 

#### Remove ban from entity

```php
$user->unban();
```

On `unban` all related ban models are soft deletes.

#### Check if entity is banned

```php
$user->isBanned();
```

#### Check if entity is not banned

```php
$user->isNotBanned();
```

#### Delete expired bans manually

```php
app(\Cog\Contracts\Ban\BanService::class)->deleteExpiredBans();
```

#### Determine if ban is permanent

```php
$ban = $user->ban();

$ban->isPermanent(); // true
```

Or pass `null` value.

```php
$ban = $user->ban([
   'expired_at' => null,
]);

$ban->isPermanent(); // true
```

#### Determine if ban is temporary

```php
$ban = $user->ban([
   'expired_at' => '2086-03-28 00:00:00',
]);

$ban->isTemporary(); // true
```

### Scopes

#### Get all models which are not banned

```php
$users = User::withoutBanned()->get();
```

#### Get banned and not banned models

```php
$users = User::withBanned()->get();
```

#### Get only banned models

```php
$users = User::onlyBanned()->get();
```

#### Scope auto-apply

To apply query scopes all the time you can define `shouldApplyBannedAtScope` method in bannable model. If method returns `true` all banned models will be hidden by default.

```php
use Cog\Contracts\Ban\Bannable as BannableInterface;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements BannableInterface
{
    use Bannable;
    
    /**
     * Determine if BannedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyBannedAtScope()
    {
        return true;
    }
}
```

### Events

If entity is banned `\Cog\Laravel\Ban\Events\ModelWasBanned` event is fired.

Is entity is unbanned `\Cog\Laravel\Ban\Events\ModelWasUnbanned` event is fired.

### Middleware

This package has route middleware designed to prevent banned users to go to protected routes.

To use it define new middleware in `$routeMiddleware` array of `app/Http/Kernel.php` file:

```php
protected $routeMiddleware = [
    'forbid-banned-user' => \Cog\Laravel\Ban\Http\Middleware\ForbidBannedUser::class,
]
```

Then use it in any routes and route groups you need to protect:

```php
Route::get('/', [
    'uses' => 'UsersController@profile',
    'middleware' => 'forbid-banned-user',
]);
```

If you want force logout banned user on protected routes access, use `LogsOutBannedUser` middleware instead:

```php
protected $routeMiddleware = [
    'logs-out-banned-user' => \Cog\Laravel\Ban\Http\Middleware\LogsOutBannedUser::class,
]
```

### Scheduling

After you have performed the basic installation you can start using the `ban:delete-expired` command. In most cases you'll want to schedule these command so you don't have to manually run it everytime you need to delete expired bans and unban models.

The command can be scheduled in Laravel's console kernel, just like any other command.

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    $schedule->command('ban:delete-expired')->everyMinute();
}
```

Of course, the time used in the code above is just example. Adjust it to suit your own preferences.

## Integrations

- [Laravel Nova Ban](https://github.com/cybercog/laravel-nova-ban)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Upgrading

Please see [UPGRADING](UPGRADING.md) for detailed upgrade instructions.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Testing

Run the tests with:

```shell
vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email open@cybercog.su instead of using the issue tracker.

## Contributors

| <a href="https://github.com/antonkomarev">![@antonkomarev](https://avatars.githubusercontent.com/u/1849174?s=110)<br />Anton Komarev</a> | <a href="https://github.com/badrshs">![@badrshs](https://avatars.githubusercontent.com/u/26596347?s=110)<br />badr aldeen shek salim</a> | <a href="https://github.com/rickmacgillis">![@rickmacgillis](https://avatars.githubusercontent.com/u/8941225?s=110)<br />Rick Mac Gillis</a> | <a href="https://github.com/AnsellC">![@AnsellC](https://avatars.githubusercontent.com/u/2049714?s=110)<br />AnsellC</a> | <a href="https://github.com/joearcher">![@joearcher](https://avatars.githubusercontent.com/u/1125046?s=110)<br />Joe Archer</a> |
| :---: | :---: |:--------------------------------------------------------------------------------------------------------------------------------------------:| :---: | :---: |
| <a href="https://github.com/Im-Fran">![@Im-Fran](https://avatars.githubusercontent.com/u/30329003?s=110)<br />Francisco Solis</a> | <a href="https://github.com/jadamec">![@jadamec](https://avatars.githubusercontent.com/u/19595874?s=110)<br />Jakub Adamec</a> | <a href="https://github.com/ilzrv">![@ilzrv](https://avatars.githubusercontent.com/u/28765966?s=110)<br />Ilia Lazarev</a> | <a href="https://github.com/ZeoKnight">![@ZeoKnight](https://avatars.githubusercontent.com/u/1521472?s=110)<br />ZeoKnight</a> | |

[Laravel Ban contributors list](../../contributors)

## Alternatives

- https://github.com/imanghafoori1/laravel-temp-tag

## License

- `Laravel Ban` package is open-sourced software licensed under the [MIT License](LICENSE) by [Anton Komarev].
- `Fat Boss In Jail` image licensed under [Creative Commons 3.0](https://creativecommons.org/licenses/by/3.0/us/) by Gan Khoon Lay.

## 🌟 Stargazers over time

[![Stargazers over time](https://chart.yhype.me/github/repository-star/v1/MDEwOlJlcG9zaXRvcnk4Mzk3MTA1NQ==.svg)](https://yhype.me?utm_source=github&utm_medium=cybercog-laravel-ban&utm_content=chart-repository-star-cumulative)

## About CyberCog

[CyberCog](https://cybercog.su) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

- [Follow us on Twitter](https://twitter.com/cybercog)
- [Read our articles on Medium](https://medium.com/cybercog)

<a href="https://cybercog.su"><img src="https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png" alt="CyberCog"></a>

[Anton Komarev]: https://komarev.com
