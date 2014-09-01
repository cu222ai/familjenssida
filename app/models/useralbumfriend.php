<?php

class UserAlbumFriend extends Eloquent {
  protected $table = 'V_user_album_friends';
  public static $accessible = array('username', 'album_name', 'photo_url', 'album_id', 'firstname', 'lastname', 'user_id');




}
