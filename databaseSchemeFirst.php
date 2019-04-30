<?php 

# При удалении из "авторы" удалются и все записи с этим author_id из "книги по авторам и жанрам". Аналогично и с книгой и с жанрами.ON DELETE CASCADE.

/* create database Books; 

use Books;

CREATE TABLE `books` (`book_id` int(3) NOT NULL AUTO_INCREMENT, `book_name` VARCHAR(50) NOT NULL,`book_description` TEXT, `book_image` BLOB NOT NULL, PRIMARY KEY(`book_id`),FULLTEXT KEY `FULLTEXT_book_name` (`book_name`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

explain books;

+------------------+-------------+------+-----+---------+----------------+
| Field            | Type        | Null | Key | Default | Extra          |
+------------------+-------------+------+-----+---------+----------------+
| book_id          | int(3)      | NO   | PRI | NULL    | auto_increment |
| book_name        | varchar(50) | NO   | MUL | NULL    |                |
| book_description | text        | YES  |     | NULL    |                |
| book_image       | blob        | NO   |     | NULL    |                |
+------------------+-------------+------+-----+---------+----------------+


CREATE TABLE `genres` (`genre_id` int(3) NOT NULL AUTO_INCREMENT, `genre_name` VARCHAR(50) NOT NULL, PRIMARY KEY(`genre_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

explain genres;

+------------+-------------+------+-----+---------+----------------+
| Field      | Type        | Null | Key | Default | Extra          |
+------------+-------------+------+-----+---------+----------------+
| genre_id   | int(3)      | NO   | PRI | NULL    | auto_increment |
| genre_name | varchar(50) | NO   |     | NULL    |                |
+------------+-------------+------+-----+---------+----------------+


CREATE TABLE `authors` (`author_id` int(3) NOT NULL AUTO_INCREMENT, `author_name_f` VARCHAR(50) NOT NULL, `author_name_n` VARCHAR(50) NOT NULL, `author_name_o` VARCHAR(50) NOT NULL, PRIMARY KEY(`author_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

explain authors;

+---------------+-------------+------+-----+---------+----------------+
| Field         | Type        | Null | Key | Default | Extra          |
+---------------+-------------+------+-----+---------+----------------+
| author_id     | int(3)      | NO   | PRI | NULL    | auto_increment |
| author_name_f | varchar(50) | NO   |     | NULL    |                |
| author_name_n | varchar(50) | NO   |     | NULL    |                |
| author_name_o | varchar(50) | NO   |     | NULL    |                |
+---------------+-------------+------+-----+---------+----------------+


CREATE TABLE `books_by_genres_authors` (`id` int(3) NOT NULL AUTO_INCREMENT, `book_id` int(3) NOT NULL, `genre_id` int(3) NOT NULL, `author_id` int(3) NOT NULL, PRIMARY KEY(`id`), FOREIGN KEY (`book_id`) REFERENCES books (`book_id`) ON DELETE CASCADE, FOREIGN KEY (`genre_id`) REFERENCES genres (`genre_id`) ON DELETE CASCADE, FOREIGN KEY (`author_id`) REFERENCES authors (`author_id`) ON DELETE CASCADE  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

explain books_by_genres_authors;

+-----------+--------+------+-----+---------+----------------+
| Field     | Type   | Null | Key | Default | Extra          |
+-----------+--------+------+-----+---------+----------------+
| id        | int(3) | NO   | PRI | NULL    | auto_increment |
| book_id   | int(3) | NO   | MUL | NULL    |                |
| genre_id  | int(3) | NO   | MUL | NULL    |                |
| author_id | int(3) | NO   | MUL | NULL    |                |
+-----------+--------+------+-----+---------+----------------+


show tables;

+-------------------------+
| Tables_in_Books         |
+-------------------------+
| authors                 |
| books                   |
| books_by_genres_authors |
| genres                  |
+-------------------------+

# для id чтобы их не  указывать а они уже начинались сами, автоинкремент есть, DEFAULT будет 0.

ALTER TABLE books ALTER COLUMN book_id SET DEFAULT 0;

ALTER TABLE authors ALTER COLUMN author_id SET DEFAULT 0;

ALTER TABLE genres ALTER COLUMN genre_id SET DEFAULT 0;

ALTER TABLE books_by_genres_authors ALTER COLUMN id SET DEFAULT 0;

*/



?>
