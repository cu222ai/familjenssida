@extends('layouts.default')
@section('content')
<div class="row">
<div class="span5">
  <h2>Profil för {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h2>
   <h4> <p>Användarnamn: {{ Auth::user()->username }}</p>
  <p>Email:  {{Auth::user()->email }}</p>

  @if (Auth::user()->avatar != null)
  <p>Din avatar:</p>
  <ul class="media-grid">
 <img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{ Auth::user()->avatar }}" alt="{{ Auth::user()->avatar}}">
</ul>

<p>  {{ HTML::linkRoute('avatar', 'Byt avatar') }} </p>
 @else

<p>  {{ HTML::linkRoute('avatar', 'Ladda upp en avatar') }} </p>
 @endif
 <br />
   <p>  {{ HTML::linkRoute('edit_user', 'Ändra användarinfo') }} </p>
<p>  {{ HTML::linkRoute('edit_password', 'Byt lösenord') }} </p></h4>


  </div>
</div>
@stop
