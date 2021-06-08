<?php

// Show logs
$myarray = glob("/tmp/*.log");
usort($myarray, function ($a, $b) {
    return filemtime($b) - filemtime($a);
});

$i = 0;
$return = [];
foreach ($myarray as $file) {
    $file = basename($file);
    $return[] = $file;
    if ($i >= 25) {
        break;
    }
    $i++;
}

echo json_encode($return);
