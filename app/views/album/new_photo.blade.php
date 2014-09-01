@extends('layouts.default')

@section('content')
<div class="row">
  <div class="span8">
  <h3>Lägg till foto till albumet {{$album->album_name}}</h3>

 @include('errors')

  {{ Form::open(array('url' => 'albums/create_photo' )) }}

  {{ Form::token() }}
  <p>
@if(!empty($photo_options))

<!-- {{ Form::select('photo_id', $photo_options, null, array('multiple' => 'multiple')) }} -->
{{ Form::select('photo_id', $photo_options) }}


{{ Form::hidden('album_id', $album->id) }}
  </p>



  @foreach ($photos as $photo)
  @if(Auth::user()->username == $photo->author->username)
   <div class="span2">
  <div class="well">
  {{$photo->photo_name}}

<img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $photo->url }}}" alt="https://familjenssida.blob.core.windows.net/pictures01/{{{ $photo->url }}}">
</div>
</div>

@endif
  @endforeach
<div class="span8">
  <div class="row">



  <p>{{ Form::submit('Lägg till') }}</p>
</div>
</div>

  {{ Form::close() }}
  @else
  <p> Du har inga foton att ladda upp!</p>
  @endif
  </div>
  </div>
@stop
