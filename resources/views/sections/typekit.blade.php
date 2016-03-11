@if( ($code = \Config::get('site.typekit')) )
	<script src="//use.typekit.net/{{ $code }}.js"></script>
	<script>try{Typekit.load();}catch(e){}</script>
@endif
