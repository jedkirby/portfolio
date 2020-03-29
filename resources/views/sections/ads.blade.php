@if (true === env('GOOGLE_ADS_ENABLED', false))

    <script data-ad-client="{{ env('GOOGLE_ADS_ID') }}" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

@endif
