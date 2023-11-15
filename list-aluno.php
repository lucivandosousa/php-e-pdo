<?php

use App\Pdo\Domain\Model\Student;
use App\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once "./vendor/autoload.php";

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->query("SELECT * FROM students");

while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
  $studant = new Student(
    $studentData['id'],
    $studentData['name'],
    new DateTimeImmutable($studentData['birth_date'])
  );

  echo $studant->name();
}