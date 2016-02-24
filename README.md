Yii2 Roles (Development Phase)
==============================

A Yii2 extension which includes the concept of roles into the application, which 
can be assigned to users and checked at the level of access to the controllers.

## Installation

Include the package as dependency under the composer.json file.

To install, either run

```bash
$ php composer.phar require jlorente/yii2-roles "*"
```

or add

```json
...
    "require": {
        // ... other configurations ...
        "jlorente/yii2-roles": "*"
    }
```

to the ```require``` section of your `composer.json` file and run the following 
commands from your project directory.
```bash
$ composer update
$ ./yii migrate --migrationPath=@vendor/jlorente/yii2-roles/src/migrations
```

## Usage

In construction

## License 
Copyright &copy; 2016 José Lorente Martín <jose.lorente.martin@gmail.com>.