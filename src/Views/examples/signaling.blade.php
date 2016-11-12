<!DOCTYPE html>
<html>
    <head>
        <title>LaraTok - Signaling</title>

        <script src="https://static.opentok.com/v2/js/opentok.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <style>
            body, html {
                background-color: gray;
                height: 100%;
            }
            #videos {
                position: relative;
                width: 70%;
                height: 100%;
                float: left;
            }
            #subscriber {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                margin-left: 50px;
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
            #textchat {
                position: relative;
                width: 20%;
                float: right;
                right: 0;
                height: 100%;
                background-color: #333;
            }
            #history {
                width: 100%;
                height: calc(100% - 40px);
                overflow: auto;
            }
            input#msgTxt {
                height: 40px;
                position: absolute;
                bottom: 0;
                width: 100%;
            }
            #history .mine {
                color: #00FF00;
                text-align: right;
                margin-right: 10px;
            }
            #history .theirs {
                color: #00FFFF;
                margin-left: 10px;
            }
        </style>
    </head>

    <body>

        <div id="videos">
            <div id="subscriber"></div>
            <div id="publisher"></div>
        </div>

        <div id="textchat">
            <p id="history"></p>
            <form>
                <input type="text" placeholder="Input your text here" id="msgTxt"></input>
            </form>
        </div>
        <script charset="utf-8">
            var apiKey = "{{ config('laratok.api.api_key') }}";
            var sessionId = "{{ $laratok->sessionId }}";
            var token = "{{ $laratok->token_id }}";
            session = OT.initSession(apiKey, sessionId);

            var response;

            $(document).ready(function() {
                // Make an Ajax request to get the OpenTok API key, session ID, and token from the server

                initializeSession();
            });

            function initializeSession() {
                session = OT.initSession(apiKey, sessionId);

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

                // Receive a message and append it to the history
                var msgHistory = document.querySelector('#history');
                session.on('signal:msg', function(event) {
                    var msg = document.createElement('p');
                    msg.innerHTML = event.data;
                    msg.className = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
                    msgHistory.appendChild(msg);
                    msg.scrollIntoView();
                });

            }

            // Text chat
            var form = document.querySelector('form');
            var msgTxt = document.querySelector('#msgTxt');

            // Send a signal once the user enters data in the form
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                session.signal({
                    type: 'msg',
                    data: msgTxt.value
                }, function(error) {
                    if (!error) {
                        msgTxt.value = '';
                    }
                });
            });
        </script>
    </body>
</html>