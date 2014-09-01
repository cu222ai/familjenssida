<?php

class Friend extends Eloquent {


  protected $table = 'friends';
  public static $accessible = array('id', 'user_id', 'invited_by');

  public static $rules = array(

    'content' => 'required|min:3'
);


  public static function validate($data) {
    return Validator::make($data, static::$rules);
  }

  public function author()
  {
    return $this->hasManyAndBelongsTo('User', 'user_id');
  }


}
