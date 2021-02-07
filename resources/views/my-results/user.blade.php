@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>{{ $user->name }}'s Results</h1>
                <hr />

                @if(count($predictions) > 0)
                    <!-- TODO: center align pagination links -->
                    {{ $predictions->links() }}

                    <br />

                    @foreach($predictions as $prediction)
                        <div class="card">
                            <div class="card-body text-center">
                                <h4>{{ $prediction->home_team_name }} vs. {{ $prediction->away_team_name }}</h4>

                                <!-- User's Prediction -->
                                <h5>{{ $user->name }}'s Prediction</h5>
                                <h2 {{ $prediction->points_awarded > 0 ? 'class=text-success' : ''}}>{{ $prediction->home_team_goals }} - {{ $prediction->away_team_goals }}</h2>

                                <!-- Final Result -->
                                <h5>Final Result</h5>
                                <h2>{{ $prediction->result->home_team_goals }} - {{ $prediction->result->away_team_goals }}</h2>

                                @isset($prediction->points_awarded)
                                    <p class="text-center">{{ $user->name }} was awarded <b>{{ $prediction->points_awarded }} points</b> for this match.</p>
                                @endisset
                            </div>
                        </div>

                        <br />
                    @endforeach
                    <!-- TODO: center align pagination links -->
                        {{ $predictions->links() }}
                    </div>
                @else
                    <p>{{ $user->name }} does not yet have any recorded results. Please check back later.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
