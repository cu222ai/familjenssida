@extends('layouts.default')

{{-- Content --}}
@section('content')
@include('errors')
<section id="photos">
  <div class="row">
  <div class="span13">
<h3> Dina foton </h3>


<div id="links">
@foreach ($u_photos as $u_photo)



    <div class="span2">
  <div class="well">


 {{ HTML::linkRoute('photo', 'Gå till vy för bild', array($u_photo->id)) }} |
<a href="https://familjenssida.blob.core.windows.net/pictures01/{{{ $u_photo->url }}}" title="{{{ $u_photo->photo_name }}}" data-gallery=""> <img src="https://familjenssida.blob.core.windows.net/pictures01/{{{ $u_photo->url }}}"></a>


</div>
</div>
@empty
<p> Du har inga foton uppladdade</p>
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
</div>

</section>

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
