@extends('layouts.default')

@section('content')
<div class="row">
<div class="span10">
  <h1>Byt lösenord</h1>

   @include('errors')

   {{ Form::open(array('url' => 'user/update_password' )) }}



   <p>
        {{ Form::label('password', 'Nytt lösenord') }}<br/>
        {{ Form::password('password') }}
    </p>
    <p>
        {{ Form::label('password_confirmation', 'Lösenord(igen)') }}<br/>
        {{ Form::password('password_confirmation') }}
    </p>

    <p>
        {{ Form::label('old_password', 'Bekräfta med nuvarande lösenord') }}<br/>
        {{ Form::password('old_password') }}
    </p>

      {{ Form::hidden('id', $user->id) }}

    <!-- submit button -->
    <p>{{ Form::submit('Spara lösenord!') }}</p>

    {{ Form::close() }}




</div>
</div>
@stop
