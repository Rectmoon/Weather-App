<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullStack Weather App</title>

    <link rel="stylesheet" href="{{ mix('/css/style.css') }}">
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=6yAoynmTPNlTBa8z1X4LfwGE"></script>
</head>
<body class='bg-indigo-300'>
    <div id="app" class='flex justify-center pt-4'>
        <weather />
    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
