Running Wordpress app via composer in modern way.

## Features

* Better folder structure
* Dependency management with [Composer](https://getcomposer.org)
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)

## Requirements

* Docker 

or

* PHP >= 7.1
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* MySql

## Installation

1. Create a new project:
    ```
    $ composer create-project zippovich2/wordpress project-name
    ```
2. Update environment variables in the `.env` files (you can use `.env.local` and `.env.dev` and `.env.dev.local` files depends on your `APP_ENV`):
  * `APP_ENV` - Set to environment (`dev`, `prod`)
  * Database variables
    * `DB_NAME` - Database name
    * `DB_USER` - Database user
    * `DB_PASSWORD` - Database password
    * `DB_HOST` - Database host
  * `WP_HOME` - Full URL to WordPress home (https://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (https://example.com/wp)
  * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT`
    * Generate with [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command)
    * Generate with [roots WordPress salts generator](https://roots.io/salts.html)
3. Add theme(s) in `public/app/themes/` as you would for a normal WordPress site
4. Set the document root on your webserver to Bedrock's `public` folder: `/path/to/site/public/`
5. Access WordPress admin at `https://example.com/wp/wp-admin/`

You can skip 3,4,5 if you are using Docker, just run `make up` or `docker-compose up` then you can access you site by 
following `https://localhost:8080`