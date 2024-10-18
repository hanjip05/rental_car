<!DOCTYPE html>
<html>
<head>
    <title>Car List</title>
</head>
<body>
    <h1>Available Cars</h1>
    <ul>
        @foreach($cars as $car)
            <li>{{ $car->make }} {{ $car->model }}</li>
        @endforeach
    </ul>
</body>
</html>
