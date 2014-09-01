@extends('layouts.default')

@section('content')
@include('errors')

<div class="row">
<div class="span8">
 <div class="well">
  <h1>{{ e($photo->photo_name) }}</h1>


  @foreach ($albums as $album)
    @if ($photo->id == $album->photo_id)


<h4>Tillhör album: <a href="{{ URL::base() }}/album/{{$album->id}}">{{ $album->album_name }}</a></h4>
  @endif

  @endforeach
  <ul class="media-grid">
<img class="img-rounded" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $photo->url }}}" alt="{{{ $photo->url }}}">
<br />
  <h3><span class="label label-info">{{ e($photo->photo_description) }}</span></h3>
</ul>


<p>
            uppladdad av <a href="{{ URL::base() }}/{{{ $photo->author->username }}}/profile">{{{ $photo->author->firstname }}} {{{ $photo->author->lastname }}}</a></p>
  <p>Senast uppdaterad:<small>{{ $photo->updated_at }}</small></p>
  <p>Skapad uppdaterad:<small>{{ $photo->created_at }}</small></p>

  <span>

    @if(Auth::user()->username == $photo->author->username)
   {{ HTML::linkRoute('edit_photo', 'Redigera', array($photo->id)) }} |
{{ Form::open(array('url' => 'photo/delete', 'style'=>'display: inline;'))}}
    <!-- Button trigger modal -->
<a data-toggle="modal" href="#myModal" >Radera</a>

<!-- Modal -->
<div class="modal fade" id="myModal"  tabindex='-1'role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: block; margin: 0px auto; left:0px; top:0px;overflow-y:auto;overflow-x:hidden;">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-body">Är du säker på att du vill ta bort bilden {{ $photo->photo_name }}?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
        {{ Form::submit('Ja') }}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    {{ Form::hidden('id', $photo->id) }}
    {{ Form::hidden('url', $photo->url) }}


    {{ Form::close() }}
</span>

@endif
  </div>

<a id="comments"></a>


@if ( ! Auth::check())
Du behöver vara inloggad för att kommentera.

@else


{{ Form::open(array('url' => 'photo/create_comment'))}}
  {{ Form::label('content', 'Kommentera:') }}
    {{ Form::text('content', Input::old('content')) }}

    {{ Form::hidden('photo_id', $photo->id) }}
    {{ Form::submit('+') }}
     {{ Form::close() }}
@foreach ($comments as $comment)
<div class="row">
  <div class="span8">
  <div class="well">
 <img class="img-rounded" width="40px" height="40px" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $comment->author->avatar }}}"><span class="muted"> {{{ $comment->author->firstname }}} {{{ $comment->author->lastname }}} (<a href="{{ URL::base() }}/{{{ $comment->author->username }}}/profile">{{{ $comment->author->username }}}</a>):</span>
 {{Smilies::parse($comment->content)}}<div class="span8 pull-right" style="text-align:right">

@if(Auth::user()->username == $comment->author->username || Auth::user()->username == $photo->author->username)
{{ Form::open(array('url' => 'photo/update_comment', 'style'=>'display: inline;'))}}
    {{ Form::text('edited', $comment->content) }}
    {{ Form::hidden('id', $comment->id) }}
    {{ Form::hidden('photo_id', $photo->id) }}
   {{ Form::submit('Redigera') }}
    {{ Form::close() }}
{{ Form::open(array('url' => 'photo/remove_comment', 'style'=>'display: inline;'))}}
    {{ Form::hidden('id', $comment->id) }}
    {{ Form::hidden('photo_id', $photo->id) }}
   {{ Form::submit('x') }}
    {{ Form::close() }}

  @endif
      </div>
<br />
<small>{{{ $comment->updated_at }}}</small>


</div>

@endforeach




  </div>
       </div>
</div>



 </div>
@endif

@stop
