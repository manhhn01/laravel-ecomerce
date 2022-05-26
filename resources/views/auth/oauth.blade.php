<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{config('app.name')}}</title>
    <script>
        window.opener.postMessage({!! $user !!}, 'http://localhost:3000');
        window.close();
    </script>
</head>
<body>
    Success...
</body>
</html>
