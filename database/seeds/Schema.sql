CREATE DATABASE IF NOT EXISTS TapCheck;
USE TapCheck;

CREATE TABLE IF NOT EXISTS Product (
product_id INT NOT NULL AUTO_INCREMENT,
nfc_id VARCHAR(255),
description VARCHAR(255),
tag SET('meat', 'produce', 'organic', 'deli', 'seafood', 'grocery'),
FOREIGN KEY (store_id) REFERENCES Location(store_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (product_id));

CREATE TABLE IF NOT EXISTS Ingredent (
ingredent_id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255),
PRIMARY KEY(ingredent_id));

CREATE TABLE IF NOT EXISTS Product_Ingredent(
product_id INT NOT NULL,
ingredent_id INT NOT NULL,
FOREIGN KEY (product_id) REFERENCES Product(product_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (ingredent_id) REFERENCES Ingredent(ingredent_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (product_id, ingredent_id));


CREATE TABLE IF NOT EXISTS Location (
store_id INT NOT NULL,
name VARCHAR(255),
PRIMARY KEY (store_id));

CREATE TABLE IF NOT EXISTS Product_Location (
product_id INT NOT NULL,
ingredent_id INT NOT NULL,
FOREIGN KEY (product_id) REFERENCES Product(product_id) ON DELETE RESTRICT ON UPDATE CASCADE,
FOREIGN KEY (ingredent_id) REFERENCES Ingredent(ingredent_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (product_id, ingredent_id));

CREATE TABLE IF NOT EXISTS Maps (
map_id INT NOT NULL AUTO_INCREMENT,
mapPath VARCHAR(2083),
store_id INT NOT NULL,
FOREIGN KEY (store_id) REFERENCES Location(store_id) ON DELETE RESTRICT ON UPDATE CASCADE,
PRIMARY KEY (map_id));

CREATE TABLE IF NOT EXISTS Restriction (
restriction_id INT NOT NULL AUTO_INCREMENT,
restrictionName VARCHAR(255),
restrictionSeverity INT NOT NULL,
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







