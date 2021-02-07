@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>My Results</h1>
                <hr />

                <!-- TODO: center align pagination links -->
                {{ $predictions->links() }}

                <br />

                @foreach($predictions as $prediction)
                    <div class="card">
                        <div class="card-body">
                            <!-- User's Prediction -->
                            <h5 class="text-center">Your Prediction</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="{{ $prediction->id }}HomeTeam">{{ $prediction->home_team_name }}</span>
                                        </div>
                                        <input type="number" min="0" class="form-control" aria-label="{{ $prediction->home_team_name }}" name="prediction[{{ $prediction->id }}][home]" placeholder="Enter score..." value="{{ $prediction->home_team_goals }}" aria-describedby="{{ $prediction->id }}HomeTeam" {{ now()->timestamp >= $prediction->ko_time ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="number" min="0" class="form-control" aria-label="{{ $prediction->away_team_name }}" name="prediction[{{ $prediction->id }}][away]" placeholder="Enter score..." value="{{ $prediction->away_team_goals }}" aria-describedby="{{ $prediction->id }}AwayTeam" {{ now()->timestamp >= $prediction->ko_time ? 'disabled' : '' }}>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="{{ $prediction->id }}AwayTeam">{{ $prediction->away_team_name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Final Result -->
                            <h5 class="text-center">Final Result</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="{{ $prediction->result->id }}HomeTeam">{{ $prediction->result->home_team_name }}</span>
                                        </div>
                                        <input type="number" class="form-control" aria-label="{{ $prediction->result->home_team_name }}" name="result[{{ $prediction->result->id }}][home]" value="{{ $prediction->result->home_team_goals }}" aria-describedby="{{ $prediction->result->id }}HomeTeam" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" aria-label="{{ $prediction->result->away_team_name }}" name="result[{{ $prediction->result->id }}][away]" value="{{ $prediction->result->away_team_goals }}" aria-describedby="{{ $prediction->result->id }}AwayTeam" disabled>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="{{ $prediction->result->id }}AwayTeam">{{ $prediction->result->away_team_name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @isset($prediction->points_awarded)
                                <p class="text-center">You were awarded <b>{{ $prediction->points_awarded }} points</b> for this match.</p>
                            @endisset
                        </div>
                    </div>

                    <br />
                @endforeach

                <!-- TODO: center align pagination links -->
                {{ $predictions->links() }}
            </div>
        </div>
    </div>
@endsection
