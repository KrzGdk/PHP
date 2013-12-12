<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="style.css" type="text/css">
  <title>Blogi</title>
</head>
<body>
<?php 
  require("header.php");
  define('DS', DIRECTORY_SEPARATOR);

  $users_blog_names = explode(PHP_EOL, file_get_contents('users'));
  foreach ($users_blog_names as $user_blog_name) {
    $arr = explode(';', $user_blog_name);
    if($arr[0] != "") $blogs[$arr[0]] = $arr[1];
  }
  if(!isset($_GET['nazwa'])){
    
?>
<div id="blogs">
  <p>Blogi w serwisie:</p>
  <ul>
  <?php foreach ($blogs as $author => $name) { 
    $path = 'blog.php?nazwa='.$name;
    ?>
    <li><strong><?php echo "<a href='$path'>$name</a>"?></strong> prowadzony przez <strong><?php echo $author;?></strong>;
  
  <?php } ?>
  </ul>
</div>
<?php } else if(array_search($_GET['nazwa'], $blogs)){
  $name = $_GET['nazwa'];
  $author = array_search($name, $blogs);
  echo $name;


} else{ ?>
<p>Taki blog nie istnieje</p>
<?php } ?>
</body>
</html>