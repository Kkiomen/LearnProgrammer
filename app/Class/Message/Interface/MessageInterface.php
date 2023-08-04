<?php

namespace App\Class\Message\Interface;

interface MessageInterface
{
    public function getContent(): ?string;
    public function setContent(string|null $content): self;
    public function getSenderClass(): ?string;
    public function setSenderClass(string|null $senderClass): self;
    public function getSenderId(): ?int;
    public function setSenderId(int|null $senderId): self;
    public function getId(): ?int;
    public function setId(int|null $id): self;
}
