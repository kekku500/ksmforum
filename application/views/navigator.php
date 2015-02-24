<br>
<?php 
echo '[';
$path_count = count($path);
for($i = 0;$i<$path_count;$i++){
    $p = $path[$i];
    $name = $p[0];
    $url = $p[1];
    echo '<a href="'.$url.'">'.$name.'</a>'; 
    if($i < $path_count - 1)
        echo ' => ';
}
echo ']';
?>