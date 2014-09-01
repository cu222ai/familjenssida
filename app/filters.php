<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
  //
});


App::after(function($request, $response)
{
  //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. Also, a "guest" filter is
| responsible for performing the opposite. Both provide redirects.
|
*/

//checks whether user is logged in already
Route::filter('guest', function()
{
        if (Auth::check())
                return Redirect::route('profile')
                        ->with('flash_notice', 'You are already logged in!');
});
//checks whether user isn't logged in while trying to access index
Route::filter('auth', function()
{
        if (Auth::guest())
                return Redirect::route('login')
                        ->with('flash_error', 'You must be logged in to view this page!');
});


/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
  // if (Session::getToken() != Input::get('csrf_token') &&  Session::getToken() != Input::get('_token'))
  // {
  //   throw new Illuminate\Session\TokenMismatchException;
  // }
});

/*
|--------------------------------------------------------------------------
| Role Permissions
|--------------------------------------------------------------------------
|
| Access filters based on roles.
|
*/
