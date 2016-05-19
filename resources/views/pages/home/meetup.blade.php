@if($meetup)
    <div class="meetup">
        <div class="site__medium">
            <div class="col--wrapper">


                <div class="col  col--12">

                    <h4 class="meetup__title">Latest Meetup Attending</h4>

                    <div class="meetup__event">

                        <a href="{{ $meetup->getLink() }}" target="_blank">
                            <h3>{{ $meetup->getName() }}</h3>
                        </a>

                        <ul class="meetup__meta">

                            @if($meetup->hasGroup())
                                <li title="Group Name"><i class="fa fa-group"></i> {{ $meetup->getGroupName() }}</li>
                            @endif

                            @if($meetup->hasVenue())
                                <li title="Venue"><i class="fa fa-map-marker"></i> {{ $meetup->getVenueName() }}</li>
                            @endif

                            <li title="RSVP Count"><i class="fa fa-user"></i> {{ $meetup->getRsvpCount() }}</li>

                        </ul>

                    </div>

                </div>


            </div>
        </div>
    </div>
@endif
