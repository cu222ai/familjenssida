@extends('layouts.default')

@section('content')

  <h1>Redigerar {{ e($album->album_name) }}</h1>

   @include('errors')

  {{ Form::open(array('url' => 'album/update' )) }}


  <p>
    {{ Form::label('name', 'Name:') }}<br />
    {{ Form::text('name', $album->album_name) }}
  </p>

  <p>
    {{ Form::label('description', 'Biography:') }}<br />
    {{ Form::textarea('description', $album->album_description) }}
  </p>

  {{ Form::hidden('id', $album->id) }}

  <p>{{ Form::submit('Update Album') }}</p>

  {{ Form::close() }}
@stop
