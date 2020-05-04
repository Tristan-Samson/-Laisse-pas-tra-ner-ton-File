<!DOCTYPE html>

<html lang="en-us">

<head>

    <meta charset="UTF-8">

    <title>upload</title>

</head>

<body>

<form action="" method="post" enctype="multipart/form-data">

    <input type="file" value="" name="upload[]" multiple>

    <button type="submit" name="envoi">Upload!</button>

</form>

<script></script>

</body>

</html>





<?php
$uploadDir = './uploads/';


if(isset($_POST['delete'])) {
    if (file_exists($_POST['delete'])) {
        unlink($_POST['delete']);
    }
}

$path = './uploads/';
$dir = new FilesystemIterator($path);
foreach ($dir as $fileinfo) {
    $name =  $fileinfo->getFilename();
    $fullpath = $path . $name;
    echo "<figure>
    <img src='$fullpath'>
    <figcaption>$name</figcaption>
</figure>";
    echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" >
    <button type = \"submit\" name=\"delete\" value='$fullpath'>delete!</button>
</form>";
}

if(isset($_POST['envoi'])) {

    if($_FILES['upload']['name'][0] != "") {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
            if (filesize($_FILES['upload']['tmp_name'][$i]) > 1000000) {
                echo "One of the files size is bigger than 1MO";
                exit();
            }
            $fileExtension = finfo_file($finfo, $_FILES['upload']['tmp_name'][$i]);
            //var_dump($fileExtension);
            if ($fileExtension != 'image/gif' && $fileExtension != 'image/jpeg' && $fileExtension != 'image/png') {
                echo "One of the files doesn't have the correct extension";
                exit();
            }

            $extension = pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $filename;
            move_uploaded_file($_FILES['upload']['tmp_name'][$i], $uploadFile);
        }
    finfo_close($finfo);
    }
}
?>
