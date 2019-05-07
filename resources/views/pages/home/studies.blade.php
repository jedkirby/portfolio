@if($studies)

    <section class="studies">

        @foreach($studies as $study)

            <div id="{{ $study->getId() }}" class="study" style="background-image: url({{ $study->getHero() }})">

                <div class="study__overlay"></div>

                <div class="study__meta">

                    <h2 class="study__meta--title">
                        <a href="{{ $study->getUrl() }}" title="Open the {{ $study->getTitle() }} case study">{{ $study->getTitle() }}</a>
                    </h2>

                    <p class="study__meta--intro">{{ $study->getIntro() }}</p>

                    <a href="{{ $study->getUrl() }}" class="study__meta--link" title="Open the {{ $study->getTitle() }} case study">
                        <i class="fa fa-angle-double-right"></i> Open Case Study
                    </a>

                </div>

            </div>

        @endforeach

    </section>

@endif
