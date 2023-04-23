<?php

namespace controllers;
use models;
require_once 'db/Models/Movie.php';
require_once 'db/Models/Employee.php';
require_once 'db/Controllers/Repository.php';

class MovieRepository extends Repository
{

    public function create($entity)
    {
        if($entity === null) {
            return null;
        }
        $connection = null;
        $result = null;

        try {
            $connection = $this->db->connect();

            if($connection->connect_error) {
                return null;
            }
            $stmt = $connection->prepare("INSERT INTO movies(`title`, `originalTitle`, `description`, `year`, `duration`, `categoryId`, `rate`, `votes`, `premium`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $title = trim($entity->getTitle());
            $originalTitle = trim($entity->getOriginalTitle());
            $description = trim($entity->getDescription());
            $duration = $entity->getDuration();
            $year = $entity->getYear();
            $category = $entity->getCategory();
            $categoryId = $entity->getCategory()->getId();
            $votes = $entity->getVotes();
            $rates = $entity->getRate();
            $premium = $entity->getPremium();


            $stmt->bind_param('sssiiidii', $title, $originalTitle, $description, $year, $duration, $categoryId, $rates, $votes, $premium);

            if ($stmt->execute() === true) {
                $result = new \models\Movie($connection->insert_id, $title, $originalTitle, $description, $year, $duration, $category, $rates, $votes, $premium);
                $staff = $entity->getStaff();
                foreach($staff as $employee) {
                    $res = $this->saveEmployee($connection, $employee, $result->getId());
                    if($res === true) {
                        $result->addStaff($employee);
                    }
                }
            }

        } finally {
            $connection?->close();
        }

        return $result;
    }

    private function saveEmployee(\mysqli $connection, models\Employee $employee, int $movieId) : bool {
        if($connection === null || $employee === null || $employee->getPerson() === null || $employee->getRole() === null) {
            return false;
        }

        $stmt = $connection->prepare("INSERT INTO person_movie(`person_id`, `role_id`, `movie_id`) VALUES (?, ?, ?)");

        $person_id = $employee->getPerson()->getId();
        $role_id = $employee->getRole()->getId();
        $movie_id = $movieId;


        $stmt->bind_param('iii', $person_id, $role_id, $movie_id);

        return $stmt->execute();
    }

    public function select(string $searchTxt = null)
    {
        $connection = null;

        $values = [];

        try {
            $connection = $this->db->connect();
            $query = "SELECT * FROM movies JOIN categories ON categoryId=categories.id";

            if (!empty($searchTxt)) {
                $searchTxt = trim($searchTxt);
                $query .= " WHERE title LIKE ? OR originalTitle LIKE ?";
            }
            $stmt = $connection->prepare($query);

            if(!empty($searchTxt)) {
                $value = "%{$searchTxt}%";
                $stmt->bind_param('ss', $value, $value);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $movie = new models\Movie($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], new models\Category($row[6], $row[11]), $row[7], $row[8], $row[9]);
                $staff = $this->loadStaff($connection, $movie->getId());
                $movie->addStaff(...$staff);
                $values[] = $movie;
            }

        } finally {
            $connection?->close();
        }

        return $values;
    }

    private function loadStaff(\mysqli $connection, int $movieId) : array {
        $query = "SELECT * FROM person_movie JOIN people ON person_id = people.id JOIN roles ON role_id = roles.id WHERE movie_id = ?";

        $stmt = $connection->prepare($query);

        $stmt->bind_param('i', $movieId);

        $stmt->execute();

        $result = $stmt->get_result();

        $values = [];
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $values[] = new models\Employee($row[0], new models\Person($row[4], $row[5]), new models\Role($row[6], $row[7]));
        }

        return $values;
    }

    public function update($entity)
    {
        if($entity === null) {
            return;
        }

        $connection = null;

        try {
            $connection = $this->db->connect();

            if($connection->connect_error) {
                return false;
            }

            $stmt = $connection->prepare("UPDATE movies SET title=?,originalTitle=?,description=?,year=?,duration=?,categoryId=?,rate=?,votes=?,premium=? WHERE id=?");

            $title = trim($entity->getTitle());
            $originalTitle = trim($entity->getOriginalTitle());
            $description = trim($entity->getDescription());
            $duration = $entity->getDuration();
            $year = $entity->getYear();
            $category = $entity->getCategory()->getId();
            $votes = $entity->getVotes();
            $rates = $entity->getRate();
            $premium = $entity->getPremium();
            $id = $entity->getId();

            $stmt->bind_param('sssiiidiii', $title, $originalTitle, $description, $year, $duration, $category, $rates, $votes, $premium, $id);

           if($stmt->execute() === true) {
               $this->updateStaff($connection, $id, $entity->getStaff());
           }
        } finally {
            $connection?->close();
        }

        return $entity;
    }

    private function updateStaff(\mysqli $connection, int $movieId, array $newStaff) {
        $oldStaff = $this->loadStaff($connection, $movieId);

        $added_staff = array_udiff($newStaff, $oldStaff, function($employee_1, $employee_2) {
            return $employee_1->getId() <=> $employee_2->getId();
        });

        foreach($added_staff as $employee) {
            $this->saveEmployee($connection, $employee, $movieId);
        }

        $deletedStaff = array_udiff($oldStaff, $newStaff, function($employee_1, $employee_2) {
            return $employee_1->getId() <=> $employee_2->getId();
        });

        foreach($deletedStaff as $employee) {
            $this->deleteEmployee($connection, $employee->getId());
        }
    }

    private function deleteEmployee(\mysqli $connection, int $employeeId) : bool {
        $stmt = $connection->prepare("DELETE FROM person_movie WHERE id=?");
        $stmt->bind_param("i", $employeeId);
        return $stmt->execute();
    }

    public function delete($id)
    {
        if($id === null) {
            return;
        }

        $connection = null;

        try {
            $connection = $this->db->connect();
            if($connection->connect_error) {
                return false;
            }

            $stmt = $connection->prepare("DELETE FROM person_movie WHERE movie_id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt = $connection->prepare("DELETE FROM movies WHERE id=?");
            $stmt->bind_param("i", $id);
            $res = $stmt->execute();
        } finally {
            $connection->close();
        }

        return $res;
    }


}