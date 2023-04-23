<?php

namespace models;

class Role
{
    private int $id;
    private string $value;

    public function __construct($id, $value)
    {
        $this->setId($id);
        $this->setValue($value);
    }

    public function getId(): int {
        return $this->id;
    }
    public function getValue(): string {
        return $this->value;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setValue(string $value): void {
        if(empty($value) || strlen($value) > 50) {
            return;
        }

        $this->value = $value;
    }

    public function __toString(): string {
        return $this->value;
    }

    public function equals($role) : bool {
        if($role === null) {
            return false;
        }

        if(!($role instanceof Role)) {
            return false;
        }

        return $this->id === $role->id && $this->value === $role->value;
    }
}