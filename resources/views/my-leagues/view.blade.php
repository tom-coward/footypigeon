@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col">
                        <h1>
                            {{ $league->name }}
                        </h1>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#manageLeagueModal">Manage League</button>
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

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Manager</th>
                        @if(Auth::user()->id == $league->leagueAdmin->id)
                            <th scope="col">Manage</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($league->teams as $team)
                        <tr>
                            <th scope="row">
                                @isset($team->position)
                                    {{ $team->position }}
                                @else
                                    Not yet set
                                @endisset
                            </th>
                            <td>{{ $team->manager->name }}</td>
                            @if((Auth::user()->id == $league->leagueAdmin->id) AND ($team->manager->id != $league->league_admin_id))
                                <td>
                                    <form action="{{ route('my-leagues.remove', [$league->id, $team->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm btn-block">Remove</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="manageLeagueModal" tabindex="-1" role="dialog" aria-labelledby="manageLeagueModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageLeagueModalLabel">Manage {{ Auth::user()->id == $league->league_admin_id ? 'League' : 'Membership' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                @if(Auth::user()->id == $league->league_admin_id) <!-- Manage League -->
                    <!-- Manage League Form -->
                    <div class="container">
                        <form id="manageForm" action="{{ route('my-leagues.update', [$league->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">League name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $league->name }}" placeholder="Enter league name..." required>
                            </div>

                            <button type="submit" form="manageForm" class="btn btn-primary float-right">Save</button>
                        </form>
                    </div>

                    <br />
                    <hr />

                    <!-- Delete League Button -->
                    <div class="container">
                        <form action="{{ route('my-leagues.destroy', [$league->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg btn-block">Delete league</button>
                        </form>
                    </div>

                    <hr />

                    <!-- Invite Member Form -->
                    <div class="container">
                        <form action="{{ route('my-leagues.invite', [$league->id]) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="username">Invite member</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter invitee's username..." required>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Invite</button>
                        </form>
                    </div>
                @else <!-- Manage Membership -->
                    <form method="POST" action="{{ route('my-leagues.leave', [$league->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg btn-block">Leave league</button>
                    </form>

                    <p>Please note that if you choose to leave this league, in order to re-join you'll need to be invited again by the league's administrator.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
