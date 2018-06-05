<?php

function img_to_base64($image) {
    $path = "../imgg/$image";
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = base64_encode($data);

    return $base64;
}

?>
