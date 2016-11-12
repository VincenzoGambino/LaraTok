<!DOCTYPE HTML>
<html>
<body>
<script src="https://static.opentok.com/v2/js/opentok.js" charset="utf-8"></script>
<script charset="utf-8">
    var apiKey = "{{ $laratok['api_key'] }}";
    var sessionId = "{{ $laratok['session_id'] }}";
    var token = "{{ $laratok['token'] }}";
    var session = OT.initSession(apiKey, sessionId)
            .on('streamCreated', function(event) {
                session.subscribe(event.stream);
            })
            .connect(token, function(error) {
                var publisher = OT.initPublisher();
                session.publish(publisher);
            });
</script>
</body>
</html>