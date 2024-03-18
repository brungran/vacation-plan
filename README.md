<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to Run This Project

This project has been made using Docker so it's more convinient to get it up and running:

1. Clone the repo.
2. Run
    ```sh
    composer update
    ```
3. Run
    ```sh
    ./vendor/bin/sail up -d
    ```
    You might need to disable whatever is running on port 80, wich is usually apache2.
4. Run
    ```sh
    ./vendor/bin/sail artisan migrate:refresh --seed
    ```
5. Run
    ```sh
    ./vendor/bin/sail artisan install:api --passport
    ```
6. Run
    ```sh
    ./vendor/bin/sail artisan passport:client --personal
    ```
    Set PASSPORT_PERSONAL_ACCESS_CLIENT_ID and PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET properties in the *.env* file.
7. Open **vendor/spatie/browsershot/src/Browsershot.php** and set *protected bool $noSandbox* to *true*
8. Run
    ```sh
    ./vendor/bin/sail npm install
    ```
9. Run
    ```sh
    ./vendor/bin/sail npx puppeteer browsers install chrome
    ```
10. Run
    ```sh
    ./vendor/bin/sail npm run dev
    ```

## API Documentation
API docs can be found in localhost/apidocs.

## See it in Action
https://youtu.be/_WYyCUH1GOo[<iframe width="951" height="535" src="https://www.youtube.com/embed/_WYyCUH1GOo" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>]
