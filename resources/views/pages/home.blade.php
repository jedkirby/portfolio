@extends('master')
@section('content')

    @include('pages.home.introduction')
    @include('pages.home.projects')

    @if($meetups)
        @include('pages.home.meetups')
    @else
        @include('pages.home.interest')
    @endif

    @include('pages.home.tweet')
    @include('pages.home.articles')

@stop
