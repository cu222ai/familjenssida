@extends('layouts.default')

@section('content')

@include('errors')

<div class="row">
  <div class="span8">
<div class="btn-group pull-right">
@if ($album->public == 1)
  <i class="icon-globe"></i> Offentligt album
@else
<i class="icon-lock"></i> Privat album
@endif
</div>
  <h1>{{ e($album->album_name) }}</h1>


 <h3><span class="label label-info">{{ e($album->album_description) }}</span></h3>

</div>
</div>
<br /><br />



  <div class="container">

<div id="links">
      @foreach ($album_photos as $photo)

@if ($album->id == $photo->album_id)





<div class="span2">
  {{ HTML::linkRoute('photo', 'Gå till vy för bild', array($photo->photo_id)) }} |
<a href="https://familjenssida.blob.core.windows.net/pictures01/{{{ $photo->url }}}" title="{{{ $photo->photo_name }}}" data-gallery=""> <img src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $photo->url }}}"></a>
</div>



 @if(Auth::user()->username == $album->author->username)
    {{ Form::open(array('url' => 'album/remove' , 'style'=>'display: inline;')) }}
    {{ Form::hidden('apid', $photo->id) }}
    {{ Form::hidden('album_id', $album->id) }}


 {{ Form::submit('x') }}


    {{ Form::hidden('id', $photo->id) }}
    {{ Form::hidden('url', $photo->url) }}


    {{ Form::close() }}
    <br />

 @endif


@endif
@empty
<p> Det finns inga foton i detta album för närvarande!</p>


@endforeach



</div>
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Förra
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Nästa
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



  <p>Senast uppdaterad:<small>{{ $album->updated_at }}</small></p>
  <p>Skapad uppdaterad:<small>{{ $album->created_at }}</small></p>
  <br />

<p>
            uppladdat av <a href="{{ URL::to'('/')' }}/{{{ $album->author->username }}}/profile">{{{ $album->author->firstname }}} {{{ $album->author->lastname }}}</a></p>
  <span>
          <div class="row">
  <div class="span8">
    @if(Auth::user()->username == $album->author->username)
      {{ HTML::linkRoute('edit_album', 'Redigera', array($album->id)) }} |
       {{ HTML::linkRoute('new_aphoto', 'Lägg till foto', array($album->id)) }} |
            {{ HTML::linkRoute('front_photo', 'Lägg till frontbild', array($album->id)) }} |



       <div class="btn-group">
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
            Rättigheter
            @if($album->public == 1)
<span class="caret"></span>
</a>

           <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
    <li class="active"><a tabindex="-1"><i class="icon-globe"></i> Offentligt</a></li>
  {{ Form::open(array('url' => 'album/private' )) }}
              {{ Form::hidden('id', $album->id) }}
    <li><a tabindex="-1"><i class="icon-lock"></i>  {{ Form::submit('Privat') }}</a></li>  {{ Form::close() }}
    <li><a tabindex="-1" value="friends"><i class="icon-user"></i> Alla vänner</a></li>
    <li class="divider"></li>
    <li><a tabindex="-1" href="{{ URL::route('create_group')}}"><i class="icon-wrench"></i> Skapa grupp</a></li>
    </ul>
  </div>
  @else

<span class="caret"></span>
</a>

           <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
        {{ Form::open(array('url' => 'album/public' )) }}
              {{ Form::hidden('id', $album->id) }}
    <li ><a tabindex="-1"  ><i class="icon-globe"></i> {{ Form::submit('Offentligt') }}</a></li>  {{ Form::close() }}
    <li class="active"><a tabindex="-1" ><i class="icon-lock"></i> Privat</a></li>
    <li><a tabindex="-1" value="friends"><i class="icon-user"></i> Alla vänner</a></li>
    <li class="divider"></li>
    <li><a tabindex="-1" href="{{ URL::route('create_group')}}"><i class="icon-wrench"></i> Skapa grupp</a></li>
    </ul>
  </div>
  @endif
    |
       {{ Form::open(array('url' => 'album/delete', 'style'=>'display: inline;'))}}
      {{ Form::hidden('id', $album->id) }}
 <!-- Button trigger modal -->
<a data-toggle="modal" href="#myModal" >Radera</a>

<!-- Modal -->
<div class="modal hide fade" id="myModal"  tabindex='-1'role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: block; margin: 0px auto; left:0px; top:0px;overflow-y:auto;overflow-x:hidden;">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-body">Är du säker på att du vill ta bort albumet {{ $album->album_name }}?</h4>
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
      {{ Form::close() }}
    @endif
    </span>

</div>
</div>

<div class="row">
  <div class="span8">
<a id="comments"></a>


@if ( ! Auth::check())
Du behöver vara inloggad för att kommentera.

@else


  {{ Form::open(array('url' => 'album/create_comment' )) }}
{{ Form::token() }}
  {{ Form::label('content', 'Kommentera:') }}
    {{ Form::text('content', Input::old('content')) }}

    {{ Form::hidden('album_id', $album->id) }}
    {{ Form::submit('+') }}
     {{ Form::close() }}
   </div>
 </div>
@foreach ($comments as $comment)
<div class="row">
  <div class="span8">
  <div class="well">
 <img class="flexible" width="40px" height="40px" src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $comment->author->avatar }}}"><span class="muted"> {{{ $comment->author->firstname }}} {{{ $comment->author->lastname }}} (<a href="{{ URL::to('/') }}/{{{ $comment->author->username }}}/profile">{{{ $comment->author->username }}}</a>):</span>
 {{Smilies::parse($comment->content)}} <div class="span8 pull-right" style="text-align:right">

@if(Auth::user()->username == $comment->author->username || Auth::user()->username == $album->author->username)
{{ Form::open(array('url' => 'album/update_comment', 'style'=>'display: inline;'))}}
    {{ Form::text('edited', $comment->content) }}
    {{ Form::hidden('id', $comment->id) }}
    {{ Form::hidden('album_id', $album->id) }}
   {{ Form::submit('Redigera') }}
    {{ Form::close() }}
{{ Form::open(array('url' => 'album/remove comment', 'style'=>'display: inline;'))}}
    {{ Form::hidden('id', $comment->id) }}
    {{ Form::hidden('album_id', $album->id) }}
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
@endif

@stop

<script>
document.getElementById('links').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
</script>
