<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Version 3 API avec Swagger</title>
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <p><?php echo $description; ?></p>
    <h1>Version API No. 3</h1>

    <button onclick="window.location.href='http://localhost:8080/api/swagger'">Swagger</button>
    <h2>GET</h2>
    <p>http://localhost:8080/api/profiles</p>    
    <p>http://localhost:8080/api/profiles/1</p>
    <p>http://localhost:8080/api/profiles/2</p>
    <p>http://localhost:8080/api/profiles/3</p>


    <h2>POST</h2>
    <p>http://localhost:8080/api/profiles</p>    
    <p>Body: {
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@example.com",
        "bio": "I am a software engineer"
    }</p>

    <h2>PUT</h2>
    <p>http://localhost:8080/api/profiles/1</p>
    <p>Body: {
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@example.com",
        "bio": "I am a software engineer"
    }</p>
</body>
</html>
