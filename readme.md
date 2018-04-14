# XAQuiz-server

Серверная часть. Основана на Laravel

Приложение упаковано в docker контейнер. Окружение на рабочей машине не требуется. 

## Установка 
1. Установить [Docker](https://docker.com)
2. Собрать контейнеры: `docker-compose build`
3. Запустить контейнеры: `docker-compose up`
4. Проверить запустился ли mysql `docker-compose ps`
4. Перейти в контейнер PHP и запустить миграции
    * `docker-compose run --no-deps php bash`
    * `cd ..`
    * `php artisan migrate`
5. В том же контейнере запустить наполнение базы: `php artisan  db:seed`

## Работа
Запуск контейнеров: `docker-compose start`

Остановка контейнеров: `docker-compose stop`

Запуск терминала в контейнере `docker exec -it <containerIdOrName> bash`

Резервное копирование базы:

**Backup**

`docker exec xaquizserver_database_1 /usr/bin/mysqldump -u root --password=xaquiz xaquiz > backup.sql`

**Restore**

`cat backup.sql | docker exec -i xaquizserver_database_1 /usr/bin/mysql -u root --password=xaquiz xaquiz`

## TODO
* Настроить масштабирование в докер контейнерах  
