# Личный проект «Куплю-Продам»
![PHP Version](https://img.shields.io/badge/php-%5E8.0-blue)
![MySQL Version](https://img.shields.io/badge/mysql-latest-orange)
![Yii2 Version](https://img.shields.io/badge/Yii2-%5E2.0.45-83C933)

## О проекте

«Куплю. Продам» — интернет-сервис, упрощающий продажу или покупку любых вещей. Всё, что требуется для покупки: найти подходящее объявление и связаться с продавцом по email. Продать ненужные вещи ничуть не сложней: зарегистрируйтесь и заполните форму нового объявления.

## Функциональность

Основные возможности, реализованные в проекте:

- Регистрация на сайте;
- Авторизация;
- Регистрация и авторизация через социальную сеть VK;
- Главная страница с двумя категориями объявлений: Самое свежее и Самое обсуждаемое;
- Страница объявления с предоставлением всей информации о товаре;
- Страница с категориями товаров;
- Поиск по товарам на сайте;
- Оставление комментариев под товарами;
- Создание и редактирование объявлений на сайте;
- Страница со всеми публикациями пользователя;
- Страница с товарами, где пользователь оставил свой комментарий;
- Валидация всех форм;
- Возврат страницы с ошибкой 404, если пользователь пытается открыть страницу с несуществующим пользователем или заданием.

## Обзор проекта

<img src="web/img/cover-buyandsell.png"></img>

## Начало работы

Чтобы развернуть проект локально или на хостинге, выполните последовательно несколько действий:

1. Клонируйте репозиторий:

```bash
git clone git@github.com:kiipod/1622797-buy-and-sell-4.git buyandsell
```

2. Перейдите в директорию проекта:

```bash
cd buyandsell
```

3. Установите зависимости, выполнив команду:

```bash
composer install
```

4. Настройте веб-сервер таким образом, чтобы корневая директория указывала на папку web внутри проекта. Например, в случае с размещением проекта в директории `public_html` это можно сделать с помощью команды:

```bash
ln -s web public_html
```

5. Создайте базу данных для проекта, используя схему из файла `schema.sql`:

```sql
CREATE DATABASE buyandsell 
       CHARACTER SET utf8 
       COLLATE utf8_general_ci;

USE buyandsell;

/* Таблица пользователей */
CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(64) NOT NULL UNIQUE,
    password VARCHAR(64)  NOT NULL,
    avatarSrc VARCHAR(255) NULL,
    vkId int,
    admin BOOLEAN NULL
);

/* Таблица типа товаров */
CREATE TABLE adTypes (
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL
);

/* Таблица категорий объявлений */
CREATE TABLE adCategories (
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64) NOT NULL
);

/* Таблица объявлений */
CREATE TABLE ads (
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price int NOT NULL,
    imageSrc VARCHAR(255) NOT NULL,
    typeId int NOT NULL,
    description TEXT NOT NULL,
    author int NOT NULL,
    dateCreation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (typeId) REFERENCES adTypes (id),
    FOREIGN KEY (author) REFERENCES users (id)
);

/* Таблица категорий объявлений */
CREATE TABLE adsToCategories (
    id int AUTO_INCREMENT PRIMARY KEY,
    adsId int NOT NULL,
    categoryId int NOT NULL,
    FOREIGN KEY (adsId) REFERENCES ads (id),
    FOREIGN KEY (categoryId) REFERENCES adCategories (id),
);

/* Таблица с комментариями к товару */
CREATE TABLE comments (
    id int AUTO_INCREMENT PRIMARY KEY,
    author int NOT NULL,
    adId int NOT NULL,
    text TEXT NOT NULL,
    dateCreation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author) REFERENCES users (id),
    FOREIGN KEY (adId) REFERENCES ads (id)
);

/* Создаем индекс для полнотекстового поиска */
CREATE FULLTEXT INDEX ads_ft_search ON ads(name, description);

```

6. Заполните базу данных тестовыми данными, запустив команду:
```
php yii fixture/load <ModelName>
```

7. Настройте подключение к базе данных в файле `config\db.php`, указав в нем параметры своего окружения. Например, это может выглядеть так:

```php
<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=buyandsell',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];
```

## Техническое задание

[Посмотреть техническое задание проекта](tz.md)
