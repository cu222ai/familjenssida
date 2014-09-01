@extends('layouts.default')

@section('content')
  <h2>Ladda upp en avatar:</h2>

@include('errors')


    {{ Form::open_for_files(array('url' => 'avatar' )) }}
    <p>
  {{ Form::label('file', 'Ladda upp avatar:') }}<br />
  {{ Form::file('file') }}<br />
    {{ Form::hidden('id', Auth::user()->id) }}<br />
<p>{{ Form::submit('Upload') }}</p>
{{ Form::close() }}

@if (Auth::user()->url != null)
  <p>Din nuvarande avatar:</p>
 <img class="menuavatar" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->avatar}}">
 @endif

@stop
