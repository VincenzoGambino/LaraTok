@extends('laratok::laratok')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">LaraTok Overview</div>
                    <div class="panel-body">
                        @if (!$sessions)
                            Add api_key and api_secret in config/laratok.php
                        @else
                            @foreach ($sessions as $key => $session)
                                <table style="table-layout: fixed; width: 100%">
                                    <tr><td colspan="5">Session name: {{ $key }}</td></tr>
                                    <tr><th>id</th><th>TokenID</th><th>Role</th><th>Expire Time</th><th>Created</th></tr>
                                    @foreach ($session as $token)
                                        <tr>
                                            <td class="col-md-1">{{ $token->id }}</td>
                                            <td class="col-md-5" style="word-wrap: break-word">{{ $token->token_id }}</td>
                                            <td class="col-md-2">{{ $token->role }}</td>
                                            <td class="col-md-2">{{ $token->expire_time }}</td>
                                            <td class="col-md-2">{{ $token->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection