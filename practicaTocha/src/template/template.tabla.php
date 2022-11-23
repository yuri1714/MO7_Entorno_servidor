<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="/css/practica.css">
</head>

<body>
   <center>
      <h2>TABLA VIDEOJUEGOS</h2>
   </center>
   <ul>
      <center>
         <table id="demo"><?php
                           //array_lines   asdadasd array_fields
                           foreach ($table as $row) {
                              echo "<tr>";
                              foreach ($row as $field) {
                                 echo "<td>$field</td>";
                              }
                              echo "</tr>" . PHP_EOL;
                           }

                           ?></table>
      </center>
   </ul>
</body>

</html>