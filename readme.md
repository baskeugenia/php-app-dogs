# PHP CRUD App with AJAX built with Docker with PHP 8.3, Apache, MySql, PhpMyAdmin (LAMP-stack)

## Задание

### Технические требования: 
Приложение должно быть написано на PHP (7.4, 8.0, 8.1 по выбору).
Приложение не должно быть написано с помощью какого-либо фреймворка, однако можно устанавливать для него различные пакеты через compоser.
Архитектура БД разрабатывается кандидатом.
Представление должно содержать достаточный минимум JS кода для реализации требуемого функционала, можно использовать jQuery.

Должны существовать несколько видов собак = сиба-ину, мопс, такса, плюшевый лабрадор, резиновая такса с пищалкой.

Собаки должны уметь издавать звуки (лаять, пищать) и охотиться. При этом стоит помнить, что мопсу охотиться будет лень, некоторые игрушки не издают звуков и точно не смогут охотиться.

Должна быть возможность:
добавить собаку
отредактировать данные
удалить собаку


## Prerequisites

- [Install Docker](https://docs.docker.com/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

## How to use

- Clone the repository
- Enter the repository folder
- Run the `docker-compose up -d` command

- Run `docker ps` for the name of mysql container
  (`8dc76299cb30   mysql:5                        "docker-entrypoint.s…"   2 minutes ago   Up 2 minutes   0.0.0.0:3306->3306/tcp, :::3306->3306/tcp, 33060/tcp                       lamp.mysql`)
- Run `docker inspect [container name]`: docker inspect 8dc76299cb30
- Use IP adress for DB connection (172.20.0.2): 
    - Change `private $dbServer = 172.20.0.2` in `app/phpcrudajax/includes/Database.php` to the new IP address if different
- Access the address `[http://localhost/phpcrudajax]` to access the project
- Access the address `http://localhost:8080` to access phpmyadmin
  - root access
    - user: root
    - password: root
    - host: mysql
- Import file `dogsdb.sql` to create Database

### Run the Project

Run the localhost
point to the:

```sh
http://localhost/phpcrudajax

```

