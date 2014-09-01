@extends('layouts.default')

@section('content')
<div class="row">
<div class="span8">

  @include('errors')




{{ Form::open(array('url' => 'login')) }}

    <!-- username field -->
    <p>
        {{ Form::label('email', 'E-post') }}<br/>
        {{ Form::text('email', Input::old('email')) }}
    </p>

    <!-- password field -->
    <p>
        {{ Form::label('password', 'Lösenord') }}<br/>
        {{ Form::password('password') }}
    </p>

<p>



  {{ HTML::linkRoute('forgot_password', 'Glömt lösenord?') }}
</p>
<p>
{{ Form::checkbox('remember', 'true') }}
 Kom ihåg mig!

</p>

    <!-- submit button -->
    <p>{{ Form::submit('Logga in') }}</p>

    {{ Form::close() }}

</div>
</div>



@stop
