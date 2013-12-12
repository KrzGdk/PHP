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

  if(!strpos($_GET['blog'],DS) && !strpos($_GET['id'],DS)){
    if(file_exists('data'.DS.$_GET['blog'].DS.$_GET['id'])){
      if(isset($_POST['sent'])){
        $nickname = trim(htmlspecialchars($_POST['nickname']));
        $content = trim(htmlspecialchars($_POST['content']));
        $types = array("Pozytywny","Negatywny","Neutralny");
        if(in_array($_POST['type'], $types) && validate($nickname) && !empty($content)){
          $type = $_POST['type'];
          $blog = $_POST['blog'];
          $id = $_POST['id'];
          if(add_comment($blog,$id,$nickname,$type,$content)){
            $subh = "Dodawanie komentarza przebiegło pomyślnie<br><a href='blog.php?nazwa=$blog'>Wróć do bloga</a>";
          }
          else{
            $subh = "Wystąpił błąd podczas zapisu komentarza";
          }
        }
        else{
          $subh = "Podano nieprawidłowe dane";
        }
      }
      else{
        $subh = "Dodaj komentarz do wpisu z blogu ".$_GET['blog'];
      }
?>


<div id="sub-header">
  <?php echo $subh; ?>
</div>
<div id="main">
  <p id="first"></p>
  <form method="POST">
    <div class="field">
      <div class="label">Pseudonim:</div>
      <input type="text" name="nickname">
      <em>Litery i cyfry, od 4 do 30 znaków</em><br>
    </div>  
    <div class="field">
      <div class="label">Rodzaj komentarza:</div>
      <select name="type">
        <option value="Pozytywny">Pozytywny</option>
        <option value="Negatywny">Negatywny</option>
        <option value="Neutralny">Neutralny</option>
      </select><br>
    </div> 
    <div class="field">
      <div class="label">Komentarz:</div>
      <textarea name="content" rows="10" cols="55"></textarea><br>
    </div> 
    <div class="submit">
      <input type="hidden" name="id" value='<?php echo $_GET['id']; ?>'>
      <input type="hidden" name="blog" value='<?php echo $_GET['blog']; ?>'>
      <input type="submit" value="Dodaj komentarz" name="sent">
      <input type="reset" value="Wyczyść formularz">
    </div>
  </form>
</div>
<div id="sub-header">
<?php 
    } else{
      echo "Nazwa blogu lub ID wpisu jest nieprawidłowe";
    }
  
  } else{
    echo "Wpis, do którego chcesz dodać komentarz, nie istnieje";
  }
?>
</div>
</body>
</html>