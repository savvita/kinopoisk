<?php

namespace objects;

class Movie
{
    private int $id;
    private string $title;
    private string $originalTitle;
    private string $description;
    private int $year;
    private int $duration;
    private Category $category;
    private float $rate;
    private int $votes;
    private bool $premium;
    private $directors = [];
    private $actors = [];

    public function __construct($id, $title, $originalTitle, $description, $year, $duration, $category, $rate, $votes, $premium, $directors = [], $actors = [])
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setOriginalTitle($originalTitle);
        $this->setDescription($description);
        $this->setYear($year);
        $this->setYear($duration);
        $this->setCategory($category);
        $this->setRate($rate);
        $this->setVotes($votes);
        $this->setPremium($premium);
        $this->addDirectors($directors);
        $this->addActors($actors);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getOriginalTitle(): string {
        return $this->originalTitle;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getVotes(): int {
        return $this->votes;
    }

    public function getRate(): float {
        return $this->rate;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function getCategory(): Category {
        return $this->category;
    }


    public function getActors(): array {
        return $this->actors;
    }

    public function getDirectors(): array {
        return $this->directors;
    }

    public function getPremium(): bool {
        return $this->premium;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTitle(string $title): void {
        if(strlen($title) > 100) {
            return;
        }

        $this->title = $title;
    }

    public function setOriginalTitle(string $originalTitle): void {
        if(strlen($originalTitle) > 100) {
            return;
        }

        $this->originalTitle = $originalTitle;
    }

    public function setCategory(Category $category): void
    {
        if($category !== null && $category instanceof Category) {
            $this->category = $category;
        }
    }

    public function setDescription(string $description): void {
        if(strlen($description) > 500) {
            return;
        }

        $this->description = $description;
    }

    public function setDuration(int $duration): void {
        if($duration < 0) {
            return;
        }

        $this->duration = $duration;
    }

    public function setPremium(bool $premium): void {
        $this->premium = $premium;
    }

    public function setRate(float $rate): void {
        if($rate < 0) {
            return;
        }
        $this->rate = $rate;
    }

    public function setVotes(int $votes): void  {
        if($votes < 0) {
            return;
        }

        $this->votes = $votes;
    }

    public function setYear(int $year): void {
        if($year < 1900 || $year > $year = getdate()["year"]) {
            return;
        }

        $this->year = $year;
    }


    public function addActors(...$artists) : void {
        foreach($artists as $artist) {
            if($artist instanceof Artist) {
                $this->actors[] = $artist;
            }
        }
    }

    public function addDirectors($directors) : void {
        foreach($directors as $director) {
            if($director instanceof Director) {
                $this->actors[] = $director;
            }
        }
    }

    public function __toString(): string {
        return "$this->title ($this->originalTitle) ($this->year)";
    }

    public function equals($movie) : bool {
        if($movie === null) {
            return false;
        }

        if(!($movie instanceof Movie)) {
            return false;
        }

        return $this->id === $movie->id && $this->title === $movie->title && $this->originalTitle = $movie->originalTitle;
    }
}