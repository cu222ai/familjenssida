@extends('layouts.default')

@section('content')
  <h1>Redigerar {{ e($photo->photo_name) }}</h1>

 @include('errors')

{{ Form::open_for_files(array('url' => 'photo/update'))}}

  <p>
    {{ Form::label('name', 'Titel:') }}<br />
    {{ Form::text('name', $photo->photo_name) }}
  </p>

  <p>
    {{ Form::label('description', 'Beskrivning:') }}<br />
    {{ Form::textarea('description', $photo->photo_description) }}
  </p>
<p>Nuvarande bild:</p>
<img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $photo->url }}}" alt="">
<br />



  {{ Form::hidden('id', $photo->id) }}
<br />
</br>
  <p>{{ Form::submit('Spara') }}</p>

  {{ Form::close() }}
@stop
