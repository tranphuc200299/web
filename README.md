## Docker setup

```
cp .env.example .env

docker-compose up -d

#linux
docker exec -it {app-name}-php bash

#window
winpty docker exec -it {app-name}-php bash
```

## Laravel install and build app

```
root@123456789abcde:/var/www/html#composer install
root@123456789abcde:/var/www/html#php artisan key:generate
root@123456789abcde:/var/www/html#php artisan migrate --seed
root@123456789abcde:/var/www/html#npm i
root@123456789abcde:/var/www/html#npm run dev
```

## CSS, JS edit in template folder:
`
resources/assets/_template/white/
`

## IDE model helper: 

```
php artisan ide-helper:models --dir="modules"
```

## make migration: 

```
root@123456789abcde:/var/www/html#php artisan make:migration create_data_table --path="modules/A/Database/Migrations"
```

## First time run app

```
php artisan migrate:fresh --seed
```

## Refresh seed permission
```
php artisan db:seed --class="Modules\Auth\Database\Seed\PermissionSeeder"
```

```php
MenuFacade::pushMenu([
    'group' => 10, //group id, sort asc sidebar menu
    'group_name' => 'area::text.test', //translate key, default null to not use submenu
    'pos_child' => 3, // position of child in group, default 0 to not use submenu
    'name' => 'area::text.test', //translate key
    'class' => TestModel::class, // class to check policy
    'route' => 'cp.tests.index', //route name
    'icon' => 'fort-awesome', // fa icon
]);
```

## PHP standard command
0. basic checks, unknown classes, unknown functions, unknown methods called on $this, wrong number of arguments passed to those methods and functions, always undefined variables
1. possibly undefined variables, unknown magic methods and properties on classes with __call and __get
2. unknown methods checked on all expressions (not just $this), validating PHPDocs
3. return types, types assigned to properties
4. basic dead code checking - always false instanceof and other type checks, dead else branches, unreachable code after return; etc.
5. checking types of arguments passed to methods and functions 
6. report missing typehints
7. report partially wrong union types - if you call a method that only exists on some types in a union type, level 7 starts to report that; other possibly incorrect situations
8. report calling methods and accessing properties on nullable types
9. be strict about the mixed type - the only allowed operation you can do with it is to pass it to another mixed

```
php -d memory_limit=1G /composer/vendor/bin/phpstan analyse core modules --level=1
```

## Build WebApp

###Install

```
cd vue/app
cp .env.example .env
npm i
```

###Develop
```
npm run serve
```

###Build
```
npm run build
```