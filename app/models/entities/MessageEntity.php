<?php

/**
 * Entité Message : un message est défini par :
 * - id (généré par la base)
 * - senderId (id de l’expéditeur)
 * - receiverId (id du destinataire)
 * - content (texte du message)
 * - sentAt (date/heure d’envoi)
 * - isRead (statut lu / non lu)
 */
class MessageEntity
{
    
    private ?int $id = null;
    private int $senderId;
    private int $receiverId;
    private string $content;
    private ?string $sentAt = null;
    private int $isRead = 0;

    /**
     * Constructeur
     * On crée un message avec les infos
     * - id : absent car généré par la base
     * - sentAt : peut être null si c'est la base qui met NOW()
     * - isRead : par défaut 0 (non lu)
     */
    public function __construct(
        int $senderId,
        int $receiverId,
        string $content,
        ?string $sentAt = null,
        int $isRead = 0
    ) {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->sentAt = $sentAt;
        $this->isRead = $isRead;
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

    // Getter pour l'expéditeur
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    // Setter pour l'expéditeur
    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    // Getter pour le destinataire
    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    // Setter pour le destinataire
    public function setReceiverId(int $receiverId): void
    {
        $this->receiverId = $receiverId;
    }

    // Getter pour le contenu
    public function getContent(): string
    {
        return $this->content;
    }

    // Setter pour le contenu
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    // Getter pour la date d'envoi
    public function getSentAt(): ?string
    {
        return $this->sentAt;
    }

    // Setter pour la date d'envoi
    public function setSentAt(?string $sentAt): void
    {
        $this->sentAt = $sentAt;
    }

    // Getter pour le statut lu/non lu
    public function getIsRead(): int
    {
        return $this->isRead;
    }

    // Setter pour le statut lu/non lu
    public function setIsRead(int $isRead): void
    {
        $this->isRead = $isRead;
    }
}