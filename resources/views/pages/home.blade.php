@extends('master')
@section('content')

    @include('pages.home.introduction')
    @include('pages.home.projects')

    @if($meetup)
        @include('pages.home.meetup')
    @else
        @include('pages.home.interest')
    @endif

    @include('pages.home.tweet')
    @include('pages.home.articles')

@stop
