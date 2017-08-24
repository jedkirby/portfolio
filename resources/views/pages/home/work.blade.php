@if($work)

    <div class="work">

        @foreach($work as $item)

            <div class="work__item" style="background-image: url({{ $item->getHero() }})">

                <div class="work__overlay"></div>

                <div class="site__medium  work__item--wrap">

                    <div class="work__meta">
                        
                        <h2 class="work__meta--title">
                            <a href="#" title="Open the {{ $item->getTitle() }} case study">{{ $item->getTitle() }}</a>
                        </h2>

                        <p class="work__meta--intro">{{ $item->getIntro() }}</p>

                        <a href="#" class="work__meta--link" title="Open the {{ $item->getTitle() }} case study">
                            <i class="fa fa-angle-double-right"></i> Open Case Study
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endif
