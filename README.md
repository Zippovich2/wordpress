## Wordpress Wrapper

Developing Wordpress app in modern way using composer.

[![Build Status](https://travis-ci.org/Zippovich2/wordpress.svg?branch=master)](https://travis-ci.org/Zippovich2/wordpress)
[![Packagist](https://img.shields.io/packagist/v/zippovich2/wordpress.svg)](https://packagist.org/packages/zippovich2/wordpress)

## Features

* Better folder structure.
* Dependency management with [Composer](https://getcomposer.org).
* Easy WordPress configuration with environment specific files.
* Environment variables with [Symfony Dotenv](https://symfony.com/doc/current/components/dotenv.html).
* Filters and actions configuration in .yaml files.

## Requirements

* Docker 

or

* PHP >= 7.3
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* MySql
* Nginx or Apache2

## Installation

1. Create a new project:
    ```
    $ composer create-project zippovich2/wordpress project-name
    ```
2. Update variables in the `.env` files and constants in the`.const` files (you can use `.env`, `.env.local`, `.env.dev`,
    `.env.dev.local` and `.const`, `.const.local`, `.const.dev`, `.const.dev.local` files depends on your `APP_ENV`):
    * `APP_ENV` - Set to environment (`dev`, `prod` or `test`)
    * Database constants:
        * `DB_NAME` - database name.
        * `DB_USER` - database user.
        * `DB_PASSWORD` - database password.
        * `DB_HOST` - database host.
    * `WP_HOME` - full URL to WordPress home (https://example.com).
    * `WP_SITEURL` - full URL to WordPress including subdirectory (https://example.com/wp).
    * Wordpress salts will be generated after the project is created (if you used `composer create-project`), but you can regenerate them:
        * `composer salts`
        * `make salts`
        * `wp dotenv salts regenerate --file=.env` 
        * or generate with [roots WordPress salts generator](https://roots.io/salts.html)
3. Add a theme(s) in `public/app/themes/` as you would for a normal WordPress site
4. Set the document root on your webserver to `public` folder: `/path/to/site/public/`
5. Access WordPress admin at `https://example.com/wp/wp-admin/`
6. For enabling WordPress Config - add to begin of `functions.php`:
    
    ```php
    use WordpressWrapper\Config\Config;
   
    $config = new Config($_ENV['PROJECT_ROOT'] . '/config');
    $config->load();
    ```

If you are using Docker - you can skip 3, 4 and 5, just run `make up` or `docker-compose up` then you can access you site by 
uri `http://localhost:8080`.

## Folder structure

```
your-project/
├─ .docker/
├─ config/
|  └─ ...
├─ public/
|  ├─ app/
|  ├─ wp/
|  ├─ index.php
|  └─ wp-config.php
├─ src/
|  └─ ...
├─ var/
├─ tests/
└─ vendor/
```

* `.docker/` - contain files which are used to build docker environment, you can delete this folder if run app without Docker.
* `config/` - contain .yaml config files, at this moment [WordPress Wrapper Config](https://github.com/Zippovich2/wordpress-config) support:
    * `filters.yaml`
    * `actions.yaml`
* `public/` - this is root folder, contain:
    * `app/` - same as default `wp-content` WordPress folder.
    * `wp/` - contain WordPress core, you should not edit files from this directory.
    * `index.php` - WordPress core loads here.
    * `wp-config.php` - here `.env*` and `.const*` files are load.
* `tests/` - app tests.
* `var/` - contain docker data(if you use Docker) and logs.
* `vendor/` - composer dependencies.