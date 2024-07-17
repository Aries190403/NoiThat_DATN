<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTools Detected</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .message-box {
            text-align: center;
        }
        .message-box h1 {
            font-size: 3em;
            margin-bottom: 0.5em;
        }
        .message-box p {
            font-size: 1.5em;
        }
    </style>
    <script type="text/javascript">
        document.addEventListener('keydown', function(event) {
            if (event.keyCode == 123) { // F12
                event.preventDefault();
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Ctrl+Shift+I
                event.preventDefault();
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 74) { // Ctrl+Shift+J
                event.preventDefault();
                return false;
            } else if (event.ctrlKey && event.keyCode == 85) { // Ctrl+U
                event.preventDefault();
                return false;
            }
        });

        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
            return false;
        });
    </script>
</head>
<body>
    <div class="message-box">
        <h1>DevTools Detected</h1>
        <p>It looks like you're trying to inspect the code. For security reasons, this action is not allowed.</p>
    </div>
</body>
</html>
