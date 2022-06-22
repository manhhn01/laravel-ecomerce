<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momo Redirect</title>
    <script>
        window.opener.postMessage({
            status: '{{$status}}',
            error: '{{$error}}',
        }, 'http://localhost:3000');
        window.close();
    </script>
</head>
<body>

</body>
</html>
