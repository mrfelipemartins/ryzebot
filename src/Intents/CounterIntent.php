<?php

declare(strict_types=1);

namespace Bot\Intents;

use FondBot\Conversation\Activators\Activator;
use FondBot\Conversation\Intent;
use FondBot\Drivers\ReceivedMessage;
use Bot\Interactions\AskChampionEnemyInteraction;

class CounterIntent extends Intent
{
    /**
     * Intent activators.
     *
     * @return Activator[]
     */
    public function activators(): array
    {
        return [
            $this->exact('/counter'),
            $this->contains(['Dicas de Counter']),
        ];
    }

    public function run(ReceivedMessage $message): void
    {
        $this->jump(AskChampionEnemyInteraction::class);
    }
}
