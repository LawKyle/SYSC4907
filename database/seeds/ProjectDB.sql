CREATE DATABASE IF NOT EXISTS ProjectDB;
USE ProjectDB;

CREATE TABLE IF NOT EXISTS Product (
product_id INT NOT NULL AUTO_INCREMENT,
nfc_id VARCHAR(255),
description VARCHAR(2083),
name VARCHAR(255) NOT NULL,
tag SET('meat', 'produce', 'organic', 'deli', 'seafood', 'grocery', 'bakery'),

PRIMARY KEY (product_id));

CREATE TABLE IF NOT EXISTS Ingredent (
ingredent_id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255),
product_id INT,
PRIMARY KEY(ingredent_id));

CREATE TABLE IF NOT EXISTS Product_Ingredent(
product_id INT NOT NULL,
ingredent_id INT NOT NULL,
FOREIGN KEY (product_id) REFERENCES Product(product_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (ingredent_id) REFERENCES Ingredent(ingredent_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (product_id, ingredent_id));


CREATE TABLE IF NOT EXISTS Location (
store_id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255),
PRIMARY KEY (store_id));

CREATE TABLE IF NOT EXISTS Product_Location (
product_id INT NOT NULL,
store_id INT NOT NULL,
FOREIGN KEY (product_id) REFERENCES Product(product_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (store_id) REFERENCES Location(store_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (product_id, store_id));

CREATE TABLE IF NOT EXISTS Maps (
map_id INT NOT NULL AUTO_INCREMENT,
mapPath VARCHAR(2083),
store_id INT NOT NULL,
FOREIGN KEY (store_id) REFERENCES Location(store_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (map_id));

CREATE TABLE IF NOT EXISTS Restriction (
restriction_id INT NOT NULL AUTO_INCREMENT,
restriction_name VARCHAR(255),
restriction_severity INT NOT NULL,
PRIMARY KEY (restriction_id));

CREATE TABLE IF NOT EXISTS Restriction_Ingredent (
restriction_id INT NOT NULL,
ingredent_id INT NOT NULL,
FOREIGN KEY (restriction_id) REFERENCES Restriction(restriction_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (ingredent_id) REFERENCES Ingredent(ingredent_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (restriction_id, ingredent_id));

CREATE TABLE IF NOT EXISTS ShoppingList (
list_id INT NOT NULL AUTO_INCREMENT,
list_link VARCHAR(2083),
PRIMARY KEY (list_id));

CREATE TABLE IF NOT EXISTS ShoppingList_Product (
list_id INT NOT NULL,
product_id INT NOT NULL,
FOREIGN KEY (list_id) REFERENCES ShoppingList(list_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (product_id) REFERENCES Product(product_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (list_id, product_id));

CREATE TABLE IF NOT EXISTS Person (
user_id INT NOT NULL AUTO_INCREMENT,
user_data VARCHAR(2083),
PRIMARY KEY (user_id));

CREATE TABLE IF NOT EXISTS Person_Restriction (
user_id INT NOT NULL,
restriction_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES Person(user_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (restriction_id) REFERENCES Restriction(restriction_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (user_id, restriction_id));

CREATE TABLE IF NOT EXISTS Person_ShoppingList (
user_id INT NOT NULL,
list_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES Person(user_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (list_id) REFERENCES ShoppingList(list_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (user_id, list_id));


