<?php

class AlbumController extends BaseController {

  public function getIndex()
  {
      if (Auth::guest())
    {
          return Redirect::route('login');

    }



    return View::make('album.index')
      ->with('title', 'Albums')
      ->with('albums', Album::where('user_id','=', Auth::user()->id)->orderBy('id')->get())
      ->with('friend_albums', UserAlbumFriend::where('user_id','=', Auth::user()->id)->orderBy('id')->get())
      ->with('friends', Friend::where('user_id','=', Auth::user()->id)->lists('invited_by','id'));

}

   public function getView($name) {

      if (Auth::guest())
    {
          return Redirect::route('login');

    }
    $album = Album::find($name);
    // if($album->photo_url == 0){

    //   $album_photos =  AlbumPhoto::leftJoin('photos', 'photos.id', '=', 'album_photos.photo_id')
    //       ->get(array('photos.photo_name', 'photos.url', 'photos.user_id', 'photos.id', 'album_photos.photo_id', 'album_photos.album_id', 'album_photos.id')->take(1)->get());
    // $album_photos->url = $photo_url;

    // Album::update($name, array(
    //     'photo_url'=>$photo_url,
    //           ));

    // }
    if($album->public == 1 or $album->user_id == Auth::user()->id){

        return View::make('album.view')

          ->with('album', Album::find($name))
          ->with('album_photos', AlbumPhoto::leftJoin('photos', 'photos.id', '=', 'album_photos.photo_id')
          ->get(array('photos.photo_name', 'photos.url', 'photos.user_id', 'photos.id', 'album_photos.photo_id', 'album_photos.album_id', 'album_photos.id')))
          ->with('photos', Photo::orderBy('id')->get())
          ->with('photo_options', Photo::where('user_id', '=', Auth::user()->id)->lists('photo_name','id'))
          ->with('comments', AlbumComment::where('album_id','=', $name)->orderBy('id', 'desc')->get());
        }
        else{
                 return Redirect::back()
        ->with('flash_error', 'Det här albumet är flaggat som privat!');
        }

}

  public function getNewPhoto($name)   {

      if (Auth::guest()){
          return Redirect::route('login');
    }
    $album_id = Album::find($name);
    $current_user = Album::where('user_id', '=', Auth::user()->id)->only('user_id');


   if($current_user != $album_id->user_id){
        return Redirect::route('album', $name)
        ->with('flash_error', 'Du kan inte lägga till foton till detta album om du inte är ägaren till det!');
    }


    return View::make('album.new_photo')
    ->with('album', Album::find($name))
    ->with('photos', Photo::orderBy('id')->get())
    ->with('album_photos', AlbumPhoto::leftJoin('photos', 'photos.id', '=', 'album_photos.photo_id')
          ->get(array('photos.photo_name', 'photos.url', 'photos.user_id', 'photos.id', 'album_photos.photo_id', 'album_photos.album_id', 'album_photos.id')))
    ->with('photo_user', Photo::where('user_id', '=', Auth::user()->id)->only('user_id'))
      ->with('photo_options', Photo::where('user_id', '=', Auth::user()->id)->lists('photo_name','id'));

    }


    public function postCreatePhoto(){

          if (Auth::guest())
    {
          return Redirect::route('login');

    }
    $validation = AlbumPhoto::validate(Input::all());

    if ($validation->fails()) {
      return Redirect::route('new_aphoto', Input::get('album_id'))->withErrors($validation)->withInput();
    }
    else{

       AlbumPhoto::create(array(
        'album_id'=>Input::get('album_id'),
        'photo_id'=>Input::get('photo_id'),
              ));
        return Redirect::route('album', Input::get('album_id'))
        ->with('flash_notice', 'Fotot lades till i albumet!!');
    }
  }


   public function getFrontPhoto($name)   {

      if (Auth::guest()){
          return Redirect::route('login');
    }
    $album_id = Album::find($name);
    $current_user = Album::where('user_id', '=', Auth::user()->id)->only('user_id');


   if($current_user != $album_id->user_id){
        return Redirect::route('album', $name)
        ->with('flash_error', 'Du kan inte lägga till framsidebild till detta album om du inte är ägaren till det!');
    }


    return View::make('album.new_front_photo')
    ->with('album', Album::find($name))
    ->with('photos', Photo::orderBy('id')->get())
    ->with('album_photos', AlbumPhoto::leftJoin('albums', 'albums.id', '=', 'album_photos.album_id')
          ->get(array('albums.photo_url', 'albums.user_id')))
    ->with('photo_user', Photo::where('user_id', '=', Auth::user()->id)->only('user_id'))
      ->with('photo_options', Photo::where('user_id', '=', Auth::user()->id)->lists('photo_name', 'url','id'));

    }

