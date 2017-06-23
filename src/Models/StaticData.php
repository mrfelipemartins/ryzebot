<?php
namespace Bot\Models;

use TORM\Model;
use GuzzleHttp\Client;
use LeagueWrap\Api;
use Bot\Models\Champion;

class StaticData extends Model
{
  
  public function updateFreeWeek() {
    $api = new Api('RGAPI-f7feb1c3-be52-418b-824d-2315f756dfe2');
    $api->limit(10, 10);
    $api->remember(60);
    $api->limit(500, 600);
    $api->attachStaticData();
    $champion = $api->champion();
    $freeweek = $champion->free();
    $mensagem = "";
    foreach($freeweek as $champion) {
      $boneco = Champion::find($champion->id);
      $mensagem .= $boneco->name.", ";
    } 
    $fw = StaticData::find(1);
    $fw->updateAttributes(array("value"=>$mensagem));
    return $mensagem;
  }
}