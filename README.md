 <p><h1 align="center">Crypto Check</h1> </p>
 <img src="https://drive.google.com/uc?id=1BywA25jJOU46WK88iyxrJu0yssrFphMH&export=download" alt="Crypto-logo"/>

This is the backend for the `Crypto check` website.

## Requirements

- :rocket: `Php 8.0.x`
- :hammer: `Composer 2.x.x`

## Stack

- :rocket: [Laravel](https://laravel.com)
- ⚡️ [Laravel websockets](https://beyondco.de/docs/laravel-websockets)

## Recommendation

### Environment
- [Docker](https://www.docker.com)

## Observations

This project have support for redis driver with predis package, you can to use him for cache and/or queue.

## How to run

To run the project follow these steps:

With docker (without requirements but Docker)

```sh
$ run docker-compose up -d (default port is 8000)
$ run docker-compose exec php bash
```

Without docker but with all requirements installed previously
```sh
$ php artisan serve (default port is 8000)
```

Then
```sh
$ Create your .env file (use .env.example as model)
$ Run php artisan migrate
$ Run php artisan key:generate
```



<a href="https://www.paypal.com/donate/?hosted_button_id=DV843N2Z944GC" target="_blank">
  <img src="https://www.buymeacoffee.com/assets/img/guidelines/download-assets-1.svg" alt="Donate-logo"/>
</a>
