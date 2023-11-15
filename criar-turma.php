<?php

use App\Pdo\Domain\Model\Student;
use App\Pdo\Infrastructure\Persistence\ConnectionCreator;
use App\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once "vendor/autoload.php";

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

try {
    $connection->beginTransaction();

    // $aStudent = new Student(null, 'Nico Steppat', new DateTimeImmutable('1985-05-01'));

    // $studentRepository->save($aStudent);

    $anotherStudent = new Student(null, 'Marina Lopes', new DateTimeimmutable('1985-05-01'));

    $studentRepository->save($anotherStudent);

    $connection->commit();
} catch (\RuntimeException $e) {
    echo $e->getMessage();
    $connection->rollBack();
}

