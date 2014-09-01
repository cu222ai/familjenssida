@extends('layouts.default')

@section('content')


<div class="row">
  <div class="span8">
     @include('errors')

<p><h3>Återställ glömt lösenord</h3></p>

<p>Finns din e-postadress registrerad skickas ett e-post med ett nytt temporärt lösenord till dig.</p>
{{ Form::open(array('url' => 'user/forgot_password_mail'))}}
   {{ Form::text('email') }}
 <p>{{ Form::submit('Skicka nytt lösenord') }}</p>
   {{ Form::close() }}



</div>
  </div>
@stop

