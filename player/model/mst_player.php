<?php 

class MstPlayer extends SQL {

  protected $table = 'mst_player';

  protected $columns = [
    'player_id' => '',
    'player_name' => '',
    'player_name_kana' => '',
    'sex_div' => '',
    'prefecture_cd' => '',
    'player_birthday' => '',
    'player_password' => '',
    'player_note' => ''
  ];
}

?>