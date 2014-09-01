@extends('layouts.default')

@section('content')
<div class="row">


  @include('errors')


    <!-- check for login error flash var -->


<h2>
  Registrera dig här!</h2>
  {{ Form::open(array('url' => 'register','files'=>true)) }}


    <!-- username field -->
    <p>
        {{ Form::label('username', 'Användarnamn') }}<br/>
        {{ Form::text('username', Input::old('username')) }}
    </p>

      <p>
        {{ Form::label('firstname', 'Förnamn') }}<br/>
        {{ Form::text('firstname', Input::old('firstname')) }}
    </p>

    <p>
        {{ Form::label('lastname', 'Efternamn') }}<br/>
        {{ Form::text('lastname', Input::old('lastname')) }}
    </p>

    <p>
        {{ Form::label('email', 'E-post') }}<br/>
        {{ Form::text('email', Input::old('email')) }}
    </p>

    <p>
      {{ Form::label('file', 'Ladda upp avatar:(valfritt)') }}
      {{ Form::file('avatar') }}
  </p>

    <!-- password field -->
    <p>
        {{ Form::label('password', 'Lösenord') }}<br/>
        {{ Form::password('password') }}
    </p>

    <p>
        {{ Form::label('password_confirmation', 'Lösenord(igen)') }}<br/>
        {{ Form::password('password_confirmation') }}
    </p>

    <!-- submit button -->
    <p>{{ Form::submit('Registrera dig!') }}</p>

    {{ Form::close() }}




</div>
@stop
