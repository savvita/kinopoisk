<?php

namespace controllers;
use objects\User;

require_once __DIR__ . '\..\objects\User.php';
require_once 'Repository.php';
class UserRepository extends Repository
{
    private function validate($entity) : bool {
        if($entity === null) {
            return false;
        }

        if(empty($entity->getLogin()) || empty($entity->getPassword())) {
            return false;
        }

        if(strlen($entity->getLogin()) < 4 || strlen($entity->getLogin()) > 15) {
            return false;
        }

        if(strlen($entity->getPassword()) < 4 || strlen($entity->getPassword()) > 15) {
            return false;
        }

        return true;
    }

    public function create($entity)
    {
        if($entity === null) {
            return null;
        }

        if($this->validate($entity) === false) {
            return null;
        }

        $users = $this->select($entity->getLogin());
        if($users !== null || count($users) !== 0) {
            return null;
        }

        $connection = null;
        $result = null;

        try {
            $connection = $this->db->connect();

            if($connection->connect_error) {
                return null;
            }
            $stmt = $connection->prepare("INSERT INTO users(login, password, premium) VALUES (?, ?, ?)");

            $login = trim($entity->getLogin());
            $password = trim($entity->getPassword());
            $premium = $entity->getPremium();
            $stmt->bind_param('ssi', $login, $password, $premium);

            if ($stmt->execute() === true) {
                $result = new \objects\User($connection->insert_id, $entity->getLogin(), $entity->getPassword(), $entity->getPremium());
            }

        } finally {
            $connection?->close();
        }

        return $result;
    }

    public function select(string $searchTxt)
    {
        $connection = null;

        $values = [];

        try {
            $connection = $this->db->connect();
            $query = "SELECT * FROM users";

            if (!empty($searchTxt)) {
                $searchTxt = trim($searchTxt);
                $query .= " WHERE login = ?";
            }
            $stmt = $connection->prepare($query);

            if(!empty($searchTxt)) {
                $stmt->bind_param('s', $searchTxt);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $values[] = new User($row[0], $row[1], $row[2], $row[3]);
            }

        } finally {
            $connection?->close();
        }

        return $values;
    }

    public function update($entity)
    {
        if($entity === null) {
            return;
        }
        if($this->validate($entity) === false) {
            return null;
        }

        if($this->select($entity->getLogin()) !== null) {
            return null;
        }


        $connection = null;

        try {
            $connection = $this->db->connect();

            if($connection->connect_error) {
                return false;
            }
            $stmt = $connection->prepare("UPDATE users SET login=?, password=?, premium=? WHERE id=?");

            $id = $entity->getId();
            $login = $entity->getLogin();
            $password = $entity->getPassword();
            $premium = $entity->getPremium();
            $stmt->bind_param("ssii", $login, $password, $premium, $id);

            $stmt->execute();
        } finally {
            $connection?->close();
        }

        return $entity;
    }

    public function delete($id)
    {
        if($id === null) {
            return false;
        }

        $connection = null;

        try {
            $connection = $this->db->connect();
            if($connection->connect_error) {
                return false;
            }
            $stmt = $connection->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->affected_rows;
        } finally {
            $connection->close();
        }

        return $res !== 0;
    }
}