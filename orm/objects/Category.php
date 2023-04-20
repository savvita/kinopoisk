<?php

namespace objects;

class category
{
    private int $id;
    private string $value;
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
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

    public function setValue(string $value): void  {
        $this->value = $value;
    }

    public function __toString(): string {
        return $this->value;
    }

    public function equals($category) : bool {
        if($category === null) {
            return false;
        }

        if(!($category instanceof Category)) {
            return false;
        }

        return $this->id === $category->id && $this->value === $category->value;
    }
}