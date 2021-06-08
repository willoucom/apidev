<?php

if (array_key_exists('REQUEST_URI', $_SERVER)) {
    if (strpos($_SERVER['REQUEST_URI'], '/_/') === 0) {
        include("../src/app.php");

    } else {
        // Log query in file
        $log = array();
        $log['URI'] = $_SERVER['REQUEST_URI'];
        $log['Method'] = $_SERVER['REQUEST_METHOD'];
        $log['GET'] = $_GET;
        $log['POST'] = $_POST;
        $log['Body'] = file_get_contents('php://input');

        ob_start();
        echo json_encode($log);
        $log['Response'] = ob_get_contents();
        ob_clean();
        echo $log['Response'];
        $w = serialize($log);

        $sanitizeduri = $log['URI'];
        $sanitizeduri = substr($sanitizeduri, 0, strpos($sanitizeduri, "?"));
        $sanitizeduri = str_replace("/", ".", $sanitizeduri);

        $filename = $log['Method'].$sanitizeduri."_".time()."_".uniqid().".log";
        file_put_contents("/tmp/".$filename ,$w);
    }

}
