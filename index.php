<?php
global $db;

//use Faker\ORM\Propel\Populator;
require 'Product.php';
require('index_e_commerce.php');
require_once('vendor/autoload.php');

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();
// TABLES HAVE 3 ELEMENTS MAX

// E_USER
$sql = 'INSERT INTO e_user (username_User, password_User, first_name_Customer, last_name_Customer, status_Customer) VALUES (?, ?, ?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->userName);
    $stmt->bindValue(2, $faker->password);
    $stmt->bindValue(3, $faker->firstName($gender = null));
    $stmt->bindValue(4, $faker->lastName);
    $stmt->bindValue(5, $faker->randomElement(['online', 'offline']));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// PRODUCT
$sql = 'INSERT INTO product (name_Product, description_Product, price_Product, stock_Product) VALUES (?, ?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->word);
    $stmt->bindValue(2, $faker->text(50));
    $stmt->bindValue(3, $faker->randomFloat(2, 5, 1000));
    $stmt->bindValue(4, $faker->randomNumber(5, true));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}



// ADDRESS
$sql = 'INSERT INTO address (email_Address, phone_number_Address, address_Address, postal_code_Address, city_Address) VALUES (?, ?, ?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->freeEmail);
    $stmt->bindValue(2, $faker->phoneNumber);
    $stmt->bindValue(3, $faker->address);
    $stmt->bindValue(4, $faker->postcode);
    $stmt->bindValue(5, $faker->city);
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// COMMAND
$sql = 'INSERT INTO command (date_Command, status_Command, shipping_info_Command) VALUES (?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->date());
    $stmt->bindValue(2, $faker->randomElement(['shipped', 'delivered']));
    $stmt->bindValue(3, $faker->text(50));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// CART
$sql = 'INSERT INTO cart (content_Cart, command_uid_command) VALUES (?, ?)'; // Example command ID will be the first one
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->text(50));
    $stmt->bindValue(2, $faker->randomElement([null, $faker->numberBetween(1, 3)])); // Max being 3 for possible foreign key nb ( 3 max )
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// PAYMENT
$sql = 'INSERT INTO product (name_Product, description_Product, price_Product, stock_Product) VALUES (?, ?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->word);
    $stmt->bindValue(2, $faker->text(50));
    $stmt->bindValue(3, $faker->randomFloat(2, 5, 1000));
    $stmt->bindValue(4, $faker->randomNumber(5, true));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// INVOICES
$sql = 'INSERT INTO invoices (history_Invoices) VALUES (?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->text(150));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// RATE
$sql = 'INSERT INTO rate (rating_Rate, review_Rate) VALUES (?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->numberBetween(0, 5));
    $stmt->bindValue(2, $faker->text(50));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// PHOTO
$sql = 'INSERT INTO photo (product_img_Photo, avatar_img_Photo) VALUES (?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->imageUrl());
    $stmt->bindValue(2, $faker->imageUrl());
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// JUNCTION TABLES