      public function postCreateFrontPhoto()   {

      if (Auth::guest()){
          return Redirect::route('login');
    }
  $id = Input::get('id');
    $input = Input::all();
     $rules = array(
            'photo_url'=>'required|min:2'
      );
        $validation = Validator::make($input, $rules);

    if ($validation->fails()) {
      return Redirect::route('front_photo', Input::get('album_id'))->withErrors($validation)->withInput();
    }
    else{

       Album::update(Input::get('album_id'), array(
        'photo_url'=>Input::get('photo_url'),
              ));
        return Redirect::route('album', Input::get('album_id'))
        ->with('flash_notice', 'Framsida till album sparad!');
    }
    }

     public function postMakePublic()   {

          if (Auth::guest()){
              return Redirect::route('login');
        }

        $id = Input::get('id');

       Album::update($id, array(
            'public'=>1,
                  ));
            return Redirect::route('album', $id)
             ->with('flash_notice', 'Albumet är nu publikt');
    }


      public function postMakePrivate()   {

          if (Auth::guest()){
              return Redirect::route('login');
        }
         $id = Input::get('id');

       Album::update($id, array(
            'public'=>0,
                  ));
            return Redirect::route('album', $id)
              ->with('flash_notice', 'Albumet är nu privat');
    }



  public function getNew() {

      if (Auth::guest())
    {
          return Redirect::route('login');
    }
    return View::make('album.new');

  }

  public function getAlbumPermission()
  {
     if (Auth::guest())
    {
          return Redirect::route('login');
    }


  }

  public function postCreate() {

      if (Auth::guest())
    {
          return Redirect::route('login');

    }

    $validation = Album::validate(Input::all());

    if ($validation->fails()) {
      return Redirect::route('new_album')->withErrors($validation)->withInput();
    } else {
      Album::create(array(
        'album_name'=>Input::get('album_name'),
        'album_description'=>Input::get('album_description'),
        'user_id' => Auth::user()->id,
      ));
      return Redirect::route('albums')
        ->with('flash_notice', 'Album skapat!');
    }
  }

  public function getEdit($id) {

      if (Auth::guest())
    {
          return Redirect::route('login');

    }
    $album_id = Album::find($id);
    $current_user = Album::where('user_id', '=', Auth::user()->id)->only('user_id');

   if($current_user != $album_id->user_id){
        return Redirect::route('album', $id)
        ->with('flash_error', 'Du kan inte redigera ett album om du inte är ägaren till det!');
    }

    return View::make('album.edit')
      ->with('album', Album::find($id));
  }

  public function putUpdate() {
      if (Auth::guest())
    {
          return Redirect::route('login');

    }
    $id = Input::get('id');
    $input = Input::all();
     $rules = array(
            'name'=>'required|min:2',
            'description'=>'required|min:10'
        );
        $validation = Validator::make($input, $rules);

    if ($validation->fails()) {
      return Redirect::route('edit_album', $id)->withErrors($validation);
    } else {
      Album::update($id, array(
        'album_name'=>Input::get('name'),
        'album_description'=>Input::get('description')
      ));
      return Redirect::route('album', $id)
        ->with('flash_notice', 'Album redigerat!');
    }
  }

    public function deleteDestroy() {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }
      Album::find(Input::get('id'))->delete();
      return Redirect::route('albums')
        ->with('flash_notice', 'Albumet borttaget!');
    }

      public function deleteRemove() {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }

         AlbumPhoto::find(Input::get('apid'))->delete();

      return Redirect::route('album', Input::get('album_id'))
        ->with('flash_notice', 'Fotot borttaget från album!');
    }
    public function postCreateComment() {

      if (Auth::guest())
    {
          return Redirect::route('login');

    }

    $validation = AlbumComment::validate(Input::all());

    if ($validation->fails()) {
        return Redirect::route('album', Input::get('album_id'))->withErrors($validation)->withInput();
    } else {
      AlbumComment::create(array(
        'album_id'=>Input::get('album_id'),
        'user_id' => Auth::user()->id,
        'content' => Input::get('content')
      ));

         return Redirect::route('album', Input::get('album_id'))->with('flash_notice', 'Kommenterade album!');
    }
  }

     public function deleteRemoveComment() {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }
          AlbumComment::find(Input::get('id'))->delete();

      return Redirect::route('album', Input::get('album_id'))
        ->with('flash_notice', 'Kommentar borttagen!');
    }

    public function putUpdateComment() {
      if (Auth::guest())
    {
          return Redirect::route('login');

    }
          $id = Input::get('id');
            $input = Input::all();
             $rules = array(
            'edited'=>'required|min:3',

        );
        $validation = Validator::make($input, $rules);


    if ($validation->fails()) {
      return Redirect::route('album', Input::get('album_id'))->withErrors($validation);
    } else {
      AlbumComment::update(Input::get('id'), array(
         'content' => Input::get('edited')

      ));
            return Redirect::route('album', Input::get('album_id'))
        ->with('flash_notice', 'Kommentar redigerad!');
    }
  }



  }

