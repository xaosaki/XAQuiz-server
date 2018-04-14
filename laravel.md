## Модели
**Создать модель с миграцией ресурсным контроллером и фабрикой:**

`php artisan make:model Name -a`

## Наполнение БД

* `php artisan make:seeder NameTableSeeder`
* `composer dump-autoload`
* `php artisan db:seed --class=NameTableSeeder`


## Миграции
**Накатить:**

`php artisan migrate`

**Откатить:**

`php artisan migrate:rollback`




