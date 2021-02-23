# footypigeon
An online-based game where users can score points based on predictions of football game results, competing in private leagues with other players.

## System requirements
* PHP (>= 7.3)
* Composer dependency manager (to be installed locally on machine)
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

All dependencies will be installed/updated by Composer.

## Installation instructions
This application follows the standard Laravel project installation process. Run the following from the app's root directory:
1. Install Composer dependencies:

    (in local development environment)
    
    `composer install`

    (in production environment)
    
    `composer install --optimize-autoloader --no-dev`
2. Run database migrations (create tables):
    `php artisan migrate`
3. Generate application key (used for encryption):
    `php artisan key:generate`

Your web server should be [configured](https://laravel.com/docs/master/deployment#server-configuration) so that the web root is the `/public` directory.

In a production environment, it's also recommended to [run some additional optimization commands](https://laravel.com/docs/8.x/deployment#optimization). **Do not do this in a local development environment** as it may prevent your changes from taking effect.
