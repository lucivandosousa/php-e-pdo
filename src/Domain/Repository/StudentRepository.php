<?php

namespace App\Pdo\Domain\Repository;

use App\Pdo\Domain\Model\Student;

interface StudentRepository
{
  public function allStudents();
  public function studentsBirthAt(\DateTimeInterface $birthDate);
  public function save(Student $student);
  public function remove(Student $student);
}
