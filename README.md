### Initial Setup

```bash

# Clone the repository and go to the cloned directory

# install Composer dependencies/packages
$ composer install


$ cp .env.example .env
# then edit .env file to match your database configuration

$ php artisan key:generate

# Migrate and run seeding (do this every any update on the migration and the seeder)
$ php artisan migrate

```

### Running the application(with sail and docker)

```bash
$ ./vendor/bin/sail up
```

### Running the application in development(without docker)

```bash
#if you want to run in development use this:
$ php artisan serve
```
