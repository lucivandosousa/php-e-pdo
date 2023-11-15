<?php

use App\Pdo\Domain\Model\Student;
use App\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once "./vendor/autoload.php";

$pdo = ConnectionCreator::createConnection();

$student = new Student(null, "Sousa", new DateTimeImmutable("1984-10-28"));
// $student = new Student(null, "Davi", new DateTimeImmutable("2018-08-11"));

$sql = "INSERT INTO students (name, birth_date) VALUES (?, ?)";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format("Y-m-d"));

if($statement->execute()){
  echo "Aluno adicionado";
}
