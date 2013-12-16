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
  <h1>Blogi w serwisie:</h1>
  <ul>
  <?php foreach ($blogs as $author => $name) { 
    $path = 'blog.php?nazwa='.$name;
    ?>
    <li><strong><?php echo "<a href='$path'>$name</a>";?></strong> prowadzony przez <strong><?php echo $author;?></strong>
  
  <?php } ?>
  </ul>
</div>
<?php } else if(array_search($_GET['nazwa'], $blogs)){
  $name = $_GET['nazwa'];
  $author = array_search($name, $blogs);
?>

<div id="blogs">
  <h1><?php echo $name; ?></h1>
  <em>Autor: <?php echo $author; ?></em>
  <?php 
  $dir = 'data'.DS.$name;
  $files = array_diff(scandir($dir), array('.','..','info')); 
  if(empty($files)){ ?>
    <article  style="text-align: center;">
      <p style="display: inline-block">Nie ma tu jeszcze żadnego wpisu!</p>
    </article>
  <?php
  }
  $files = array_reverse($files);
  foreach ($files as $file) {
    if(preg_match('/^[0-9]{16}$/', $file)){
      if(!file_exists('data'.DS.$name.DS.$file.'.k')){
        $comm_count = 0;
      }
      else{
        $comm_count = count(array_diff(scandir('data'.DS.$name.DS.$file.'.k'), array('.','..')));
      }
      $lines = file($dir.DS.$file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); ?>
        <article>
          <header>
            <p><?php echo $lines[0].' '.$lines[1];?></p>
          </header>
            <p>

            <?php 
              $j = 2;
              $reg  = '/^data\\'.DS.$name.'\\'.DS.$file.'[123]\./';
              while(!preg_match($reg, $lines[$j]) && $lines[$j]){
                echo $lines[$j++].'<br>'; 
              }
              ?>

            </p>
            <?php if($lines[$j]){
              echo '<p id="attachp">Załączniki:</p><ul id="attach">';
                for ($i=$j; $i < $j+3; $i++) { 
                  if($lines[$i])
                    echo '<li><a href='.str_replace(" ", "%20", $lines[$i]).'>Załącznik 1. (.'.pathinfo($lines[$i], PATHINFO_EXTENSION).')</a><br>';
                }
              } ?>
          </ul>
          <section class="comments">
            <?php
            if($comm_count == 0){
              echo "<h3>Brak komentarzy</h3>&nbsp;&nbsp;";
              echo "<a href='koment.php?blog=$name&amp;id=$file' class='addcomm'>Bądź pierwszy</a>";
            }
            else{
              echo "<h3>Komentarze ($comm_count)</h3>&nbsp;&nbsp;";
              echo "<a href='koment.php?blog=$name&amp;id=$file' class='addcomm'>Dodaj komentarz</a>";
              
              $comm_dir = 'data'.DS.$name.DS.$file.'.k';
              $comm_files = array_diff(scandir($comm_dir), array('.','..')); 
              foreach ($comm_files as $comm_file) {
                $comm_lines = file($comm_dir.DS.$comm_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
              
              ?>
            <article>
              <header>
                <p class="alignleft">Autor: <?php echo $comm_lines[2]; ?></p>
                <p class="aligncenter"><?php echo $comm_lines[0]; ?></p>
                <p class="alignright"><?php echo $comm_lines[1]; ?></p>
              </header>
              <div style="clear: both;"></div>
              <p class="comment">
              <?php $k = 3; while($comm_lines[$k]) echo $comm_lines[$k++].'<br>'; ?>
              </p>
            </article>
          <?php } 
              }
          ?>
        </section>
      </article>
      <?php
      }

    }
?>

</div>

<?php } else{ ?>
<p>Taki blog nie istnieje</p>
<?php } ?>
</body>
</html>