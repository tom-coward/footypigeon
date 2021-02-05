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
                                    <p class="card-text">this week</p>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Points -->
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->monthly_points }} pts</h5>
                                    <p class="card-text">this month</p>
                                </div>
                            </div>
                        </div>

                        <!-- Season Points -->
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->season_points }} pts</h5>
                                    <p class="card-text">this season</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />
                    <div style="text-align:center">
                        <a href="#howPointsAreAwardedModal" data-toggle="modal" data-target="#howPointsAreAwardedModal">How points are awarded</a>
                    </div>
                </div>
            </div>

            <br />

            <div class="card">
                <div class="card-header">My League Positions</div>
                <div class="card-body">
                    @if(count(Auth::user()->teams) > 0)
                        <div class="row">
                            @foreach(Auth::user()->teams->take(3) as $team)
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <!-- TODO: add ordinal suffix to league position -->
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

            @if(count(Auth::user()->archivedTeams) > 0)
                <br />

                <div class="card">
                    <div class="card-header">My History</div>
                    <div class="card-body">
                        <div class="row">
                            @foreach(Auth::user()->archivedTeams->take(3) as $archivedTeam)
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <!-- TODO: add ordinal suffix to league position -->
                                                {{ $archivedTeam->points }} (League position: {{ $archivedTeam->league_position }})
                                            </h5>
                                            <p class="card-text">
                                                {{ $archivedTeam->league_name }}<br />
                                                <small>{{ $archivedTeam->season_year }} season</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- 'How points are awarded' Modal -->
<div class="modal fade" id="howPointsAreAwardedModal" tabindex="-1" role="dialog" aria-labelledby="howPointsAreAwardedModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="howPointsAreAwardedModalLabel">How points are awarded</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Correct score</h5>
                        <p class="card-text">For each correctly predicted score, you'll be awarded 20 points.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Correct winner</h5>
                        <p class="card-text">If you predict the correct winner, you'll be awarded 10 points.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
