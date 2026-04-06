<?php
$host    = 'lamp_db';
$db      = 'arqweb';
$user    = 'ougalde';
$pass    = '37863';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $cnx = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}
