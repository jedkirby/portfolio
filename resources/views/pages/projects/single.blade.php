@extends('master')

@section('id', 'work')
@section('content')

    <div class="single  js-project">

        <div class="site__medium  project">
            <div class="col--wrapper">


                <div class="col  col--12">
                    <div class="col--content  col--full">


                        <div class="project__intro">

                            <h2>{{ $project->getTitle() }}</h2>
                            <p class="project__sub">{{ $project->getSubTitle() }}</p>

                            @if( ($expired = $project->getExpired()) )
                                <p class="project__expired">{{ $expired }}</p>
                            @endif

                            {!! $project->getIntroduction() !!}

                            @if( ($link = $project->getLink()) )
                                <a href="{{ $link }}" class="btn  btn__primary  btn__icon" target="_blank">
                                    <i class="fa fa-globe"></i>
                                    Visit Site
                                </a>
                            @endif

                        </div>


                        @if( ($images = $project->getImages()) )

                            <div class="browser">
                                <div class="browser__inner">

                                    <div class="browser__frame">
                                        <span class="js-browser-prev" title="Previous"></span>
                                        <span class="js-browser-pause" title="Play/Pause"></span>
                                        <span class="js-browser-next" title="Next"></span>
                                    </div>

                                    <div class="browser__slider  js-slider">
                                        @foreach($images as $src)
                                            <div class="browser__slider--slide"><img src="{{ $src }}" /></div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        @endif


                        <div class="project__content">
                            {!! $project->getContent() !!}
                        </div>

                        <div class="social  project__social">
                            <a href="{{ $page->facebook->shareUrl }}" class="btn  btn__icon  social__button  social__button--facebook" title="Facebook" target="_blank">
                                <i class="fa fa-facebook"></i> <span>Facebook</span>
                            </a>
                            <a href="{{ $page->twitter->shareUrl }}" class="btn  btn__icon  social__button  social__button--twitter" title="Twitter" target="_blank">
                                <i class="fa fa-twitter"></i> <span>Twitter</span>
                            </a>
                            <a href="{{ $page->plus->shareUrl }}" class="btn  btn__icon  social__button  social__button--google" title="Google Plus" target="_blank">
                                <i class="fa fa-google"></i> <span>Google</span>
                            </a>
                            <a href="{{ $page->pinterest->shareUrl }}" class="btn  btn__icon  social__button  social__button--pinterest" title="Pinterest" target="_blank">
                                <i class="fa fa-pinterest"></i> <span>Pinterest</span>
                            </a>
                        </div>


                    </div>
                </div>


            </div>
        </div>

        @if( ($testimonial = $project->getTestimonial()) )

            <div class="testimonial">
                <div class="site__full">
                    <div class="col--wrapper">

                        <div class="col  col--12">
                            <div class="col--content  col--no-bottom">

                                <h3>Testimonial</h3>
                                {!! $testimonial !!}

                                <p class="testimonial__date">
                                    <i class="fa fa-clock-o"></i>
                                    {{ $project->getDate()->format('F jS, Y') }}
                                </p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endif

    </div>

@stop
