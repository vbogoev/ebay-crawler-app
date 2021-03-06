<?php

namespace EbayCrawler\Model;

class Country
{
    private int $id;
    private string $abbreviation;
    private string $name;
    private \DateTime $dateAdded;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTime $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    public function exchangeArray(array $data)
    {
        $this->setId($data['id'] ?? 0);
        $this->setAbbreviation($data['abbreviation'] ?? '');
        $this->setName($data['name'] ?? '');
        $this->setDateAdded(new \DateTime($data['date_added']));
    }
}
