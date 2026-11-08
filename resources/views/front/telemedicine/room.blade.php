<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Consultation | {{ config('app.name') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #1a1a1a;
        }

        #jitsi-container {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div id="jitsi-container"></div>

    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        const domain = 'meet.jit.si';
        const options = {
            roomName: '{{ $videoConsultation->meeting_room_id }}',
            width: '100%',
            height: '100%',
            parentNode: document.querySelector('#jitsi-container'),
            userInfo: {
                displayName: '{{ $videoConsultation->patient_name }}',
            },
            configOverwrite: {
                startWithAudioMuted: true,
                disableDeepLinking: true,
            },
            interfaceConfigOverwrite: {
                SHOW_JITSI_WATERMARK: false,
                SHOW_WATERMARK_FOR_GUESTS: false,
            },
        };
        const api = new JitsiMeetExternalAPI(domain, options);
    </script>
</body>

</html>
