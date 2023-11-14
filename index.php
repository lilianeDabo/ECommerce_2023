<?php
global $db;

//use Faker\ORM\Propel\Populator;
require 'Product.php';
require('index_e_commerce.php');
require_once('vendor/autoload.php');

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

// TABLES HAVE 3 ELEMENTS MAX
// encryption
// Define the secret key
$key = "ecommerce";

// Define the encryption method
$method = "AES-256-CBC";

// Generate a random initialization vector (IV)
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

// E_USER
$sql = 'INSERT INTO e_user (username_User, password_User, first_name_Customer, last_name_Customer, status_Customer) VALUES (?, ?, ?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->userName);
    $stmt->bindValue(2, openssl_encrypt($faker->password, $method, $key, 0, $iv ));
    $stmt->bindValue(3, $faker->firstName($gender = null));
    $stmt->bindValue(4, openssl_encrypt($faker->lastName, $method, $key, 0, $iv ));
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
    $stmt->bindValue(1, openssl_encrypt($faker->freeEmail, $method, $key, 0, $iv ));
    $stmt->bindValue(2, openssl_encrypt($faker->phoneNumber, $method, $key, 0, $iv ));
    $stmt->bindValue(3, openssl_encrypt($faker->address, $method, $key, 0, $iv ));
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
$sql = 'INSERT INTO cart (content_Cart, uid_Command) VALUES (?, ?)'; // Example command ID will be the first one
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->text(50));
    $stmt->bindValue(2, $faker->randomElement([null, $faker->numberBetween(1, 3)])); // Max being 3 for possible foreign key nb ( 3 max )
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// COMMAND Foreign key
$sql = 'UPDATE command SET uid_Cart = (SELECT uid_cart FROM cart WHERE cart.uid_Command = command.uid_Command LIMIT 1)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

// BOB
/*
for ($i=0; $i < 3; $i++) {
  $sql = "SELECT uid_Command FROM cart WHERE cart.uid_Cart = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $i );
    $stmt->execute();
    $carts = $stmt->fetchAll();
    //die (print_r($carts));

    $sql = "UPDATE command SET uid_Cart = ? WHERE  uid_Command = ?";
    $stmt = $db->prepare($sql);
    //die (print_r($carts));
    $stmt->bindValue(1, $i );
    $stmt->bindValue(2, $carts[0]['uid_Command'] ?? null );
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}*/

// PAYMENT
$sql = 'INSERT INTO payment (credit_cardNB_Payment, credit_Card_Type_Payment) VALUES (?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, openssl_encrypt($faker->creditCardNumber, $method, $key, 0, $iv ));
    $stmt->bindValue(2, openssl_encrypt($faker->creditCardType, $method, $key, 0, $iv ));
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}



// INVOICES
$sql = 'INSERT INTO invoices (uid_Product, uid_Customer, quantity_Invoices) VALUES (?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->numberBetween(1, 3));
    $stmt->bindValue(2, $faker->numberBetween(1, 3));
    $stmt->bindValue(3, $faker->randomNumber(1, true));

    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// INVOICES Foreign keys
$sql = 'UPDATE invoices SET name_Product = (SELECT name_Product FROM product WHERE invoices.uid_Product = product.uid_Product)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

$sql = 'UPDATE invoices SET price_Product = (SELECT price_Product FROM product WHERE invoices.uid_Product = product.uid_Product)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

// E_USE
$sql = 'INSERT INTO e_use (uid_Customer) VALUES (?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=1; $i <= 3; $i++) {
    $stmt->bindValue(1, $i);
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// E_USE Foreign keys
$sql = 'UPDATE e_use SET uid_Product = (SELECT uid_Product FROM rate WHERE rate.uid_Customer = e_use.uid_Customer LIMIT 1)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

// RATE
$sql = 'INSERT INTO rate (uid_Product, uid_Customer, rating_Rate, review_Rate) VALUES (?, ?, ?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=1; $i <= 3; $i++) {
    $stmt->bindValue(1, $faker->numberBetween(1, 3));
    $stmt->bindValue(2, $i);
    $stmt->bindValue(3, $faker->numberBetween(0, 5));
    $stmt->bindValue(4, $faker->text(50));
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

// CHOOSE
$sql = 'INSERT INTO choose (uid_Customer, uid_Product) VALUES (?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=0; $i < 3; $i++) {
    $stmt->bindValue(1, $faker->unique()->numberBetween(1, 3));
    $stmt->bindValue(2, $faker->numberBetween(1, 3));

    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}


// OWN
$sql = 'INSERT INTO own (uid_Customer, uid_Cart) VALUES (?, ?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=1; $i <= 3; $i++) {
    // Wanted to use a double unique number between 1 and 3 but unique doesn't reset right from the last function Choose
    $stmt->bindValue(1, $i);
    $stmt->bindValue(2, $i);

    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// OWN Foreign keys
$sql = 'UPDATE own SET email_Address = (SELECT email_Address FROM address WHERE address.uid_Address = own.uid_Customer)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

$sql = 'UPDATE own SET credit_cardNB_Payment = (SELECT credit_cardNB_Payment FROM payment WHERE payment.uid_Payment = own.uid_Customer)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

// STORE
$sql = 'INSERT INTO store (uid_Command) VALUES (?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=1; $i <= 3; $i++) {
    $stmt->bindValue(1, $i);
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// STORE Foreign keys
$sql = 'UPDATE store SET uid_Invoices = (SELECT uid_Command FROM command WHERE command.uid_Command = store.uid_Command)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

// FILL
$sql = 'INSERT INTO fill (uid_Command) VALUES (?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=1; $i <= 3; $i++) {
    $stmt->bindValue(1, $i);
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// FILL Foreign keys
$sql = 'UPDATE fill SET credit_cardNB_Payment = (SELECT credit_cardNB_Payment FROM payment WHERE payment.uid_Payment = fill.uid_Command)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

$sql = 'UPDATE fill SET email_Address = (SELECT email_Address FROM address WHERE address.uid_Address = fill.uid_Command)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();

// E_CREATE
$sql = 'INSERT INTO e_create (uid_Command) VALUES (?)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
for ($i=1; $i <= 3; $i++) {
    $stmt->bindValue(1, $i);
    $stmt->execute();
    $insertedPKs[]= $db->lastInsertId();
}

// E_CREATE Foreign keys
$sql = 'UPDATE e_create SET uid_Cart = (SELECT uid_Cart FROM cart WHERE cart.uid_Command = e_create.uid_Command LIMIT 1)';
$stmt = $db->prepare($sql);

$insertedPKs = array();
$stmt->execute();
$insertedPKs[]= $db->lastInsertId();