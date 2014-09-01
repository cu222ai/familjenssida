@extends('layouts.default')
@section('content')
<div class="row">
<div class="span12">

<h3>Dina vänner:</h3>

 @foreach( $friends as $friend)

  @if ($friend->invited_by == Auth::user()->id)

    @if ($friend->last_login != NULL)
    <h5><p><a href="{{ URL::base() }}/{{$friend->username }}/profile"><img class="img-rounded" width="40px" height="40px" src="https://familjenssida.blob.core.windows.net/pictures01/{{{$friend->avatar }}}" alt="{{{ $friend->avatar }}}"> {{$friend->firstname }} {{$friend->lastname }}</a>
    <button class="btn btn-small btn-success disabled" type="button"><i class="icon-ok-circle"></i></button></p></h5>
    @else
    <h5><p><img class="img-rounded" width="40px" height="40px" src="https://familjenssida.blob.core.windows.net/pictures01/{{{$friend->avatar }}}" alt="{{{ $friend->avatar }}}"> {{$friend->firstname }} {{$friend->lastname }}
    <button class="btn btn-small btn-warning disabled" type="button"><i class="icon-pause"></i> Ännu ej registrerad</button></p></h5>
    @endif
  @endif
@empty
<h4>Inga vänner hittades</h4>
@endforeach
<br />
<h3>{{ HTML::nav_link('user/invite', 'Bjud in fler vänner!' ) }}</h3>
</div></div>
<br />
@stop
