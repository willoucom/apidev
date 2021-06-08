<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
<meta name="theme-color" content="#000000">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:300,400,500">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700">
<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
<link rel="stylesheet" href="/style.css">
<title>APIDev</title>
</head>
<body>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    (function() {
      var status = $('.status'),
        poll = function() {
          $.ajax({
            url: '/menu.php',
            dataType: 'json',
            type: 'get',
            success: function(data) { // check if available
                $(".mdc-list").html("");
                $(data).each(function(index, item) {
                    $( ".mdc-list" ).append("<a class='mdc-list-item' href='?f="+item+"'><span class='mdc-list-item__ripple'></span><i class='material-icons mdc-list-item__graphic' aria-hidden='true'>insert_drive_file</i><span class='mdc-list-item__text'>"+item+"</span\></a\>");
                });
            },
            error: function() { // error logging
              console.log('Error!');
            }
          });
        },
        pollInterval = setInterval(function() { // run function every 2000 ms
          poll();
          }, 2000);
        poll(); // also run function on init
    })();
</script>

<header class="mdc-top-app-bar mdc-top-app-bar--short">
  <div class="mdc-top-app-bar__row">
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
      <span class="mdc-top-app-bar__title">APIDev</span>
    </section>
  </div>
</header>


<aside class="mdc-drawer mdc-top-app-bar--fixed-adjust">
  <div class="mdc-drawer__content">
    <nav class="mdc-list">
    </nav>
  </div>
</aside>

<div class="mdc-top-app-bar--short-fixed-adjust">
    <main class="main-content" id="main-content">

<?php

if (isset($_GET['f'])) {
    $str = file_get_contents("/tmp/".basename($_GET['f']));
    $str = unserialize($str);


    foreach($str as $key => $value) {
        if(is_array($value)) {
            continue;
        }

        // Json
        $result = json_decode($value);
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON is valid
            $str["Json_$key"] = $result;
        }
        // Xml
        libxml_use_internal_errors(true);
        $result = simplexml_load_string($value);
        if ($result) {
            // XML is valid
            $str["XML_$key"] = $result;
        }

        // Gzip
        if (0 === mb_strpos($value , "\x1f" . "\x8b" . "\x08")) {
            $result = gzdecode($value);
            if ($result) {
                $str[$key] = "Gzipped, see Gunzip_$key";
                $str["Gunzip_$key"] = htmlentities($result);
            }
        }
    }
    
    // Body
    $str['Body'] = htmlentities($str['Body']);
    $str['Response'] = htmlentities($str['Response']);

    foreach ($str as $key => $value) {
        echo "<div>";
        echo "<span>" . $key . " : </span>";
        echo "<span>";
        if (is_string($value)) {
          echo $value;
        } else {
          print_r($value);
        }
        echo "</span>";
        echo "</div>";
    }
}
?>

    </main>
  </div>



</body>
</html>