<?php

use App\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$sql = "DELETE FROM students WHERE id = ?;";

$statement = $pdo->prepare($sql);
$statement->bindValue(1, 1);

if($statement->execute()){
  echo "Aluno excluído!";
}