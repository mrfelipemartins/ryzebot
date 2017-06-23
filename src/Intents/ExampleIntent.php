<?php

declare(strict_types=1);

namespace Bot\Intents;

use FondBot\Conversation\Intent;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Conversation\Activators\Activator;
use FondBot\Templates\Keyboard;

class ExampleIntent extends Intent
{
    /**
     * Intent activators.
     *
     * @return Activator[]
     */
    public function activators(): array
    {
        return [
            $this->exact('/start'),
            $this->contains('start'),
            $this->contains('Começar'),
        ];
    }

    public function run(ReceivedMessage $message): void
    {
        $keyboard = (new Keyboard)
          ->addButton(
              (new Keyboard\ReplyButton)->setLabel('Rotação Grátis')
          )
          ->addButton(
              (new Keyboard\ReplyButton)->setLabel('Dicas de Campeão')
          )
          ->addButton(
              (new Keyboard\ReplyButton)->setLabel('Dicas de Counter')
          )
          ->addButton(
              (new Keyboard\ReplyButton)->setLabel('Partida Ativa')
          );
        $this->sendMessage('Olá, eu sou o Ryze Bot, como posso te ajudar?', $keyboard);
        
    }
}
