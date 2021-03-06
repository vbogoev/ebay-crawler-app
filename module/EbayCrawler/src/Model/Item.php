<?php

namespace EbayCrawler\Model;

class Item
{
    private int $id = 0;
    private int $countryId;
    private int $keywordId;
    private int $externalId;
    private string $title;
    private string $link;
    private string $image;
    private string $price;
    private string $shipping;
    private int $order;
    private \DateTime $dateAdded;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCountryId(): int
    {
        return $this->countryId;
    }

    public function setCountryId(int $countryId): void
    {
        $this->countryId = $countryId;
    }

    public function getKeywordId(): int
    {
        return $this->keywordId;
    }

    public function setKeywordId(int $keywordId): void
    {
        $this->keywordId = $keywordId;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getShipping(): string
    {
        return $this->shipping;
    }


    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setShipping(string $shipping): void
    {
        $this->shipping = $shipping;
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
        $this->setCountryId($data['country_id'] ?? 0);
        $this->setKeywordId($data['keyword_id'] ?? 0);
        $this->setExternalId($data['external_id'] ?? 0);
        $this->setTitle($data['title'] ?? '');
        $this->setImage($data['image'] ?? '');
        $this->setLink($data['link'] ?? '');
        $this->setPrice($data['price'] ?? '');
        $this->setShipping($data['shipping'] ?? '');
        $this->setOrder($data['order'] ?? 0);
        $this->setDateAdded(new \DateTime($data['date_added']));
    }
}
