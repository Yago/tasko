<?php

function getTodoData() {

  if(isset($_GET["id"])){
    $key = $_GET["id"];
  }else if(isset($_COOKIE["LastTodoSpreadsheet"])){
    header('Location: /index.php?id='.$_COOKIE["LastTodoSpreadsheet"]);
  }

  $index = 0;

  if (isset($key)){
    $spreadsheet = sprintf('https://spreadsheets.google.com/feeds/list/%s/1/public/values?alt=json', $key);
    $spreadsheets = json_decode(file_get_contents($spreadsheet), true);

    foreach($spreadsheets['feed']['entry'] as $row) {
      $data = array(
        'task' => $row['gsx$task']['$t']
      );
      $index = $index + 1;
      echo '<div class="task-row"><input id="task-'.$index.'" class="todo-checkbox" name="todo[]" value="agree" type="checkbox"><label for="task-'.$index.'"><span class="check"><img src="img/check.svg" onerror="this.onerror=null; this.src=\'img/check.png\'" /></span><span class="task-content">'.$data['task'].'</span></label></div>';
    }
    echo '<button id="cookie-rmv">Change TODO</button>';
  }else {
    echo '
      <form method="post" class="initer">
        <label for="google-id">Google Spreadsheets ID</label> <input type="text" name="google-id" id="google-id"><br />
        <input type="submit" value="Load TODO">
      </form>
    ';
    if (isset($_POST['google-id']) && $_POST['google-id'] != ''){
      header('Location: /index.php?id='.$_POST['google-id']);
      setcookie("LastTodoSpreadsheet", $_POST['google-id']);
    }
  }

}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>TASKR</title>
    <meta name="description" content="">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/todo.css">

    <!--[if lt IE 9]>
      <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
    <![endif]-->
  </head>
  <body>

    <header>
      <h1>Task<span>r</span></h1>
    </header>
    <div class="container">
      <?php getTodoData(); ?>
    </div>
    <footer>
      made by <a href="http://yago.io">Yago</a>
    </footer>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
