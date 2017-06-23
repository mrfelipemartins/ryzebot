<?php

declare(strict_types=1);

namespace Bot\Intents;

use FondBot\Conversation\Activators\Activator;
use FondBot\Conversation\Intent;
use FondBot\Drivers\ReceivedMessage;
use GuzzleHttp\Client;
use LeagueWrap\Api;
use Bot\Models\Champion;
use Bot\Models\StaticData;

class ChampionIntent extends Intent
{
    /**
     * Intent activators.
     *
     * @return Activator[]
     */
    public function activators(): array
    {
        return [
            $this->exact('/freeweek'),
            $this->exact('Qual a freeweek?'),
            $this->exact('Quais campeões estão na freeweek?'),
            $this->contains('freeweek'),
            $this->contains('Rotação Grátis'),
        ];
    }

    public function run(ReceivedMessage $message): void
    {
      
      $freeweek = StaticData::find(1);
      if(is_null($freeweek->value)) {
        $data = StaticData::updateFreeWeek();
        $this->sendMessage("Rotação Grátis: ".$data);
      } else {
        $this->sendMessage("Rotação Grátis: ".$freeweek->value);  
      }
      
    }
}
