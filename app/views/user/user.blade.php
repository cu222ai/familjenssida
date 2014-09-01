@extends('layouts.default')
@section('content')
<section id="user">
<div class="row">
<div class="span3">



@foreach ($userList as $user)
<h2>{{ $user->username }}s profil</h2>



  <div class="subnav">
‌<ul class="nav nav-pills">
‌<li class="active">
<a href="#typography">{{ $user->username }}</a>
</li>
‌<li class="">

  @if (isset($user_albums))
{{ HTML::linkRoute('user_albums', 'Album', array($user->username)) }}</a>
  @endif

</li>
‌
‌</ul>
‌
<h3>{{ $user->firstname }} {{ $user->lastname }}</h3>
<h4>{{ $user->email }}</h4>
<br />
<h4>Profilbild:</h4>
<img class="thumbnail" width="40px" height="40px" src="https://familjenssida.blob.core.windows.net/pictures01/{{ $user->avatar }}" alt="{{ $user->avatar}}">
</div>

  @endforeach
</div>
</div>
</section>

@stop
