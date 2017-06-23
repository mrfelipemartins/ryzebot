<?php

declare(strict_types=1);

namespace Bot\Interactions;

use FondBot\Conversation\Interaction;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\ReceivedMessage;
use Bot\Models\Champion;
use Bot\Models\EnemyTip;
use LeagueWrap\Api;
use Exception;

class AskChampionEnemyInteraction extends Interaction
{
    /**
     * Run interaction.
     *
     * @param ReceivedMessage $message
     */
    public function run(ReceivedMessage $message): void
    {
     
      $this->sendMessage('Contra quem você quer dicas?');
    }

    /**
     * Process received message.
     *
     * @param ReceivedMessage $reply
     */
    public function process(ReceivedMessage $reply): void
    {
      $champion = Champion::where(["name LIKE ?", "%".$reply->getText()."%"]);
      if($champion->count() == 0) {
        
        $this->sendMessage('Não consegui encontrar este campeão, tente novamente;');
        $this->restart();
        return;
        
      } else {
        
        foreach($champion as $champion) {
          
          $enemytips = EnemyTip::where(["champion_id = ?", $champion->id]);
          foreach($enemytips as $tip) {
            
            $this->sendMessage(utf8_encode($tip->enemytips));
            
          }
          
        }
        
      }
    }
}
