@extends('layouts.default')

@section('content')
<div class="row">


  @include('errors')


    <!-- check for login error flash var -->


<h2>
 Bjud in en vän till familjens sida!</h2>
 <p>Genom att lägga till de nödvändiga fälten skickas ett mail till vännen i fråga med en inbjudan till Familjens Sida från dig!
{{ Form::open(array('url' => 'user/invite'))}}

    <!-- username field -->
   <p>
        {{ Form::label('firstname', 'Förnamn') }}<br/>
        {{ Form::text('firstname', Input::old('firstname')) }}
    </p>

    <p>
        {{ Form::label('lastname', 'Efternamn') }}<br/>
        {{ Form::text('lastname', Input::old('lastname')) }}
    </p>

    <p>
        {{ Form::label('email', 'E-post') }}<br/>
        {{ Form::text('email', Input::old('email')) }}
    </p>




    <!-- submit button -->
    <p>{{ Form::submit('Skicka inbjudan!') }}</p>

    {{ Form::close() }}




</div>
@stop
