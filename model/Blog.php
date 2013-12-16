<?php
error_reporting(-1);
ini_set('display_errors', 'On');
define('DS', DIRECTORY_SEPARATOR);

function add_blog($user,$blog,$pass,$desc){
  if(!file_exists('data')){
    if(!mkdir('data')){
      return false;
    }
  }

  $path = "data".DS.$blog;
  if(!file_exists($path)){
    if(mkdir($path) && file_put_contents($path.DS.'info', '', LOCK_EX)){
      $output = implode(PHP_EOL, array($user,$pass,$desc));
      file_put_contents($path.DS.'info', $output, LOCK_EX);
      if(!file_exists('users')){
        if(!file_put_contents('users', '', LOCK_EX)){
          return false;
        }
      }
      if($fu = fopen("users", "a")){
        if(flock($fu, LOCK_EX)){
          fwrite($fu, $user. ';' .$blog.PHP_EOL);
          flock($fu, LOCK_UN);
          fclose($fu);
          return true;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }
  }
  else{
    echo "Taki blog już istnieje";
    return false;
  }
}

function add_comment($blog, $id, $nick, $type, $cont){
  $blog_path = 'data'.DS.$blog;
  $folder_name = $id.'.k';
  $folder_path = $blog_path.DS.$folder_name;
  if(!file_exists($folder_path)){
    if(!mkdir($folder_path)){
      return false;
    }
    else{
      $comm_id = 0;
    }
  }
  else{
    $files = array_diff(scandir($folder_path), array('.','..')); 
    $comm_id = count($files);
  }
  $data = $type.PHP_EOL.date('Y-m-d, H:i:s').PHP_EOL.$nick.PHP_EOL.$cont;
  if(file_put_contents($folder_path.DS.$comm_id, $data, LOCK_EX)) return true;
  else return false;
}

?>