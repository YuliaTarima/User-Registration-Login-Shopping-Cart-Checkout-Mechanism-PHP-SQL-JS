# create database "carts"
DROP DATABASE IF EXISTS carts;
CREATE DATABASE IF NOT EXISTS carts;
USE carts;

# create table "products"
DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (prodId char(13) NOT NULL PRIMARY KEY, catId char(10), prodName char(50), prodPrice float(6,2), prodDescription char(200), inventory int(5));

# insert data into table "products" (@ creation time)
INSERT INTO products (prodId, prodName, prodDescription, prodPrice, inventory, catId)  VALUES ('101', 'HP-ENVY-700', 'AMD Elite Quad-Core A10-6700 Accelerated Processor 3.7 GHz(4 MB cache), 8GB DDR3 memory, 1020 GB Hard Drive', 755.99, 2, '11'), ('102', 'Asus-M51AD-US001S', 'Intel® Core™ i7-4770 Processor 3.4 GHz(4 MB cache), 16GB DDR3 memory, 1 TB Hard Drive', 969.99, 2, '11'), ('201', 'Toshiba Satellite C55-A5310', 'Intel® Core™ i3-3120M Processor 2.8 GHz, 6GB DDR3 memory, 750 GB Hard Drive', 399.99, 2, '12'), ('301', 'Samsung GALAXY Tab 3', 'Android Jelly Bean 4.1 OS Dual-Core Processor 1.2 GHz, 802.11a/b/g/n 2,4 + 5 GH', 249.99, 2, '14');

# create table "customers" 
CREATE TABLE IF NOT EXISTS customers (cid int(10) unsigned NOT NULL PRIMARY KEY  AUTO_INCREMENT, name char(50) NOT NULL, address char(100) NOT NULL, city char(30) NOT NULL, state char(5) NOT NULL, zip int(5) unsigned NOT NULL);

# insert data into table "customers" (@ creation time)
INSERT INTO customers (name, address, city, state, zip)  VALUES ('Albert Adams', '1 A Street', 'Antoich', 'CA', '94531'), ('Brian Brown', '2 Bone Drive', 'Brentwood', 'CA', '94513'), ('Cynthia Clark', '3 Concord Avenue', 'Concord', 'CA', '94520');

# create table "categories" 
CREATE TABLE IF NOT EXISTS categories (catId int(10) unsigned NOT NULL PRIMARY KEY  AUTO_INCREMENT, catDescription char(200));

# insert data into table "categories" (@ creation time)
INSERT INTO categories (catId, catDescription)  VALUES ('11', 'Desktop'), ('12', 'Laptop'), ('14', 'Tablet');

# update data table "products" inventory, prodPrice field (@ run time)
UPDATE products SET inventory=inventory+5 Where prodId='101';
UPDATE products SET inventory=inventory-1 Where prodId='102';
UPDATE products SET prodPrice=419.99 Where prodId='201';

# insert data into table "customers" (@ run time)
INSERT INTO customers (name, address, city, state, zip)  VALUES ('Donna Davis', '4 D Street', 'Davis', 'CA', '95218');