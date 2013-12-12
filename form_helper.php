<?php
function validate($str){
  if (preg_match('/^[a-zA-Z0-9]{4,12}$/i', $str)) {
    return true;
  } else {
    return false;
  }
}
function validate_blog($str){
  if (preg_match('/^[ a-zA-Z0-9]{4,30}$/i', $str)) {
    return true;
  } else {
    return false;
  }
}