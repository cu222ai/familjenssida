<div class="row">

  <div class="nine columns">

    @if($errors->messages)

    <div class="alert-box alert">
      @foreach($errors->messages as $e)
        <li> {{ $e[0] }} </li>
      @endforeach
      <a href="" class="close">&times;</a>
    </div>
    @endif
    <?php //<--How I wish I could remove this
    $error = Session::get('error'); //this is pass through: with('key', 'value') on form redirect
    //and this--> ?>
    @if(!empty($error))
    <div class="alert-box alert">
      <li>{{ $error }}</li>
    </div>
    @endif
  </div>

</div>
