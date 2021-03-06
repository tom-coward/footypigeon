@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>My Predictions</h1>
                <hr />

                <!-- Error message (if any) -->
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Status message (if any) -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('my-predictions.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if(count($predictions) > 0)
                        @foreach($predictions as $prediction)
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
                                <div class="col-md-12">
                                    <p style="text-align:center;">This prediction can be changed up until {{ \Carbon\Carbon::createFromTimestamp($prediction->ko_time)->toDayDateTimeString() }}.</p>
                                </div>
                            </div>

                            <br />
                        @endforeach

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Predictions</button>
                    @else
                        <div class="alert alert-danger" role="alert">
                            You do not currently have any predictions to set. Upcoming games will be shown here once they have been generated for your account - please check back in a couple of hours.
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
