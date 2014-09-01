@extends('layouts.default')

@section('content')
<div class="row">
<div class="span10">
  <h1>Redigera användarinformation</h1>

   @include('errors')

  {{ Form::open(array'url' => 'user/update' )) }}



     <p>
        {{ Form::label('firstname', 'Förnamn') }}<br/>
        {{ Form::text('firstname', $user->firstname) }}
    </p>

    <p>
        {{ Form::label('lastname', 'Efternamn') }}<br/>
        {{ Form::text('lastname', $user->lastname) }}
    </p>

    <p>
        {{ Form::label('email', 'E-post') }}<br/>
        {{ Form::text('email', $user->email) }}
    </p>


    <p>
        {{ Form::label('password', 'Bekräfta med lösenord') }}<br/>
        {{ Form::password('password') }}
    </p>

      {{ Form::hidden('id', $user->id) }}

    <!-- submit button -->
    <p>{{ Form::submit('Spara information!') }}</p>

    {{ Form::close() }}




</div>
</div>
@stop
