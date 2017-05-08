<?php

require_once __DIR__.'/../vendor/autoload.php'; // load composer

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

$pdo = new PDO('mysql:host=localhost;dbname=tweets', 'root', '');
$pdo->query('CREATE TABLE IF NOT EXISTS tweets (id INT, `user` VARCHAR(255), tweet VARCHAR(255), PRIMARY KEY (`id`))');

$config = new LexerConfig();
$lexer = new Lexer($config);

$interpreter = new Interpreter();

$interpreter->addObserver(function(array $columns) use ($pdo) {
    $stmt = $pdo->prepare('REPLACE tweets (id, user, tweet) VALUES (?, ?, ?)');
    $stmt->execute($columns);
});

$lexer->parse('training_data.csv', $interpreter);
