# Currency Conversion API

## Pre-requisites

- Docker locally.
- Git installed locally.
- PHP installed locally.
- [Composer](https://getcomposer.org/download/) installed locally.
- Before starting, you should ensure that no other web servers or databases are running on your local computer.

## Requisites

- Clone the repository locally with `git clone git@github.com:JesusGarciaValadez/cyber-duck.git`.
- Accessing to the repository with `cd cyber-duck`;
- Copy the `.env.example` file as `.env` and `.env.testing` files.
- Replace the following values in the `.env` file:
```
APP_NAME=
APP_URL=
...
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
- For the `APP_URL` you can use the `http://localhost`.
- For the `.env.testing` file, you can leave the current values if you want.
- You can use wherever values do you want to use for the database setup.

## Installation instructions

### How to create the container?

- Install the composer dependencies with `composer install`;
- Run the command `php artisan sail:install` to publish the necessary for Docker to run.
- Create the Docker container using `./vendor/bin/sail up -d` for the detached mode.
- This will create the container using some environment variables of your `.env` file.

### How to create the database?

Once the container was created and running, you have to run the following commands:
```
./vendor/bin/sail artisan key:generate;
./vendor/bin/sail artisan migrate:fresh;
./vendor/bin/sail artisan migrate:fresh --env=testing;
```

### How to run the tests?

You can run the following command `./vendor/bin/sail test`.

### How to interact with the database?

You can access the database using `127.0.0.1` as `host` and the same values for the `DB_USERNAME`, `DB_PASSWORD`, and `DB_USERNAME` stored in your `.env` file.

# Setup the symlink to the storage

You have to set up a link to the storage to make logos public. Just run the following command:
```
./vendor/bin/sail art storage:link
```

### How to stop the containers?

You can stop the containers using `./vendor/bin/sail down`.

### What if I already had installed the docker images and containers before?

You need to recreate the container running `docker-compose build`, or stop the containers and images, deletep them, and run `./vendor/bin/sail up -d` to download the images again and rebuild them.

## How to use the app?

You can login enter to ['Login'](`http://localhost/login`) using `admin@admin.com` as username and `password` as password. If you logged successfully, you can see the [`Dashboard`](`http://localhost/dashboard`) where you can acces to either [`Companies`]('http://localhost/companies') section or the [`Employees`]('http://localhost/employees') section.

## Deploy to production

You can see the result of the app deployed to [production](http://45.77.186.219/)
