<div class="article__content--advert">

    @if (true === env('GOOGLE_ADS_ENABLED', false))

        <!-- Advert Code Here  -->

    @else

        <?php
        /**
         * We need the below to show a sample advert within development
         * so we know where the adverts will actually show!
         */
        ?>
        <img src="{{ asset('assets/img/sample-advert-728x90.png') }}" />

    @endif

</div>
