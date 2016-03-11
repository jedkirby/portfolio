@if($meetups)
    <div class="meetups">
        <div class="site__medium">
            <div class="col--wrapper">


                <div class="col  col--12">

                    <h4 class="meetups__title">
                        Upcoming {{ Illuminate\Support\Str::plural('Meetup', count($meetups)) }}
                    </h4>

                    <ul class="meetups__events">
                        @foreach($meetups as $event)
                            <li class="meetups__event">
                                <a href="{{ $event->getLink() }}" target="_blank">

                                    <h3>{{ $event->getName() }}</h3>

                                    <ul class="meetups__meta">

                                        @if($event->hasGroup())
                                            <li><i class="fa fa-group"></i> {{ $event->getGroupName() }}</li>
                                        @endif

                                        @if($event->hasVenue())
                                            <li><i class="fa fa-map-marker"></i> {{ $event->getVenueName() }}</li>
                                        @endif

                                        <li><i class="fa fa-user"></i> {{ $event->getRsvpCount() }}</li>

                                    </ul>

                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>


            </div>
        </div>
    </div>
@endif
