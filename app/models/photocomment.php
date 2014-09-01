<?php

class PhotoComment extends Eloquent {


  protected $table = 'photo_comments';
  public static $accessible = array('content', 'user_id', 'photo_id', 'id');

  public static $rules = array(

    'content' => 'required|min:3'
);


  public static function validate($data) {
    return Validator::make($data, static::$rules);
  }

  public function author()
  {
    return $this->belongsTo('User', 'user_id');
  }
    public function photo()
  {
    return $this->belongsTo('Photo', 'photo_id');
  }
}
