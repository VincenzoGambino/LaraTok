@extends('laratok::laratok')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">LaraTok Examples</div>
                    <div class="panel-body">
                        @if (!$sessions)
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/laratok/examples/generate') }}">
                                <button type="submit" class="btn btn-primary">
                                    Generate Examples
                                </button>
                            </form>
                        @else
                            @foreach ($sessions as $key => $session)
                                <table>
                                    <tr><td>Name: {{ $key }}</td></tr>
                                    <tr><th>id</th><th>TokenID</th><th>Role</th><th>Expire Time</th><th>Created</th></tr>
                                    @foreach ($session as $token)
                                        <tr>
                                            <td>{{ $token->id }}</td>
                                            <td>{{ $token->token_id }}</td>
                                            <td>{{ $token->role }}</td>
                                            <td>{{ $token->expire_time }}</td>
                                            <td>{{ $token->created_at }}</td>
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