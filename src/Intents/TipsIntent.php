<?php

declare(strict_types=1);

namespace Bot\Intents;

use FondBot\Conversation\Activators\Activator;
use FondBot\Conversation\Intent;
use FondBot\Drivers\ReceivedMessage;
use Bot\Interactions\AskChampionAllyInteraction;

class TipsIntent extends Intent
{
    /**
     * Intent activators.
     *
     * @return Activator[]
     */
    public function activators(): array
    {
        return [
            $this->exact('/tips'),
            $this->contains('Dicas de Campeão'),
        ];
    }

    public function run(ReceivedMessage $message): void
    {
        $this->jump(AskChampionAllyInteraction::class);
    }
}
