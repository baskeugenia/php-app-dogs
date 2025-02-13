# Docker with PHP 8.3, Apache, MySql, PhpMyAdmin

This repository aims to facilitate the creation of a development environment with php 8.3 (LAMP-stack)

## What's in the environment

- [Apache2](https://httpd.apache.org/)
- [MySQL](https://www.mysql.com/)
- [PhpMyAdmin](https://www.phpmyadmin.net/)

## Prerequisites

- [Install Docker](https://docs.docker.com/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

## How to use

- Clone the repository
- Copy the files of the launched application to the `app` folder
- Enter the repository folder
- Run the `docker-compose up -d` command
- Access the address `http://localhost:8080` to access phpmyadmin
  - user access
    - user: mysql
    - password: mysql
    - host: mysql
  - root access
    - user: root
    - password: root
    - host: mysql
- Access the address `http://localhost` to access the project

## Persistent data

- mysql data: `./data/mysql/dbdata`
- apache logs: `./data/apache/logs`


If you change the php.ini file, you need to rebuild the container command `docker compose up -d --build`.

## PHP Modules

```
[PHP Modules]
  mysqli
  pdo
  pdo_mysql
  opcache
  zip
  gd
```

To add other php modules, you need to edit the `./build/php/Dockerfile` file and rebuild the container.
(I have enabled by default the minimum set of modules required for OpenCart)

## License

[MIT](https://opensource.org/licenses/MIT)

# PHP PDO CRUD with ajax jQuery and Bootstrap

PHP MySQL CRUD Application using jQuery Ajax and Bootstrap

- git clone the repository

  Project setup
- Rename your project directory to "phpcrudajax"

  Create Database:


### Run the Project

Run the localhost (Apache service)
point to the:

```sh
http://localhost/phpcrudajax

```

