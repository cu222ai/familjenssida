@extends('layouts.default')

@section('content')
<div class="row">
  <div class="span8">
  <h3>Dina album:</h3>



  @foreach($albums as $album)
  @if ($album-> user_id == Auth::user()->id)
  <div class="span3">
<div class="well">
    <h4>{{ HTML::linkRoute('album', $album->album_name, array($album->id)) }}</h4>
    <img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{ $album->photo_url }}" alt="{{ $album->photo_url }}">
    </div>
    </div>
  @endif
@empty
<span>Du har inga album uppladdade!</span>

  @endforeach

</div>
</div>
 <h4> <p>{{ HTML::linkRoute('new_album', 'Skapa ett nytt album') }}</p></h4>


<div class="row">
  <div class="span13">
 <h3>Dina vänners album:</h3>
 <ul>


  @foreach($friend_albums as $f)
@if($f->public == 1)
<div class="span2">
<div class="well">

{{ HTML::linkRoute('album', $f->album_name, array($f->id)) }}
<img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{ $f->photo_url }}" alt="{{ $f->photo_url }}">
<p>Uppladdad av: <a href="{{ URL::to('/') }}/{{ $f->username }}/profile">{{$f->firstname}} {{$f->lastname}}</a></p>
    </div>
 </div>


@endif
    @empty
<span>Dina vänner har inte laddat upp några album!</span>

  @endforeach
  </ul>

</div>
  </div>
@stop
