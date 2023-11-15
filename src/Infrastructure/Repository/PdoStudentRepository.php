<?php

namespace App\Pdo\Infrastructure\Repository;

use App\Pdo\Domain\Model\Student;
use App\Pdo\Domain\Repository\StudentRepository;
use PDO;
use RuntimeException;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    private function hydrateStudentList(\PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );
        }

        return $studentList;
    }

    public function allStudents()
    {
        $sql = "SELECT * FROM studens;";
        $stmt = $this->connection->query($sql);

        return $this->hydrateStudentList($stmt);
    }

    public function studentsBirthAt(\DateTimeInterface $birthDate)
    {
        $sql = "SELECT * FROM students WHERE birth_date = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $birthDate->format("Y-m-d"));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    public function save(Student $student)
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function insert(Student $student)
    {
        $sql = "INSERT INTO student (name, birth_date) VALUES (:name, :birth_date);";
        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException($this->connection->errorInfo()[2]);
        }

        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    public function update(Student $student)
    {
        $sql = "UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":name", $student->name());
        $stmt->bindValue(":birth_date", $student->birthDate()->format("Y-m-d"));
        $stmt->bindValue(":id", $student->id());

        return $stmt->execute();
    }

    public function remove(Student $student)
    {
        $sql = "DELETE FROM studens WHERE id = ?;";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $student->id());

        return $stmt->execute();
    }
}
