@extends('layouts.default')
@section('content')
<div class="row">
<div class="span4">

<h3>Sökresultat:</h3>

 @foreach( $users as $user)
    @if($user->last_login != NULL && $user->id != Auth::user()->id)
 <h4><p><a href="{{ URL::base() }}/{{ $user->username }}/profile"><img class="avatar" src="https://familjenssida.blob.core.windows.net/pictures01/{{{$user->avatar}}}" alt="{{{$user->avatar}}}"> {{ $user->firstname }} {{ $user->lastname }} </a>  </p></h4>
    @endif
@empty
<h4>Inga användare hittades</h4>
@endforeach

</div></div>
<br />
@stop
