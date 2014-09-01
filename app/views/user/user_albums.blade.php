@extends('layouts.default')

{{-- Content --}}
@section('content')
@include('errors')

<section id="user_albums">
  <div class="row">


 @foreach ($userList as $user)
  @foreach ($albums as $album)
  @if ($user->id == $album->user_id)
  @if($album->public == 1)

  <div class="span3">
  <div class="well">
    <img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{ $album->photo_url }}" alt="{{ $album->photo_url }}">
   <h4> {{ HTML::linkRoute('album', $album->album_name, array($album->id)) }}</h4>
   <p>Skapat: {{$album->updated_at }}</p>
 </div>
</div>

  @endif

  @endif




    @empty
<span>Användaren har inga album uppladdade!</span>

  @endforeach
@endforeach

</div>
</section>
@stop
