<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Familjens Sida</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <LINK REL="SHORTCUT ICON" HREF="images/familj.ico" type="image/x-icon">
<!-- Byta ut statiska länkar mot Asset:: när bugg är fixad !-->
    <link rel="stylesheet" type="text/css" media="all" href="{{ URL::to('/') }}/bundles/bootstrapper/public/css/bootstrap.min.css">
‌<link rel="stylesheet" type="text/css" media="all" href="http://familjenssida.azurewebsites.net/css/basic.css">
<link rel="stylesheet" type="text/css" media="all" href="http://familjenssida.azurewebsites.net/css/dropzone.css">
<link rel="stylesheet" type="text/css" media="all" href="{{ URL::to('/') }}/bundles/bootstrapper/public/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="http://familjenssida.azurewebsites.net/css/bootstrap-image-gallery.min.css">
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" type="text/css" href="http://familjenssida.azurewebsites.net/css/alertify.core.css">
<link rel="stylesheet" type="text/css" href="http://familjenssida.azurewebsites.net/css/alertify.default.css">
‌
  <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

        <script src="{{ URL::to('/') }}/bundles/bootstrapper/public/js/jquery-1.9.1.min.js"></script>


 <script type="text/javascript" src="http://familjenssida.azurewebsites.net/js/vendor/chosen.jquery.js"></script>
<script src="http://familjenssida.azurewebsites.net/js/vendor/dropzone.js"></script>
<script src="{{ URL::to('/') }}/bundles/bootstrapper/public/js/bootstrap.min.js"></script>
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="http://familjenssida.azurewebsites.net/js/bootstrap-image-gallery.min.js"></script>


</head>
<body>
     <div class="navbar navbar-fixed-top">

      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{{ URL::to('/') }}">FamiljensSida</a>

    <div class="btn-group pull-right">


            @if ( Auth::guest() )
              <a class="btn" href="{{ URL::to('login')}}">
                <i class="icon-user"></i> Logga in
              </a>
               <a class="btn" href="{{ URL::to('register')}}">
                 Bli medlem
              </a>
     @endif

   </div>
          <div class="nav-collapse">
            <ul class="nav">
          <li>{{ URL::to('/', 'Hem' ) }}</li>
</li>
               @if(Auth::check())
<li>{{ URL::to('albums', 'Album' ) }}</l>
<li>{{ URL::to('photos', 'Dina foton' ) }}</l>
<li>{{ URL::to('photos/new', 'Ladda upp bilder' ) }}</li>
<li>{{ URL::to('user/friends', 'Vänner' ) }}</li>


   </div>
     <div class="btn-group pull-right">
       {{ Form::open(array(‘url’ => ‘search’, 'class' => 'navbar-search pull-left'))}}

‌
 {{ Form::text('search', Input::old('search'), array('class' => 'search-query span2', 'placeholder' => 'sök användare..')) }}
‌
{{ Form::close() }}
      <img class="img-rounded" height="30px" width="30px" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ Auth::user()->avatar }}}" alt="{{{ Auth::user()->avatar }}}">
      <div class="btn-group">
‌
<a href="{{ URL::to('profile')}}">{{Auth::user()->username}}</a>
‌
<a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown">{{Auth::user()->firstname}}
<span class="caret"></span>
</a>
‌<ul class="dropdown-menu">
‌<li>
{{ URL::to('profile', 'Profil') }}
</li>
‌<li>
{{ URL::to('logout', 'Logga ut') }}
</li>
</ul></div>

@endif

            </ul>
          </div><!--/.nav-collapse -->

      </div>
    </div>
  </div>

    <div class="container">


    @if(Session::has('flash_notice'))
            <div class="alert alert-success">{{ Session::get('flash_notice') }}</div>
        @endif
        @if (Session::has('flash_error'))
        <div class="alert alert-error">{{ Session::get('flash_error') }}</div>
    @endif

           @yield('content')

          @yield('pagination')
    <!--/container-->



      <footer id="footer">
<p class="pull-right">
<a href="#top">till toppen</a>
</p>
          <p class="muted credit"><a href="mailto:c.ulf@live.se?Subject=Mail%20från%20Familjens%20Sida" target="_top">Christian Ulf&copy 2013</a> | <a href="http://familjenssida.azurewebsites.net" target="blank">FamiljensSida.se</a></p>
        </footer>


  </body>
</html>
