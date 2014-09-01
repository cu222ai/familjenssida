<?php

class Photo extends Eloquent {

  protected $table = 'photos';
  public static $accessible = array('photo_name', 'photo_description', 'url', 'user_id', 'album_id');

  public static $rules = array(
     'file' => 'max:10000'
);


  public static function validate($data) {
    return Validator::make($data, static::$rules);
  }

  public function author()
  {
    return $this->belongsTo('User', 'user_id');
  }
    public function album()
  {
    return $this->belongsTo('Album', 'album_id');
  }

   public function photo_album()
     {
          return $this->hasManyAndBelongsTo('Album', 'album_photos');
     }


}
