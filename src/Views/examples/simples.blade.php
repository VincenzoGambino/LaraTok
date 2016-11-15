<!DOCTYPE html>
<html>
    <head>
        <title>LaraTok - Simple</title>
        <script src="https://static.opentok.com/v2/js/opentok.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <style>
            body, html {
                background-color: gray;
                height: 100%;
            }
            #videos {
                position: relative;
                width: 100%;
                height: 100%;
                margin-left: auto;
                margin-right: auto;
            }
            #subscriber {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                z-index: 10;
            }
            #publisher {
                position: absolute;
                width: 360px;
                height: 240px;
                bottom: 10px;
                left: 10px;
                z-index: 100;
                border: 3px solid white;
                border-radius: 3px;
            }
        </style>
        <script src="https://static.opentok.com/v2/js/opentok.js" charset="utf-8"></script>
    </head>
    <body>
        <div id="videos">
            <div id="subscriber"></div>
            <div id="publisher"></div>
        </div>
        <script charset="utf-8">
            var apiKey = "{{ config('laratok.api.api_key') }}";
            var sessionId = "{{ $laratok->sessionId }}";
            var token = "{{ $laratok->token_id }}";
            var session = OT.initSession(apiKey, sessionId);

            // Subscribe to a newly created stream
            session.on('streamCreated', function(event) {
                session.subscribe(event.stream, 'subscriber', {
                    insertMode: 'append',
                    width: '100%',
                    height: '100%'
                });
            });

            session.on('sessionDisconnected', function(event) {
                console.log('You were disconnected from the session.', event.reason);
            });

            // Connect to the session
            session.connect(token, function(error) {
                // If the connection is successful, initialize a publisher and publish to the session
                if (!error) {
                    var publisher = OT.initPublisher('publisher', {
                        insertMode: 'append',
                        width: '100%',
                        height: '100%'
                    });

                    session.publish(publisher);
                } else {
                    console.log('There was an error connecting to the session: ', error.code, error.message);
                }
            });
        </script>
    </body>
</html>