@if($work)

    <div class="work">

        @foreach($work as $item)

            <div class="work__item" style="background-image: url({{ $item->getHero() }})">

                <div class="site__medium  work__item--wrap">

                    <div class="work__meta">

                        <p class="work__meta--date">
                            <i class="fa fa-clock-o"></i>
                            <time pubdate="{{ $item->getDate() }}" itemprop="datePublished" datetime="{{ $item->getDate() }}" content="{{ $item->getDate() }}">{{ $item->getDate('F j, Y') }}</time>
                        </p>
                        
                        <h2 class="work__meta--title">
                            <a href="#">{{ $item->getTitle() }}</a>
                        </h2>

                        <p class="work__meta--intro">{{ $item->getIntro() }}</p>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endif
