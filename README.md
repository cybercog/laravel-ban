![cog-laravel-ban](https://cloud.githubusercontent.com/assets/1849174/23580161/55a1c060-010d-11e7-9658-efe992bde0a7.png)

<p align="center">
<a href="https://travis-ci.org/cybercog/laravel-ban"><img src="https://img.shields.io/travis/cybercog/laravel-ban/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://styleci.io/repos/83971055"><img src="https://styleci.io/repos/83971055/shield" alt="StyleCI"></a>
<a href="https://github.com/cybercog/laravel-ban/releases"><img src="https://img.shields.io/github/release/cybercog/laravel-ban.svg?style=flat-square" alt="Releases"></a>
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
    - [Events](#events)
    - [Middleware](#middleware)
    - [Scheduling](#scheduling)
- [Change log](#change-log)
- [Contributing](#contributing)
- [Testing](#testing)
- [Security](#security)
- [Credits](#credits)
- [Alternatives](#alternatives)
- [License](#license)
- [About CyberCog](#about-cybercog)

## Features

- Designed to work with Laravel Eloquent models.
- Using contracts to keep high customization capabilities.
- Using traits to get functionality out of the box.
- Model can has many bans.
- Removed bans keeps in history as Soft deleted record.
- Most part of the the logic is handled by the `BanService`.
- Has middleware to prevent banned user route access.
- Use case is not limited to `User` model, any Eloquent model could be banned.
- Events firing on models `ban` and `unban`.
- Covered with unit tests.

## Installation

First, pull in the package through Composer:

```sh
$ composer require cybercog/laravel-ban
```

And then include the service provider within `app/config/app.php`:

```php
'providers' => [
    Cog\Ban\Providers\BanServiceProvider::class,
],
```

At last you need to publish and run database migrations:

```sh
$ php artisan vendor:publish --provider="Cog\Ban\Providers\BanServiceProvider" --tag="migrations"
$ php artisan migrate
```

## Usage

### Prepare bannable model

```php
use Cog\Ban\Contracts\HasBans as HasBansContract;
use Cog\Ban\Traits\HasBans;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasBansContract
{
    use HasBans;
}
```

*Note: `HasBans` contract using `CanBeOwner` contract under the hood. If you are using [`cybercog/laravel-ownership`](https://github.com/cybercog/laravel-ownership) package `CanBeOwner` contract could be omitted from bannable model.*

### Prepare bannable model database table

Bannable model must have `nullable timestamp` column named `banned_at`. This value used as flag and simplify checks if user was banned. If you are trying to make default Laravel User model to be bannable you can use example below.

#### Create a new migration file

```sh
$ php artisan make:migration add_banned_at_column_to_users_table
```

Then insert the following code into migration file:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannedAtColumnToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('banned_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('banned_at');
        });
    }
}
```

### Available methods

#### Apply ban for the entity

```php
$user->bans()->create([]);

$user->ban();
```


#### Apply ban for the entity with reason comment
 
```php
$user->bans()->create([
    'comment' => 'Enjoy your ban!',
]);

$user->ban([
    'comment' => 'Enjoy your ban!',
]);
```

#### Apply ban for the entity which will be deleted over time
 
```php
$user->bans()->create([
    'expired_at' => '+1 month',
]);

$user->ban([
    'expired_at' => '2086-03-28 00:00:00',
]);
```

`expired_at` attribute could be `\Carbon\Carbon` instance or any string which could be parsed by `\Carbon\Carbon::parse($string)` method.

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
app(\Cog\Ban\Services\BanService::class)->deleteExpiredBans();
```

### Events

If entity is banned `\Cog\Ban\Events\ModelWasBanned` event is fired.

Is entity is unbanned `\Cog\Ban\Events\ModelWasUnbanned` event is fired.

### Middleware

This package has route middleware designed to prevent banned users to go to protected routes.

To use it define new middleware in `$routeMiddleware` array of `app/Http/Kernel.php` file:

```php
protected $routeMiddleware = [
    'forbid-banned-user' => \Cog\Ban\Http\Middleware\ForbidBannedUser::class,
]
```

Then use it in any routes and route groups you need to protect:

```php
Route::get('/', [
    'uses' => 'UsersController@profile',
    'middleware' => 'forbid-banned-user',
]);
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

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Testing

Run the tests with:

```sh
$ composer test
```

## Security

If you discover any security related issues, please email a.komarev@cybercog.su instead of using the issue tracker.

## Credits

- [Anton Komarev](https://github.com/a-komarev)
- [All Contributors](../../contributors)

## Alternatives

*Feel free to add more alternatives as Pull Request.* 

## License

- `Laravel Ban` package is open-sourced software licensed under the [MIT License](LICENSE).
- `Fat Boss In Jail` image licensed under [Creative Commons 3.0](https://creativecommons.org/licenses/by/3.0/us/) by Gan Khoon Lay.

## About CyberCog

[CyberCog](http://www.cybercog.ru) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

![cybercog-logo](https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png)
