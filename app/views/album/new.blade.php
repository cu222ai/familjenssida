@extends('layouts.default')

@section('content')
  <h1>Lägg till nytt album</h1>

 @include('errors')

  {{ Form::open(array('url' => 'albums/create' )) }}

  <p>
    {{ Form::label('album_name', 'Namn:') }}<br />
    {{ Form::text('album_name', Input::old('album_name')) }}
  </p>

  <p>
    {{ Form::label('album_description', 'Beskrivning:') }}<br />
    {{ Form::textarea('album_description', Input::old('album_description')) }}
  </p>

  <p>{{ Form::submit('Lägg till') }}</p>

  {{ Form::close() }}
@stop
