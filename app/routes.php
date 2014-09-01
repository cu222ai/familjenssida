<?php



/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|   Route::get('hello', function()
|   {
|     return 'Hello World!';
|   });
|
| You can even respond to more than one URI:
|
|   Route::post(array('hello', 'world'), function()
|   {
|     return 'Hello World!';
|   });
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|   Route::put('hello/(:any)', function($name)
|   {
|     return "Welcome, $name.";
|   });
|
*/


// Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
// {

    /* User Routes */
        //Login
    Route::get('login', array('before' => 'guest', 'as' => 'login', 'uses'=>'UserController@getIndex'));
    Route::post('login', array('as' => 'login', 'uses'=>'UserController@getIndex'));

      //Register
    Route::get('register', array('before' => 'guest', 'as'=>'register', 'uses'=>'UserController@getRegister'));
    Route::post('register', array( 'uses'=>'UserController@getRegister'));

    Route::get('logout', array('before' => 'auth', 'as' => 'logout', function () {
            Auth::logout();

        return Redirect::route('login')
            ->with('flash_notice', 'Du är utloggad.');
    }));

    Route::get('profile', array('before' => 'auth', 'as' => 'profile', function () {
        if (Auth::guest()){
                return Redirect::route('login');
        }
        return View::make('user/profile');
    }));
    Route::get('upload_avatar', array('as'=>'avatar', 'uses'=>'UserController@avatar'));
    Route::post('avatar', array( 'uses'=>'UserController@avatar'));
    Route::get('user/edit', array('as'=>'edit_user', 'uses'=>'UserController@edit'));
    Route::put('user/update', array('before'=>'csrf', 'uses'=>'UserController@update'));
    Route::get('user/edit_password', array('as'=>'edit_password', 'uses'=>'UserController@edit_password'));
    Route::put('user/update_password', array('as' => 'update_password', 'before'=>'csrf', 'uses'=>'UserController@update_password'));
    Route::get('user/friends', array('as' => 'friends', 'uses'=>'UserController@friends'));
    Route::get('user/invite', array('as' => 'invite', 'uses'=>'UserController@invite'));
    Route::post('user/invite', array('as' => 'invite', 'uses'=>'UserController@invite'));
    Route::get('user/forgot_password', array('as' => 'forgot_password', 'uses'=>'UserController@forgot_password'));
    Route::post('user/forgot_password_mail', array('before'=>'csrf', 'uses'=>'UserController@forgot_password_mail'));
    Route::get('user/create_group', array('as' => 'create_group', 'uses'=>'UserController@create_group'));
     Route::post('user/create_group', array('uses'=>'UserController@create_group'));

    Route::get('/', array('as' => 'index', function () {
        return View::make('home/index')
         ->with('albums', Album::orderBy('id', 'desc')->take(10)->get());
     }));

     // Route::get('search=(:any)', array( 'as'=>'search', 'uses'=>'UserController@search'));
    Route::post('search', array( 'uses'=>'UserController@search'));

    Route::get('(:any)/profile', array('as'=>'user', 'uses'=>'UserController@view'));
    Route::get('(:any)/albums', array('as'=>'user_albums', 'uses'=>'UserController@user_albums'));



      /* Album Routes */
     Route::get('albums', array('as'=>'albums', 'uses'=>'AlbumController@index'));
    Route::get('album/(:any)', array('as'=>'album', 'uses'=>'AlbumController@view'));
    Route::get('albums/new', array('as'=>'new_album', 'uses'=>'AlbumController@new'));
    Route::post('albums/create', array('before'=>'csrf', 'uses'=>'AlbumController@create'));
    Route::get('album/(:any)/photo', array('as'=>'new_aphoto', 'uses'=>'AlbumController@new_photo'));
    Route::post('albums/create_photo', array('before'=>'csrf', 'uses'=>'AlbumController@create_photo'));
    Route::get('album/(:any)/new_front_photo', array('as'=>'front_photo', 'before'=>'csrf', 'uses'=>'AlbumController@front_photo'));
    Route::post('albums/create_front_photo', array('before'=>'csrf', 'uses'=>'AlbumController@create_front_photo'));
    Route::get('album/(:any)/edit', array('as'=>'edit_album', 'uses'=>'AlbumController@edit'));
    Route::put('album/update', array('before'=>'csrf', 'uses'=>'AlbumController@update'));
    Route::delete('album/delete', array('before'=>'csrf', 'uses'=>'AlbumController@destroy'));
    Route::delete('album/remove', array('before'=>'csrf', 'uses'=>'AlbumController@remove'));
    Route::post('album/create_comment', array('before'=>'csrf', 'uses'=>'AlbumController@create_comment'));
    Route::delete('album/remove_comment', array('before'=>'csrf', 'uses'=>'AlbumController@remove_comment'));
     Route::put('album/update_comment', array('before'=>'csrf', 'uses'=>'AlbumController@update_comment'));
    Route::post('album/public', array('before'=>'csrf','uses'=>'AlbumController@make_public'));
     Route::post('album/private', array('before'=>'csrf','uses'=>'AlbumController@make_private'));

    /* Photo Routes */
    Route::get('photos', array('as'=>'photos', 'uses'=>'PhotoController@index'));
    Route::get('photo/(:any)', array('as'=>'photo', 'uses'=>'PhotoController@view'));
    Route::get('photos/new', array('as'=>'new_photo', 'uses'=>'PhotoController@new'));
    Route::post('photos/create', array('as'=>'create_photo', 'before'=>'csrf', 'uses'=>'PhotoController@create'));
    Route::get('photo/(:any)/edit', array('as'=>'edit_photo', 'uses'=>'PhotoController@edit'));
    Route::put('photo/update', array('before'=>'csrf', 'uses'=>'PhotoController@update'));
    Route::delete('photo/delete', array('before'=>'csrf', 'uses'=>'PhotoController@destroy'));
    Route::post('photo/create_comment', array('before'=>'csrf', 'uses'=>'PhotoController@create_comment'));
    Route::delete('photo/remove_comment', array('before'=>'csrf', 'uses'=>'PhotoController@remove_comment'));
     Route::put('photo/update_comment', array('before'=>'csrf', 'uses'=>'PhotoController@update_comment'));



  // }


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/



/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|   Route::filter('filter', function()
|   {
|     return 'Filtered!';
|   });
|
| Next, attach the filter to a route:
|
|   Router::register('GET /', array('before' => 'filter', function()
|   {
|     return 'Hello World!';
|   }));
|
*/

Route::filter('before', function()
{
  // Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
  // Do stuff after every request to your application...
});

// Route::filter('csrf', function()
// {
//   if (Request::forged()) return Response::error('500');
// });

