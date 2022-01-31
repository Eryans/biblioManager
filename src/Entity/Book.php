<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    #[ORM\Column(type: 'string', length: 100)]
    private $author;

    #[ORM\Column(type: 'string', length: 400, nullable: true)]
    private $summary;

    #[ORM\Column(type: 'date', nullable: true)]
    private $release_date;

    #[ORM\Column(type: 'string', length: 50)]
    private $category;

    #[ORM\Column(type: 'boolean')]
    private $for_child;

    #[ORM\Column(type: 'boolean')]
    private $available;

    #[ORM\ManyToOne(targetEntity: client::class, inversedBy: 'books')]
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getForChild(): ?bool
    {
        return $this->for_child;
    }

    public function setForChild(bool $for_child): self
    {
        $this->for_child = $for_child;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
