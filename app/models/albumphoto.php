<?php

class AlbumPhoto extends Eloquent {

  protected $table = 'album_photos';
  public static $accessible = array('photo_id', 'album_id');


 public static $rules = array(
    'photo_id'=>'unique:album_photos|required',
    'album_id'=>'required'
  );

  public static function validate($data) {
    return Validator::make($data, static::$rules);
  }

    public function album()
  {
    return $this->hasMany('Album', 'id');
 }

   public function photo()
  {
    return $this->hasMany('Photo', 'id');
  }


}
