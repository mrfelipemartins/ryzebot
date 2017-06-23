<?php
namespace Bot\Models;

use TORM\Model;

class Champion extends Model
{
  private static $_has_many = [
     ['enemytips']
   ];
}