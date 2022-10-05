<?php 

class MstPlayer extends SQL {

  protected $table = 'mst_player';

  protected $columns = [
    'player_id' => '',
    'player_name' => '',
    'player_name_kana' => '',
    'sex_div' => '',
    'prefecture_cd' => '',
    'ability_cd' => '',
    'player_age' => '',
    'player_password' => '',
    'player_note' => '',
    'insert_at' => '',
    'update_at' => ''
  ];
}

?>