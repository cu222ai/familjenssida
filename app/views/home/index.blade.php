@extends('layouts.default')

@section('content')

<div class="row">
  <div class="span8">
    <img src="images/familj.jpg" alt="hittade ej">
<p><h1>Välkommen till Familjens Sida!</h1></p>

<p>En sida för hela familjen att samla sina bilder och dela med sig av dessa till sina nära och kära.</p>
</div>
</div>

<div class="row">
  <div class="span14">
<h4>Senast uppladdade offentliga album:</h4>


@foreach ($albums as $album)
	@if($album->public == 1)
	<div class="span2">
	‌<div class="well">


	 {{ HTML::linkRoute('album', $album->album_name, array($album->id)) }}
	 <p>Uppladdat av: <a href="{{ URL::to('/') }}/{{ $album->author->username }}/profile">{{$album->author->firstname}} {{$album->author->lastname}}</p><img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $album->photo_url }}}" alt="{{{ $album->photo_url }}}"></a>

	     <!--    <span class="muted">{{{ $album->user_id}}}</span> -->
	</div>
	</div>
	@endif

	@empty
	<span>Det finns inga album i databasen!</span>

@endforeach
</div>
</div>



@stop

