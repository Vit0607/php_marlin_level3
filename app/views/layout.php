<html>
<head>
    <title><?=$this->e($title)?></title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>

<nav>
    <ul>
        <li><a href="/home">Homepage</a></li>
        <li><a href="/about">About</a></li>
    </ul>
</nav>

<?=$this->section('content')?>
</body>
</html>
