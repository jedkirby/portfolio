<div class="wistia  wistia_responsive_padding">
    <div class="wistia--wrapper  wistia_responsive_wrapper">
        <div class="wistia--embed  wistia_embed wistia_async_{{ $videoId }} videoFoam=true">&nbsp;</div>
    </div>
</div>

@section('footer')

    @parent

    <script src="https://fast.wistia.com/embed/medias/{{ $videoId }}.jsonp" async></script>
    <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>

@stop
