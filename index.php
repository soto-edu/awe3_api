<?php

echo "Hello World";
?>
<h1>Version API No. 1</h1>

<h2>GET</h2>
<p>http://localhost/Exemples/API/v1/api/api.php/profiles</p>    
<p>http://localhost/Exemples/API/v1/api/api.php/profiles/1</p>
<p>http://localhost/Exemples/API/v1/api/api.php/profiles/2</p>
<p>http://localhost/Exemples/API/v1/api/api.php/profiles/3</p>


<h2>POST</h2>
<p>http://localhost/Exemples/API/v1/api/api.php/profiles</p>    
<p>Body: {
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "bio": "I am a software engineer"
}</p>

<h2>PUT</h2>
<p>http://localhost/Exemples/API/v1/api/api.php/profiles/1</p>
<p>Body: {
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "bio": "I am a software engineer"
}</p>