<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./css/style.css">
   <title>Videogames - m07</title>
</head>
<body>
    <center>
   <h2>VIDEOGAMES</h2>

   <p>
       Welcome to our videogame page, click in "Collage" to see pictures of a lot of games.
   </p>
   <br><br>
   <ul>
       <?php
           foreach ($array_bookstores as $bookstore){
               if($bookstore =='Collage'){
               echo "<li> <a href='img.html'> $bookstore </a> </li> <br>" . PHP_EOL;
               }else if($bookstore =='Data table'){
                echo "<li> <a href='table.html'> $bookstore </a> </li> <br>" . PHP_EOL;
               }else if($bookstore =='Blog'){
                echo "<li> <a href='blog.html'> $bookstore </a> </li> <br>" . PHP_EOL;
               }else if($bookstore =='Web service'){
                echo "<li> <a href='api.html'> $bookstore </a> </li> <br>" . PHP_EOL;
               }
           }

       ?>
   </ul>
   </center>
</body>
</html>
