  <?php

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\PublicAccessType;
use WindowsAzure\Common\ServiceException;

  class PhotoController extends BaseController {

    public function getIndex()
    {

        if (Auth::guest())
    {
          return Redirect::route('login');

    }

       $connectionString = "DefaultEndpointsProtocol=https;
      AccountName=familjenssida;
      AccountKey=oWdckF2RStEJm4fXn3iU6r3e6Cr1bSs9Ep/cZqqKXzsfwkB7Y9fNNiNph6lCoc8zl3gMyy0vefctiyiOybIY9w==";


  // Create blob REST proxy.
$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);


      $blob_list = $blobRestProxy->listBlobs("pictures01");





return View::make('photo.index')
        ->with('title', 'Photos')
          ->with('u_photos', Photo::where('user_id','=', Auth::user()->id)->orderBy('id', 'desc')->get())
          ->with('blobs',  $blobs = $blob_list->getBlobs());

}

    public function getView($id) {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }
          return View::make('photo.view')

            ->with('photo', Photo::find($id))
             ->with('albums', AlbumPhoto::leftJoin('albums', 'albums.id', '=', 'album_photos.album_id')
          ->get(array('albums.album_name', 'albums.id', 'albums.user_id', 'album_photos.album_id', 'album_photos.photo_id')))
            ->with('user', Photo::find($id)->author()->get())
            ->with('comments', PhotoComment::where('photo_id','=', $id)->orderBy('id', 'desc')->get());

            // ->with('album_photos', Album::find($id)->album_photo()->get());
 }

    public function getNew() {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }

      return View::make('photo.new');
  }

    public function postCreate() {
        if (Auth::guest())
        {
          return Redirect::route('login');
        }

          $input = Input::all();
          $rules = array(
             'file' => 'max:10000'
        );
        $validation = Validator::make($input, $rules);


      if ($validation->fails()) {
         return Response::make($validation->errors->first(), 400);
      }
    else {

  //set the name of the file
    $fname = Input::file('file.name');
       $file = Input::file('file');
    $connectionString = "DefaultEndpointsProtocol=https;
      AccountName=familjenssida;
      AccountKey=oWdckF2RStEJm4fXn3iU6r3e6Cr1bSs9Ep/cZqqKXzsfwkB7Y9fNNiNph6lCoc8zl3gMyy0vefctiyiOybIY9w==";
      $filename = basename($fname);

          // Create blob REST proxy.
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);


        $content = fopen($filename, 'r', 1);



        try {
        //Upload blob
        $upload_success = $blobRestProxy->createBlockBlob("pictures01", $filename, $content);


       }
        catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
      }

    if ($upload_success) {


      Photo::create(array(
          'photo_name'=>$filename,
          'photo_description'=>'Lägg till egen beskrivning',
          'url'=> $filename,
          'user_id' => Auth::user()->id,

        ));
       return Response::json('success', 200);



      } else {
              return Response::json('error', 400);
          }
     }
   }



    public function getEdit($id) {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }
     $photo_id = Photo::find($id);
      $current_user = Photo::where('user_id', '=', Auth::user()->id)->only('user_id');

   if($current_user != $photo_id->user_id){
        return Redirect::route('photo', $id)
        ->with('flash_error', 'Du kan inte redigera ett foto om du inte är ägaren till det!');
    }

      return View::make('photo.edit')
        ->with('photo', Photo::find($id));
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
    'description'=>'required|min:10',
      'photo' => 'image|max:1000|mimes:jpg,png'
        );
        $validation = Validator::make($input, $rules);

      if ($validation->fails()) {
        return Redirect::route('edit_photo', $id)->withErrors($validation);
      } else {

        $photo = Photo::find(Input::get('id'));
        $filename = Input::file('photo.name');

        if($filename == false){
         Photo::update($id, array(
            'photo_name'=>Input::get('name'),
            'photo_description'=>Input::get('description'),
    ));
          return Redirect::route('photo', $id)
            ->with('flash_notice', 'Bilden uppdaterad');
        }
        else{

      //set the name of the file
      $filename = Input::file('photo.name');
      $directory = path('public').Auth::user()->username.'/photos/big/';


      //replaces all non-legal chars with "_" in filename
      $replace="_";
      $pattern="/([[:alnum:]_\.-]*)/";
      $filename=str_replace(str_split(preg_replace($pattern,$replace,$filename)),$replace,$filename);


      $upload_success = Input::upload('photo', $directory, $filename);


        $thumb = Resizer::open($upload_success)
  ->resize(80 , 80 , 'auto' )
  ->save('public/'.Auth::user()->username.'/photos/small/'.'thumb_'.$filename , 100 );

    $medium = Resizer::open($upload_success)
  ->resize(500 , 500 , 'auto' )
  ->save('public/'.Auth::user()->username.'/photos/medium/'.'medium_'.$filename , 100 );

      if ($upload_success && $thumb && $medium ) {


        $bigFile = path('public').Auth::user()->username.'/photos/big/'.$photo->url;
        $medFile = path('public').Auth::user()->username.'/photos/medium/'.'medium_'.$photo->url;
        $thumb = path('public').Auth::user()->username.'/photos/small/'.'thumb_'.$photo->url;

        if ($photo->url != $filename){
          $bigDel =  File::delete($bigFile);
          $medDel = File::delete($medFile);
          $thumbDel = File::delete($thumb);
        }


          Photo::update($id, array(
            'photo_name'=>Input::get('name'),
            'photo_description'=>Input::get('description'),
             'url'=> $filename

          ));
          return Redirect::route('photo', $id)
            ->with('flash_notice', 'Bilden uppdaterad');
        }
      }
    }
  }

      public function deleteDestroy() {
          if (Auth::guest())
    {
          return Redirect::route('login');

    }

     $connectionString = "DefaultEndpointsProtocol=https;
      AccountName=familjenssida;
      AccountKey=oWdckF2RStEJm4fXn3iU6r3e6Cr1bSs9Ep/cZqqKXzsfwkB7Y9fNNiNph6lCoc8zl3gMyy0vefctiyiOybIY9w==";
      $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
         $photo = Photo::find(Input::get('id'));

   try {
    if(Photo::find(Input::get('id'))->delete()){
      $blobRestProxy->deleteBlob("pictures01", Input::get('url'));
        return Redirect::route('photos')
          ->with('flash_notice', 'Bilden togs bort');
      }
      else{
          return Redirect::route('photo', Input::get('id'))
            ->with('flash_error', 'Bilden kunde inte tas bort');
        }
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }



        // $bigFile = path('public').Auth::user()->username.'/photos/big/'.$photo->url;
        // $medFile = path('public').Auth::user()->username.'/photos/medium/'.'medium_'.$photo->url;
        // $thumb = path('public').Auth::user()->username.'/photos/small/'.'thumb_'.$photo->url;
        // File::delete($bigFile);
        // File::delete($medFile);
        // File::delete($thumb);




    }

     public function postCreateComment() {

      if (Auth::guest())
    {
          return Redirect::route('login');

    }

    $validation = PhotoComment::validate(Input::all());

    if ($validation->fails()) {
        return Redirect::route('photo', Input::get('photo_id'))->withErrors($validation)->withInput();
    } else {
      PhotoComment::create(array(
        'photo_id'=>Input::get('photo_id'),
        'user_id' => Auth::user()->id,
        'content' => Input::get('content')
      ));

         return Redirect::route('photo', Input::get('photo_id'))->with('flash_notice', 'Kommenterade foto!');
    }
  }

     public function deleteRemoveComment() {
        if (Auth::guest())
    {
          return Redirect::route('login');

    }
          PhotoComment::find(Input::get('id'))->delete();

      return Redirect::route('photo', Input::get('photo_id'))
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
      return Redirect::route('photo', Input::get('photo_id'))->withErrors($validation);
    } else {
      PhotoComment::update(Input::get('id'), array(
         'content' => Input::get('edited')

      ));
            return Redirect::route('photo', Input::get('photo_id'))
        ->with('flash_notice', 'Kommentar redigerad!');
    }
  }


    }

