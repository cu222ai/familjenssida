          <?php

          use WindowsAzure\Common\ServicesBuilder;
          use WindowsAzure\Blob\Models\CreateContainerOptions;
          use WindowsAzure\Blob\Models\PublicAccessType;
          use WindowsAzure\Common\ServiceException;

          class UserController extends BaseController {

            public function getIndex(){
                if (Auth::check())
               {
                      return Redirect::route('profile');

                }
                  return View::make('user.login')
                  ->with('users', User::orderBy('id')->get());
              }

          public function getView($username){
                if (Auth::guest())
                {
                      return Redirect::route('login');

                }
              // $userAuth = User::where('id', '=', Auth::user()->id);
              $userList = User::where('username','=', $username)->get();
              $user_id = User::where('username','=', $username)->only('id');


              if ($user_id == Auth::user()->id){
                     return Redirect::route('profile');
              }

              return View::make('user.user')
                  -> with('username', $username)
                  -> with('userList', $userList)
                  ->with('user_albums', Album::where('user_id','=', Auth::user()->id)->orderBy('id', 'desc')->get())
                  ->with('albums', Album::leftJoin('users', 'users.id', '=', 'albums.user_id')
                  ->get(array('users.id', 'albums.album_name', 'albums.updated_at', 'albums.id', 'albums.user_id', 'albums.photo_url', 'albums.public')));

            }

         public function getRegister() {

              if (Auth::check())
            {
                  return Redirect::route('profile');

            }
            return View::make('user.register');

        }

         public function getInvite() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }
            return View::make('user.invite');

        }

           public function postInvite() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }

            // via plugin SendGrid sends email invitation with randomly generated password
          $random = substr(md5(microtime()),rand(0,26),10);;


            $sendgrid = new SendGrid(); // For Laravel bundle users
            $mail = new SendGrid\Mail();
        $mail->addTo(Input::get('email'))->
       setFrom('info@pz-net.com')->
       setSubject('Inbjudan till Familjenssida')->
       setText(Auth::user()->firstname . ' ' . Auth::user()->lastname . ' har bjudit in dig till Familjenssida, en tjänst för att dela med sig av sina foton till sina nära och kära.<br /><img src="http://familjenssida.azurewebsites.net/images/familj.jpg"><br />
      Ett konto har skapats till dig; <br />E-postadress: <strong><a href="mailto:c.ulf@live.se" target="_top">' .Input::get('email'). '</a></strong><br />Ditt temporära lösenord: <strong>'. $random . '</strong><br /><br /><h3>Logga in på: <a href="http://familjenssida.azurewebsites.net/login">Familjenssida</a></h3>')->
       setHtml(Auth::user()->firstname . ' ' . Auth::user()->lastname . ' har bjudit in dig till Familjenssida, en tjänst för att dela med sig av sina foton till sina nära och kära.<br /><img src="http://familjenssida.azurewebsites.net/images/familj.jpg"><br />
      Ett konto har skapats till dig; <br />E-postadress: <strong><a href="mailto:c.ulf@live.se" target="_top">' .Input::get('email'). '</a></strong><br />Ditt temporära lösenord: <strong>'. $random . '</strong><br /><br /><h3>Logga in på: <a href="http://familjenssida.azurewebsites.net/login">Familjenssida</a></h3>');

    $input = Input::all();
            $rules = array(
                 'firstname'=>'required|min:3',
                 'lastname'=>'required|min:3',
                 'email' => 'required|email'
        );

            $validation = Validator::make($input, $rules);
            $user = User::where_email(Input::get('email'))->first();


          if ($validation->fails()) {
              return Redirect::route('invite')->withErrors($validation)->withInput();
            }
          if($user){
               return Redirect::route('invite')
                      ->with('flash_error', 'Den angivna e-posten finns redan i systemet.')
                      ->withErrors($validation)->withInput();
          }
          else {
            $success = $sendgrid->smtp->send($mail);
                     if ($success)
                     {
                            $create = User::create(array(

                               'firstname' => Input::get('firstname'),
                               'lastname' => Input::get('lastname'),
                                'email' => Input::get('email'),
                                'password' => Hash::make($random),
                        ));
                            if($create){
                                Friend::create(array(

                                   'invited_by' => Auth::user()->id,
                                   'user_id' => $create->id,

                            ));

                                return Redirect::route('invite')
                                  ->with('flash_notice', 'Mailet skickat!');
                          }
                     }
          }
      }

        public function getFriends() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }
            return View::make('user.friends')

            ->with('friends', Friend::leftJoin('users', 'users.id', '=', 'friends.user_id')
          ->get(array('users.firstname', 'users.lastname', 'users.username', 'users.avatar',  'friends.user_id', 'friends.invited_by', 'users.last_login')));

        }

         public function getCreateGroup() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }
            return View::make('user.create_group')

           ->with('friends', UserAlbumFriend::where('user_id','=', Auth::user()->id)->where('invited_by','!=', Auth::user()->id)->orderBy('id')->lists('firstname', 'lastname', 'id'));


        }

            public function postCreateGroup() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }


        }

        public function getUserAlbums($username) {

              if (Auth::guest())
            {
                   return Redirect::route('user')
                ->with('flash_notice', 'Du kommer inte åt den här funktionen om du är medlem på sidan!');
            }

            $userList = User::where('username','=', $username)->get();


            return View::make('user.user_albums')
             -> with('userList', $userList)
                  ->with('albums', Album::leftJoin('users', 'users.id', '=', 'albums.user_id')
                  ->get(array('users.id', 'albums.album_name', 'albums.updated_at', 'albums.id', 'albums.user_id', 'albums.photo_url', 'albums.public')));

        }

        public function postSearch() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }

            $search = Input::get( 'search' );
            $take = 20;

        return View::make('user.result')
            ->with('users', User::where('lastname', 'LIKE', '%'.$search.'%')
              ->get());
             }

            public function getSearch($search) {

              return View::make('user.result')
              -> with('search', $search);
            }

            public function getAvatar() {

              if (Auth::guest())
            {
                  return Redirect::route('login');

            }
            return View::make('user.avatar');

        }


        public function postAvatar(){
             if (Auth::guest()){
                  return Redirect::route('login');
          }
          $input = Input::all();
          $rules = array(
            'avatar' => 'max:1000',
          );
          $validation = Validator::make($input, $rules);

         if ($validation->fails()) {
              return Redirect::route('avatar')->withErrors($validation)->withInput();
            } else {

             //set the name of the file
    $fname = Input::file('file.name');
       $file = Input::file('file');
    $connectionString = "DefaultEndpointsProtocol=https;
      AccountName=familjenssida;
      AccountKey=oWdckF2RStEJm4fXn3iU6r3e6Cr1bSs9Ep/cZqqKXzsfwkB7Y9fNNiNph6lCoc8zl3gMyy0vefctiyiOybIY9w==";
      $filename = basename($fname);

          // Create blob REST proxy.
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);


        $content = fopen($avatar, 'r', 1);

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
                     User::Update(Input::get('id'), array(
                     'avatar'=> $filename,
                  ));
                     return Response::json('success', 200)
                         ->with('flash_notice', 'Lyckad uppladdning av avatar!');
      } else {
              return Response::json('error', 400)
              ->with('flash_notice', 'Avataren kunde inte laddas upp på servern.');
          }

        }
  }

        public function postRegister()
        {
            if (Auth::check())
            {
                  return Redirect::route('profile');

            }

        $validation = User::validate(Input::all());

         if ($validation->fails()) {
              return Redirect::route('register')->withErrors($validation)->withInput();
            } else {


            $filename = Input::file('avatar.name');
             if($filename == false){
               User::create(array(
                 'username' => Input::get('username'),
                 'firstname' => Input::get('firstname'),
                 'lastname' => Input::get('lastname'),
                  'email' => Input::get('email'),
                  'avatar'=> NULL,
                  'password' => Hash::make(Input::get('password')),

              ));

                  return Redirect::route('login')
                    ->with('flash_notice', 'Lyckad registrering!');

        }

              $replace="_";
            $pattern="/([[:alnum:]_\.-]*)/";
            $filename=str_replace(str_split(preg_replace($pattern,$replace,$filename)),$replace,$filename);

        //set the name of the file
        $directory = path('public').Input::get('username').'/';

        $upload_success = Input::upload('avatar', $directory, $filename);

        $thumb = Resizer::open($upload_success)
          ->resize(35 , 35 , 'exact' )
          ->save('public/'.Input::get('username').'/thumb_'.$filename , 100 );

          if ($upload_success && $thumb){

             User::create(array(
                 'username' => Input::get('username'),
                 'firstname' => Input::get('firstname'),
                 'lastname' => Input::get('lastname'),
                  'email' => Input::get('email'),
                  'avatar'=> $filename,
                  'password' => Hash::make(Input::get('password'))
              ));

                  return Redirect::route('login')
                    ->with('flash_notice', 'Lyckad registrering!');

        }

        else{
          return Redirect::route('register')->with('flash_error', 'Bilden kunde inte laddas upp på servern.')->withInput();
            }
          }
        }

    public function getEdit() {

        if (Auth::guest())
      {
            return Redirect::route('login');

      }

      return View::make('user.edit')
        ->with('user', Auth::user());
      }

    public function putUpdate() {
        if (Auth::guest())
      {
            return Redirect::route('login');

      }

      $id = Input::get('id');
      $input = Input::all();
      $rules = array(
             'firstname'=>'required|alpha|min:3',
             'lastname'=>'required|alpha|min:3',
             'email' => 'required|unique:users|email'
  );

      $validation = Validator::make($input, $rules);

         if ($validation->fails()) {
              return Redirect::route('edit_user')->withErrors($validation)->withInput();
            } else {

    if (Hash::check(Input::get('password'), Auth::user()->password)) {
        User::update($id, array(
                 'firstname' => Input::get('firstname'),
                 'lastname' => Input::get('lastname'),
                  'email' => Input::get('email')
        ));
        return Redirect::route('profile', $id)
          ->with('flash_notice', 'Användarinfo redigerad!');
      }


      else {
          return Redirect::route('edit_user')->withInput()
          ->with('flash_error', 'Lösenordet du angav är felaktigt.');
        }
      }
  }

   public function getEditPassword() {

        if (Auth::guest())
      {
            return Redirect::route('login');

      }

      return View::make('user.change_password')
        ->with('user', Auth::user());
      }

    public function putUpdatePassword() {
        if (Auth::guest())
      {
            return Redirect::route('login');

      }

        $id = Auth::user()->id;
         $input = Input::all();
      $rules = array(
             'password' => 'required|alpha_dash|confirmed'
  );

      $validation = Validator::make($input, $rules);

   if ($validation->fails()) {
              return Redirect::route('edit_password')->withErrors($validation)->withInput();
            } else {

    if (Hash::check(Input::get('old_password'), Auth::user()->password)) {
        User::update($id, array(
                 'password' => Hash::make(Input::get('password'))
         ));
        return Redirect::route('profile')
          ->with('flash_notice', 'Lösenord ändrat!');
      }


      else {
          return Redirect::route('edit_password')->withInput()
          ->with('flash_error', 'Lösenordet du angav är felaktigt.');
        }
      }
  }

        public function postIndex(){

            if (Auth::check())
            {
                  return Redirect::route('profile');
            }


           $credentials = array(
          'username' => Input::get('email'),
          'password' => Input::get('password'),
          );

     if (Auth::attempt($credentials) && Input::get('remember') == false) {
                             User::update(Auth::user()->id, array(
                 'last_login' => date("Y-m-d H:i:s")
              ));

                          if(Auth::user()->username == NULL)
                          {
                            User::update(Auth::user()->id, array(
                              'username' => Auth::user()->firstname.Auth::user()->lastname.Auth::user()->id
                                 ));
                          }
              return Redirect::route('index')
                  ->with('flash_notice', 'Du har loggat in!');
          }
           else if (Auth::attempt($credentials, true) && Input::get('remember') == true){
                               User::update(Auth::user()->id, array(
                 'last_login' => date("Y-m-d H:i:s")
              ));
                          if(Auth::user()->username == NULL)
                          {
                            User::update(Auth::user()->id, array(
                              'username' => Auth::user()->firstname.Auth::user()->lastname.Auth::user()->id
                            ));
                          }
               return Redirect::route('index')
                            ->with('flash_notice', 'Du har loggat in och blir det automatiskt tills du loggar ut manuellt.');

          }

          // authentication failure! lets go back to the login page
          return Redirect::route('login')
              ->with('flash_error', 'Du angav fel uppgifter.')
              ->withInput();
        }


        public function getForgotPassword() {
            if (Auth::check())
            {
                  return Redirect::route('profile');
            }

            return View::make('user.forgot_password');
      }

       public function postForgotPasswordMail()
      {
            $input = Input::all();
            $rules = array(
                   'email' => 'required|email'
        );

            $validation = Validator::make($input, $rules);

             if ($validation->fails()) {
                  return Redirect::route('forgot_password')
                          ->with('flash_error', 'Fel format på e-post.')
                          ->withInput('only', array('email'));
                        }

              // verify that the account exists

              $user = User::where_email(Input::get('email'))->first();

              if(!$user){
                   return Redirect::route('forgot_password')
                          ->with('flash_error', 'Den angivna e-posten finns inte i systemet.')
                          ->withInput('only', array('email'));
                        } else{

                    $random = substr(md5(microtime()),rand(0,26),10);;

                    $sendgrid = new SendGrid(); // For Laravel bundle users
                    $mail = new SendGrid\Mail();
                                $mail->addTo(Input::get('email'))->
                               setFrom('info@pz-net.com')->
                               setSubject('Återställning av lösenord på Familjenssida')->
                               setText('Du har begärt en återställning av lösenord för Familjenssida.<br />Ditt nya lösenord är: <strong>'. $random . '</strong><br /><br /><h3>Logga in på: <a href="http://familjenssida.azurewebsites.net/login">Familjenssida</a></h3>')->
                               setHtml('Du har begärt en återställning av lösenord för Familjenssida.<br />Ditt nya lösenord är: <strong>'. $random . '</strong><br /><br /><h3>Logga in på: <a href="http://familjenssida.azurewebsites.net/login">Familjenssida</a></h3>');

                         $success = $sendgrid->smtp->send($mail);
                        $user_id = User::where('email','=', Input::get('email'))->only('id');
                           if ($success) {
                                  User::update($user_id, array(
                                     'password' => Hash::make($random),
                              ));

                              return Redirect::route('login')
                                ->with('flash_notice', 'Ett nytt lösenord har skickats till ' . Input::get('email'));
                          }
                  }
               }
        }




