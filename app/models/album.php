<?php

class Album extends Eloquent {
  protected $table = 'albums';
  public static $accessible = array('album_name', 'album_description', 'user_id', 'public', 'photo_url');

  public static $rules = array(
    'album_name'=>'required|min:2',
    'album_description'=>'required|min:10'
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
    return $this->hasMany('Photo', 'photo_id');
  }

   public function album_photo()
     {
          return $this->hasManyAndBelongsTo('Photo', 'album_photos');
     }
}
