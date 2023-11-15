<?php

use App\Pdo\Domain\Model\Student;
use App\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once "./vendor/autoload.php";
// require_once "./src/Infrastructure/Persistence/ConnectionCreator.php";

$pdo = ConnectionCreator::createConnection();

$statement = $pdo->query("SELECT * FROM students;");
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

foreach ($studentDataList as $studentData) {
  $studentList[] = new Student(
    $studentData['id'],
    $studentData['name'],
    new DateTimeImmutable($studentData['birth_date'])
  );
}

// var_dump($studentDataList);
print_r($studentList);