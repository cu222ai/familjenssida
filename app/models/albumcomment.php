<?php

class AlbumComment extends Eloquent {


  protected $table = 'album_comments';
  public static $accessible = array('content', 'user_id', 'album_id', 'id');

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
    return $this->belongsTo('Album', 'album_id');
  }
}
