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
  $date = date("Y-m-d");
  $time = date("G:i");
  define('DS', DIRECTORY_SEPARATOR);


  if(isset($_POST['sent'])){
    $users_blog_names = explode(PHP_EOL, file_get_contents('users'));
    foreach ($users_blog_names as $users_blog_name) {
      $arr = explode(';', $users_blog_name);
      if($arr[0] != "") $assoc[$arr[0]] = $arr[1];
    }
    $user_name = trim(htmlspecialchars($_POST['user_name']));
    $blog_path = 'data'.DS.$assoc[$user_name];
    if(array_key_exists($user_name, $assoc)){
      $pass = trim($_POST['pass']);
      $info = explode(PHP_EOL, file_get_contents($blog_path.DS.'info'));
      if(md5($pass) === $info[1]){
        $post_date = str_replace('-', '', $_POST['date']);
        $post_time = str_replace(':', '', $_POST['time']);
        $content = trim(htmlspecialchars($_POST['content']));
        $sec = date('s');
        $i = 0;
        do{
          $blog_file_name = $post_date.$post_time.$sec.str_pad($i, 2, 0, STR_PAD_LEFT);
          $i++;
        }
        while(file_exists($blog_path.DS.$blog_file_name));

        # OBSŁUGA PLIKÓW
        $uploaded = array();
        foreach ($_FILES as $form_name => $file_data) {
          if($file_data['error'] === 0 && strpos($file_data['type'], 'application')){
            $save_path = $blog_path.DS.$blog_file_name.substr($form_name, -1).'.'.pathinfo($file_data['name'], PATHINFO_EXTENSION);
            if(move_uploaded_file($file_data['tmp_name'],$save_path)){
              $uploaded[substr($form_name, -1)] = $save_path;
            }
            else{
              echo "Błąd wgrywania pliku";
            }
          }
        }

        
        $entry = implode(PHP_EOL, array($date,$time,$content));
        foreach ($uploaded as $up_index => $up_path) {
          $entry .= PHP_EOL.$up_path;
        }
        file_put_contents($blog_path.DS.$blog_file_name, $entry, LOCK_EX);
        $subh = "Dodawanie wpisu przebiegło pomyślnie";
      }
      else{
        $subh = "Niepoprawne hasło";
      }
    }
    else{
      $subh = "Użytkownik nie istnieje";
    }
    
  }
  else{
    $subh = "Dodaj nowy wpis";
  }
?>
<div id="sub-header">
  <?php echo $subh; ?>
</div>
<div id="main">
  <p id="first"></p>
  <form method="POST" enctype="multipart/form-data">
    <div class="field">
      <div class="label">Nazwa użytkownika:</div>
      <input type="text" name="user_name"><br>
    </div>  
    <div class="field">
      <div class="label">Hasło:</div>
      <input type="password" name="pass"><br>
    </div> 
    <div class="field">
      <div class="label">Wpis:</div>
      <textarea name="content" rows="10" cols="55"></textarea><br>
    </div> 
    <div class="field">
      <div class="label">Data:</div>
      <input type="text" name="date" value="<?php echo $date ?>" readonly><br>
    </div> 
    <div class="field">
      <div class="label">Godzina:</div>
      <input type="text" name="time" value="<?php echo $time ?>" readonly><br>
    </div> 
    <div class="field">
      <div class="label">Załącznik 1:</div>
      <input type="file" name="file1"><br>
    </div> 
    <div class="field">
      <div class="label">Załącznik 2:</div>
      <input type="file" name="file2"><br>
    </div> 
    <div class="field">
      <div class="label">Załącznik 3:</div>
      <input type="file" name="file3"><br>
    </div> 
    <div class="submit">
      <input type="submit" value="Dodaj wpis" name="sent">
      <input type="reset" value="Wyczyść formularz">
    </div>
  </form>
</div>
</body>
</html>