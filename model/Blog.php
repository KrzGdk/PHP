<?php
error_reporting(-1);
ini_set('display_errors', 'On');

function add_blog($user,$blog,$pass,$desc){
  $path = "data/" .$blog;
  if(!file_exists($path)){
    if(mkdir($path) && touch($path. "/info")){
      $output = implode(PHP_EOL, array($user,$pass,$desc));
      file_put_contents($path. "/info", $output);
      $fu = fopen("users", "a");
      fwrite($fu, $user. '/' .$blog.PHP_EOL);
      fclose($fu);
    }
    else{
      echo "Błąd zapisu";
    }
  }
  else{
    echo "Taki blog już istnieje";
  }
}

?>