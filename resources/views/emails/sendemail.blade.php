@extends('auth.layouts')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Praktikum Pemrograman Web</title>
</head>
<body>
    <h3>{{ $data['name'] }}</h3>
    <h4>{{ $data['body'] }}</h4>

    <p>Terimakasih</p>
</body>
</html>
@endsection