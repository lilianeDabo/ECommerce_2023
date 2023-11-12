DROP DATABASE IF EXISTS e_commerce;

CREATE DATABASE e_commerce;

USE e_commerce;

DROP TABLE IF EXISTS e_User ;
CREATE TABLE e_User (uid_Customer INTEGER AUTO_INCREMENT NOT NULL,
username_User VARCHAR(30),
password_User TEXT,
first_name_Customer VARCHAR(30),
last_name_Customer VARCHAR(30),
status_Customer VARCHAR(7),
PRIMARY KEY (uid_Customer)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Product ;
CREATE TABLE Product (uid_Product INT AUTO_INCREMENT NOT NULL,
name_Product VARCHAR(30),
description_Product TEXT,
price_Product FLOAT,
stock_Product INT,
PRIMARY KEY (uid_Product)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Cart ;
CREATE TABLE Cart (uid_Cart INT AUTO_INCREMENT NOT NULL,
content_Cart TEXT,
command_uid_command BIGINT,
PRIMARY KEY (uid_Cart)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Address ;
CREATE TABLE Address (email_Address VARCHAR(255) NOT NULL,
phone_number_Address VARCHAR(11),
address_Address TEXT,
postal_code_Address INTEGER,
city_Address TEXT,
PRIMARY KEY (email_Address)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Command ;
CREATE TABLE Command (uid_Command BIGINT AUTO_INCREMENT NOT NULL,
date_Command DATE,
status_Command VARCHAR(9),
shipping_info_Command TEXT,
cart_uid_cart INT,
PRIMARY KEY (uid_Command)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Payment ;
CREATE TABLE Payment (payment_method_Payment VARCHAR(255) NOT NULL,
PRIMARY KEY (payment_method_Payment)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Invoices ;
CREATE TABLE Invoices (history_Invoices VARCHAR(255) NOT NULL,
PRIMARY KEY (history_Invoices)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Rate ;
CREATE TABLE Rate (product_uid INT AUTO_INCREMENT NOT NULL,
user_uid INT,
rating_Rate INT,
review_Rate TEXT,
PRIMARY KEY (product_uid)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Photo ;
CREATE TABLE Photo (product_img_Photo VARCHAR(255) NOT NULL,
avatar_img_Photo TEXT,
PRIMARY KEY (product_img_Photo)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Choose ;
CREATE TABLE Choose (uid_Customer INTEGER AUTO_INCREMENT NOT NULL,
uid_Product INT NOT NULL,
product_img_Photo VARCHAR(255) NOT NULL,
PRIMARY KEY (uid_Customer,
 uid_Product,
 product_img_Photo)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Own ;
CREATE TABLE Own (uid_Customer INTEGER AUTO_INCREMENT NOT NULL,
uid_Cart INT NOT NULL,
email_Address VARCHAR(255) NOT NULL,
payment_method_Payment VARCHAR(255) NOT NULL,
PRIMARY KEY (uid_Customer,
 uid_Cart,
 email_Address,
 payment_method_Payment)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Store ;
CREATE TABLE Store (uid_Command BIGINT AUTO_INCREMENT NOT NULL,
history_Invoices VARCHAR(255) NOT NULL,
PRIMARY KEY (uid_Command,
 history_Invoices)) ENGINE=InnoDB;

DROP TABLE IF EXISTS Fill ;
CREATE TABLE Fill (payment_method_Payment VARCHAR(255) NOT NULL,
uid_Command BIGINT NOT NULL,
email_Address VARCHAR(255) NOT NULL,
PRIMARY KEY (payment_method_Payment,
 uid_Command,
 email_Address)) ENGINE=InnoDB;

DROP TABLE IF EXISTS e_Use ;
CREATE TABLE e_Use (uid_Customer INTEGER AUTO_INCREMENT NOT NULL,
product_uid INT NOT NULL,
uid_Product INT NOT NULL,
PRIMARY KEY (uid_Customer,
 product_uid,
 uid_Product)) ENGINE=InnoDB;

ALTER TABLE Cart ADD CONSTRAINT FK_Cart_command_uid_command FOREIGN KEY (command_uid_command) REFERENCES Command (uid_Command);
ALTER TABLE Command ADD CONSTRAINT FK_Command_cart_uid_cart FOREIGN KEY (cart_uid_cart) REFERENCES Cart (uid_Cart);
ALTER TABLE Choose ADD CONSTRAINT FK_Choose_uid_Customer FOREIGN KEY (uid_Customer) REFERENCES User (uid_Customer);
ALTER TABLE Choose ADD CONSTRAINT FK_Choose_uid_Product FOREIGN KEY (uid_Product) REFERENCES Product (uid_Product);
ALTER TABLE Choose ADD CONSTRAINT FK_Choose_product_img_Photo FOREIGN KEY (product_img_Photo) REFERENCES Photo (product_img_Photo);
ALTER TABLE Own ADD CONSTRAINT FK_Own_uid_Customer FOREIGN KEY (uid_Customer) REFERENCES User (uid_Customer);
ALTER TABLE Own ADD CONSTRAINT FK_Own_uid_Cart FOREIGN KEY (uid_Cart) REFERENCES Cart (uid_Cart);
ALTER TABLE Own ADD CONSTRAINT FK_Own_email_Address FOREIGN KEY (email_Address) REFERENCES Address (email_Address);
ALTER TABLE Own ADD CONSTRAINT FK_Own_payment_method_Payment FOREIGN KEY (payment_method_Payment) REFERENCES Payment (payment_method_Payment);
ALTER TABLE Store ADD CONSTRAINT FK_Store_uid_Command FOREIGN KEY (uid_Command) REFERENCES Command (uid_Command);
ALTER TABLE Store ADD CONSTRAINT FK_Store_history_Invoices FOREIGN KEY (history_Invoices) REFERENCES Invoices (history_Invoices);
ALTER TABLE Fill ADD CONSTRAINT FK_Fill_payment_method_Payment FOREIGN KEY (payment_method_Payment) REFERENCES Payment (payment_method_Payment);
ALTER TABLE Fill ADD CONSTRAINT FK_Fill_uid_Command FOREIGN KEY (uid_Command) REFERENCES Command (uid_Command);
ALTER TABLE Fill ADD CONSTRAINT FK_Fill_email_Address FOREIGN KEY (email_Address) REFERENCES Address (email_Address);
ALTER TABLE e_Use ADD CONSTRAINT FK_e_Use_uid_Customer FOREIGN KEY (uid_Customer) REFERENCES User (uid_Customer);
ALTER TABLE e_Use ADD CONSTRAINT FK_e_Use_product_uid FOREIGN KEY (product_uid) REFERENCES Rate (product_uid);
ALTER TABLE e_Use ADD CONSTRAINT FK_e_Use_uid_Product FOREIGN KEY (uid_Product) REFERENCES Product (uid_Product);
