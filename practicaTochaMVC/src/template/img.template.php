<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/img_style.css">
    <title>Image Viewer</title>
</head>

<body>
    <center>
    <h2>Click in the images to see more!!</h2>
        <?php
        $cont=0;
                foreach ($array_img as $image){
                    echo "<a href='$make_text_links[$cont]'> <img src='$image' alt=''> </a>" . PHP_EOL;
                    $cont++;
                }
        ?>
    </center>
</body>                                            

</html>
