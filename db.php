<?php

function getPDO(): PDO
{
    $host = 'localhost';
    $username = 'root';
    $password = 'root';
    $dbName = 'myDB';

    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

function showAndDie($somethin)
{
    echo '<pre>';
    var_dump($somethin);
    echo '</pre>';
    die();
}

function getAllMessages(PDO $pdo): array
{
    $data = [];
    $sql = "SELECT * FROM messages";
    $queryRunner = $pdo->query($sql);
    $queryRunner->setFetchMode(PDO::FETCH_ASSOC);

    while ($row = $queryRunner->fetch()) {
        $data[] = $row;
    }

    return $data;
}

function addNewMessage(PDO $pdo, string $name, string $message)
{
    $sql = "INSERT INTO messages (name, message) VALUES (:name, :message)";

    $queryRunner = $pdo->prepare($sql);

    $params = compact('name', 'message');

    if (!$queryRunner->execute($params)) {
        echo 'Something went wrong';
    }
}

function deleteMessage($pdo, $id)
{
    $sql = "DELETE FROM messages WHERE id=:id";

    $queryRunner = $pdo->prepare($sql);

    if (!$queryRunner->execute(['id' => $id])) {
        echo 'Something went wrong';
    }
}
