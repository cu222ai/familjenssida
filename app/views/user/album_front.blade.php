@extends('layouts.default')

@section('content')
  <h3>Lägg till framsidebild till {{$album->album_name}}  </h3>

 @include('errors')

     {{ Form::open(array('url' => 'albums/create_front_photo')) }}

  <p>
@if(!empty($album_photos))

<!-- {{ Form::select('photo_id', $photo_options, null, array('multiple' => 'multiple')) }} -->
 <div class="span3">
<div class="well">

     <a href="javascript:{}" onclick="document.getElementById('albums/create_front_photo').submit(); return false;">submit</a><img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{ $album->photo_url }}" alt="{{ $album->photo_url }}"></a>
    </div>
    </div>

{{ Form::hidden('photo_id', $album_photos->photo_id) }}
  </p>





  {{ Form::close() }}
  @else
  <p> Det finns inga foton i albumet!</p>
  @endif
@stop
