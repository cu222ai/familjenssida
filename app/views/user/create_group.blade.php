@extends('layouts.default')

@section('content')
<div class="row">
  <div class="span8">

  <h3>Skapa ny grupp</h3>

 @include('errors')

  {{ Form::open(array('url' => 'user/create_group')) }}



{{ Form::select('friends', $friends, null, array('multiple' => 'multiple')) }}
 <p>{{ Form::submit('Skapa grupp') }}</p>

  {{ Form::close() }}
  </div>

  </div>

@stop



