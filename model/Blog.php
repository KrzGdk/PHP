<?php
error_reporting(-1);
ini_set('display_errors', 'On');

function add_blog($user,$blog,$pass,$desc){
  if(!file_exists('data')){
    if(!mkdir('data')){
      return false;
    }
  }

  $path = "data".DIRECTORY_SEPARATOR.$blog;
  if(!file_exists($path)){
    if(mkdir($path) && touch($path.DIRECTORY_SEPARATOR.'info')){
      $output = implode(PHP_EOL, array($user,$pass,$desc));
      file_put_contents($path.DIRECTORY_SEPARATOR.'info', $output);
      if(!file_exists('users')){
        if(!touch('users')){
          return false;
        }
      }
      if($fu = fopen("users", "a")){
        fwrite($fu, $user. ';' .$blog.PHP_EOL);
        fclose($fu);
        return true;
      }
      else{
        echo "pierwszy else";
        return false;
      }
    }
    else{
      echo "drugi else";
      return false;
    }
  }
  else{
    echo "Taki blog już istnieje";
    return false;
  }
}

?>