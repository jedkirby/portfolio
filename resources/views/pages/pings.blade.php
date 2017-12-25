@extends('master')

@section('id', 'pings')
@section('content')

    <div class="site__medium">
        <div class="col--wrapper">


            <div class="col  col--12">
                <div class="col--content">

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="30%">Service</th>
                                <th width="50%">Data</th>
                                <th width="20%">Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($pings as $ping)

                                <tr>
                                    <td>{{ $ping->getService() }}</td>
                                    <td>{{ $ping->getData() }}</td>
                                    <td>{{ $ping->getDate()->format('F j, Y') }}</td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>


        </div>
    </div>

@stop
