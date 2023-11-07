<?php
global $db;

//use Faker\ORM\Propel\Populator;
require 'Product.php';
require('index_e_commerce.php');
require_once('vendor/autoload.php');

$sql = 'INSERT INTO product (name_Product, description_Product, price_Product, stock_Product) VALUES (?, ?, ?, ?)';
$stmt = $db->prepare($sql);

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->word);
    $stmt->bindValue(2, $faker->text(50));
    $stmt->bindValue(3, $faker->randomFloat(2));
    $stmt->bindValue(4, $faker->randomNumber(5, true));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

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