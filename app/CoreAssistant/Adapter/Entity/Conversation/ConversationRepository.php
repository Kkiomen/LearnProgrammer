<?php

namespace App\CoreAssistant\Adapter\Entity\Conversation;

use App\CoreAssistant\Adapter\Repository\Interface\RepositoryInterface;
use App\CoreAssistant\Core\Collection\Collection;

interface ConversationRepository extends RepositoryInterface
{
    public function findAllMessages(string $sessionHash): ?Collection;
}
