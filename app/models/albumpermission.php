<?php

class AlbumPermission extends Eloquent {


  protected $table = 'album_permissions';
  public static $accessible = array('user_id', 'album_id');

  public static $rules = array(

    'content' => 'required|min:3'
);


  public static function validate($data) {
    return Validator::make($data, static::$rules);
  }

  public function user()
  {
    return $this->hasManyAndBelongsTo('User', 'user_id');
  }

    public function album()
  {
    return $this->hasManyAndBelongsTo('Album', 'album_id');
  }

}
