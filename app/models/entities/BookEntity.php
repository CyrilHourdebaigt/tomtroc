<?php

// Entité Book : un book est défini par son id, titre, auteur, description, image, statut et propriétaire

class BookEntity
{
    private ?int $id = null;
    private string $title;
    private string $author;
    private string $description;
    private ?string $image = null;
    private string $status;
    private int $userId;

    /**
     * Constructeur
     * On crée un livre avec ses informations
     * L'id est volontairement absent ici car il est généré par la base de données
     */
    public function __construct(
        string $title,
        string $author,
        string $description,
        string $status,
        int $userId,
        ?string $image = null
    ) {
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->status = $status;
        $this->userId = $userId;
        $this->image = $image;
    }

    
    // Getter pour l'id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Setter pour l'id
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    // Getter pour le titre
    public function getTitle(): string
    {
        return $this->title;
    }

    // Setter pour le titre
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    // Getter pour l'auteur
    public function getAuthor(): string
    {
        return $this->author;
    }

    // Setter pour l'auteur
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    // Getter pour la description
    public function getDescription(): string
    {
        return $this->description;
    }

    // Setter pour la description
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    // Getter pour l'image
    public function getImage(): ?string
    {
        return $this->image;
    }

    // Setter pour l'image
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    // Getter pour le statut
    public function getStatus(): string
    {
        return $this->status;
    }

    // Setter pour le statut
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    // Getter pour l'id du propriétaire
    public function getUserId(): int
    {
        return $this->userId;
    }

    // Setter pour l'id du propriétaire
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}