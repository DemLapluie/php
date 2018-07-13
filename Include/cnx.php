<?php

$pdo = new PDO(
    'mysql:host=localhost;dbname=eboutique', // chaîne de connexion
    'root', // utilisateur 
    '', // mot de passe
    // tableau d'options (facultatif)
    [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);


