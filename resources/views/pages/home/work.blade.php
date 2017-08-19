@if($work)

    <div class="work">

        @foreach($work as $item)

            <div class="work__item" style="background-image: url({{ $item->getHero() }})">

                <div class="site__medium  work__item--wrap">

                    <div class="work__meta">

                        <p class="work__meta--date">
                            <i class="fa fa-clock-o"></i>
                            <time pubdate="{{ $item->getDateForMeta() }}" itemprop="datePublished" datetime="{{ $item->getDateForMeta() }}" content="{{ $item->getDateForMeta() }}">{{ $item->getDateForHuman() }}</time>
                        </p>
                        
                        <h2 class="work__meta--title">
                            <a href="#" title="Find out more about {{ $item->getTitle() }}">{{ $item->getTitle() }}</a>
                        </h2>

                        <p class="work__meta--intro">{{ $item->getIntro() }}</p>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endif
