<?php
# Funkcje czyszczące cały system
# aby usunąć wszystkie dane, wystarczy wywołać clear_all()

function clear_all(){
  $dir = '../data';
  $files = array_diff(scandir('../data'), array('.','..')); 
  foreach ($files as $file) { 
    (is_dir("$dir/$file")) ? delete_folder("$dir/$file") : unlink("$dir/$file"); 
  }
  file_put_contents('../users', '');
}

function delete_folder($dir){
  $files = array_diff(scandir($dir), array('.','..')); 
  foreach ($files as $file) { 
    (is_dir("$dir/$file")) ? clear_all("$dir/$file") : unlink("$dir/$file"); 
  } 
  return rmdir($dir); 
}