# laravel-api-auth-sanctum

Laravel Sanctum ?

Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform.


Steps to Follow:

- Login API
- Devices API

Step 1: setup database in .env file

DB_DATABASE=laravel_api

DB_USERNAME=root

DB_PASSWORD=


Step 2: Install Laravel Sanctum

composer require laravel/sanctum


Step 3: Sanctum configuration and migration files Configuration

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"


Step 4: Database migrations execution

php artisan migrate


Step 5: Adding the Sanctum middleware

../app/Http/Kernel.php

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

...

    protected $middlewareGroups = [
        ...

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    ...
],



Step 6: Use tokens for users in user model

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
}


Step 7: Create the seeder for the User model

php artisan make:seeder UsersTableSeeder


Step 8: insert as record using UsersTableSeeder

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
...

...

DB::table('users')->insert([
   
   'name' => 'Zubair Yousaf',
   
   'email' => 'demo@demo.com',
   
   'password' => Hash::make('password')

]);


Step 9: Seed users and devices table

php artisan db:seed --class=UsersTableSeeder


php artisan db:seed --class=DevicesTableSeeder


Step 10: Test with postman

Login Post Request

http://127.0.0.1:8000/api/login

Body:

{
	"email": "zubair.yousaf.boby@gmail.com",
	"password":"password"
}


Step 11: Login API will return the user detail with token, use this token to access the device api.


Get Device Request

http://127.0.0.1:8000/api/device/

Header:

Key: Authorization

Value: Bearer (Return Token i.e Bearer 2|qawgNXYEaQ8itrNn3KrJ2V21qeqQZPiAk4zR4Iuy)

