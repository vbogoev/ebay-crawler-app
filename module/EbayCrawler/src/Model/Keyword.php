<?php

namespace EbayCrawler\Model;

class Keyword
{
    private int $id;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDateAdded(): \DateTime
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
        $this->setName($data['name'] ?? '');
        $this->setDateAdded(new \DateTime($data['date_added']));
    }
}
