<?php

use App\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Sousa',
    new \DateTimeImmutable('1984-10-15')
);

echo $student->age() . PHP_EOL;
echo $student->name() . PHP_EOL;
