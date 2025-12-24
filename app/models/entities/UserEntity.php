<?php

// Entité User : un user est défini par son id, username, email, avatar.

class UserEntity
{
    private ?int $id = null;
    private string $username;
    private string $email;
    private ?string $avatar = null;

    public function __construct(string $username, string $email, ?string $avatar = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->avatar = $avatar;
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

    // Getter pour le usurname
    public function getUsername(): string
    {
        return $this->username;
    }
    // Setter pour le usurname
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    // Getter pour l'email
    public function getEmail(): string
    {
        return $this->email;
    }
    // Setter pour l'email
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    // Getter pour l'avatar
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
    // Setter pour l'avatar
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
