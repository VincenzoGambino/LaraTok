<!DOCTYPE HTML>
<html>
<body>
    Admin
    @if (!$sessions)
    <form id="generate-session" method="post" action="">
    </form>
    @endif
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
</body>
</html>