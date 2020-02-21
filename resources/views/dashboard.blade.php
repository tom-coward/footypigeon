@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Dashboard</h1>
            <hr />

            <!-- Status Message -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">My Points Summary</div>
                <div class="card-body">
                    <div class="row">
                        <!-- Weekly Points -->
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->weekly_points }} pts</h5>
                                    <p class="card-text">in past week</p>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Points -->
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->monthly_points }} pts</h5>
                                    <p class="card-text">in past month</p>
                                </div>
                            </div>
                        </div>

                        <!-- Season Points -->
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->season_points }} pts</h5>
                                    <p class="card-text">all season</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br />

            <div class="card">
                <div class="card-header">My League Positions</div>
                <div class="card-body">
                    @if(count(Auth::user()->teams) >= 1)
                        <div class="row">
                            @foreach(Auth::user()->teams->take(3) as $team)
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                @isset($team->position)
                                                    {{ $team->position }}
                                                @else
                                                    Not yet set
                                                @endisset
                                            </h5>
                                            <p class="card-text">{{ $team->league->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>You aren't currently a member of any leagues.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
