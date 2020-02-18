@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col">
                        <h1>My Leagues</h1>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#createNewLeagueModal">Create New League</button>
                    </div>
                </div>

                <hr />

                <!-- Error message (if any) -->
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Status Message -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- League List -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">League name</th>
                            <th scope="col">Your position</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Auth::user()->teams as $team)
                            <tr>
                                <td>{{ $team->league->name }}</td>
                                <td>
                                    @isset($team->position)
                                        {{ $team->position }}
                                    @else
                                        Not yet set
                                    @endisset
                                </td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('my-leagues.show', [$team->league->id]) }}">View</a>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#manageLeagueModal{{ $team->id }}">Manage</button>
                                </td>
                            </tr>

                            <!-- Manage League Modal -->
                            <div class="modal fade" id="manageLeagueModal{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="manageLeagueModal{{ $team->id }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="manageLeagueModal{{ $team->id }}Label">Manage {{ Auth::user()->id == $team->league->league_admin_id ? 'League' : 'Membership' }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if(Auth::user()->id == $team->league->league_admin_id) <!-- Manage League -->
                                                <!-- Manage League Form -->
                                                <form action="{{ route('my-leagues.update', [$team->league->id]) }}" method="PUT">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="name">League name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $team->league->name }}" placeholder="Enter league name..." required>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary float-right">Save</button>
                                                </form>

                                                <br />

                                                <!-- Invite Member Form -->
                                                <form action="{{ route('my-leagues.invite', [$team->league->id]) }}" method="POST">
                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="username">Invite member</label>
                                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter invitee's username..." required>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary float-right">Invite</button>
                                                </form>
                                            @else <!-- Manage Membership -->
                                                <a class="btn btn-danger" href="{{ route('my-leagues.leave', [$team->league->id]) }}" role="button">Leave league</a>

                                                <p>Please note that if you choose to leave this league, in order to re-join you'll need to be invited again by the league's administrator.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Create New League Modal -->
    <div class="modal fade" id="createNewLeagueModal" tabindex="-1" role="dialog" aria-labelledby="createNewLeagueModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNewLeagueModalLabel">Create New League</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('my-leagues.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">League name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter league name..." required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
