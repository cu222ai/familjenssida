@extends('layouts.default')

@section('content')
  <h1>Lägg till en eller flera bilder!</h1>

@include('errors')




<form action="{{  URL::route('create_photo') }}" class="dropzone" id="my-awesome-dropzone"></form>




@stop
