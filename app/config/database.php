<?php

function dbConnect() {
    static $pdo = null; //variable statique  (singleton)

    if ($pdo !== null){
        return $pdo;
    }

    $host = 'localhost';
    $dbname = 'lis&relis';
    $username = 'root';
    $password = '';

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $options);
    } catch (PDOException $e) {
        die("connection to database failed :" . $e->getMessage());
    }

    return $pdo;
}