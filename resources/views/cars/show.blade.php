<!DOCTYPE html>
<html>
<head>
    <title>Car Details</title>
</head>
<body>
    <h1>{{ $car->make }} {{ $car->model }}</h1>
    <p>Year: {{ $car->year }}</p>
    <p>Available: {{ $car->available ? 'Yes' : 'No' }}</p>
</body>
</html>
