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
  require("form_helper.php");
  require("model/Blog.php");
  error_reporting(-1);
  ini_set('display_errors', 'On');
  if(isset($_POST['sent'])){
    $user_name = trim(htmlspecialchars($_POST['user_name']));
    $blog_name = trim(htmlspecialchars($_POST['blog_name']));
    $pass = trim($_POST['pass']);
    $desc = trim(htmlspecialchars($_POST['desc']));
    if(validate($user_name) && validate_blog($blog_name) && strlen($pass) > 3){
      if(add_blog($user_name, $blog_name, md5($pass), $desc)){
        $subh = "Dodano blog " .$blog_name;
      }
      else{
        $subh = "Wystąpił błąd podczas tworzenia bloga<br>Przepraszamy";
      }
    }
    else{
      $subh = "Wprowadź poprawne dane";
    }
  }
  else{
    $subh = "Stwórz własnego bloga, dziel się swoimi przeżyciami, odkrywaj inspirujące wpisy";
  }
?>
<div id="sub-header">
  <?php echo $subh; ?>
</div>
<div id="main">
  <p id="first">Jesteś tu po raz pierwszy?</p>
  <p id="sub">Załóż blog wypełniając krótki formularz:</p>
  <form method="POST">
    <div class="field">
      <div class="label">Nazwa bloga:</div>
      <input type="text" name="blog_name" placeholder="np. Mój blog">
      <em>Litery i cyfry, od 4 do 30 znaków</em><br>
    </div>
    <div class="field">
      <div class="label">Nazwa użytkownika:</div>
      <input type="text" name="user_name">
      <em>Litery i cyfry, od 4 do 12 znaków</em><br>
    </div>  
    <div class="field">
      <div class="label">Hasło:</div>
      <input type="password" name="pass">
      <em>Minimum 4 znaki</em><br>
    </div> 
    <div class="field">
      <div class="label">Opis:</div>
      <textarea name="desc" rows="4" cols="40"></textarea><br>
    </div> 
    <div class="submit">
      <input type="submit" value="Załóż blog" name="sent">
      <input type="reset" value="Wyczyść formularz">
    </div>
  </form>
</div>
</body>
</html>