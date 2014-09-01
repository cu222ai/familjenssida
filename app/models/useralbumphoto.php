<?php

class UserAlbumPhoto extends Eloquent {
  protected $table = 'V_user_album_photos';
  public static $accessible = array('username', 'album_name', 'photo_url', 'album_id', 'firstname', 'lastname', 'user_id', 'album_id');




}
