<?php

  $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
  $host     = $_SERVER['HTTP_HOST'];
  $script   = $_SERVER['SCRIPT_NAME'];
  $params   = $_SERVER['QUERY_STRING'];
  $baseUrl  = $protocol . '://' . $host;

function getTodoData() {

  if(isset($_GET["id"])){
    $key = $_GET["id"];
    setcookie("LastTodoSpreadsheet", $_GET["id"]);
  }else if(isset($_COOKIE["LastTodoSpreadsheet"])){
    //header('Location: '.$baseUrl.'/index.php?id='.$_COOKIE["LastTodoSpreadsheet"]);
    echo '<script>window.location = "index.php";</script>';
  }

  $index = 0;

  if (isset($key)){
    $spreadsheet = sprintf('https://spreadsheets.google.com/feeds/list/%s/1/public/values?alt=json', $key);
    $spreadsheets = json_decode(file_get_contents($spreadsheet), true);

    if (isset($spreadsheets['feed']['entry'][1]['gsx$task']['$t'])){
      foreach($spreadsheets['feed']['entry'] as $row) {
        $data = array(
          'task' => $row['gsx$task']['$t']
        );
        $index = $index + 1;
        echo '<div class="task-row"><input id="task-'.$index.'" class="todo-checkbox" name="todo[]" value="agree" type="checkbox"><label for="task-'.$index.'"><span class="check"><img src="img/check.svg" onerror="this.onerror=null; this.src=\'img/check.png\'" /></span><span class="task-content">'.$data['task'].'</span></label></div>';
      }
      echo '<button class="cookie-rmv">Change list</button>';
    }else {
      echo '<p class="description">The spreadsheet format is wrong, <a href="#" class="cookie-rmv">try again</a> or read the <a href="https://github.com/Yago31/taskr/">doc</a>.</p>';
    }
  }else {
    echo '
      <p class="description">
        <strong>Tasko</strong> turn a simple <strong>Google Spreadsheet</strong> to a light and simple to-do list. You can reuse and share your list as you want!
      </p>
      <p class="description">
        You only have to create one column and name it <strong>task</strong>. Publish it and set that anyone with a link can see the spreadsheet. Then get the ID and <strong>paste it into Tasko</strong>. Read the <a href="https://github.com/Yago31/taskr/">code</a> for more informations.
      </p>
      <img class="google-spreasheet" src="img/spreadsheet.png" alt="google spreasheet example" />
    ';
    echo '<hr />';
    echo '
      <form method="post" class="initer">
        <label for="google-id">Google Spreadsheets <span>ID</span></label> <input type="text" name="google-id" id="google-id"><br />
        <input type="submit" value="Load list">
      </form>
    ';
    if (isset($_POST['google-id']) && $_POST['google-id'] != ''){
      //header('Location: '.$baseUrl.'/index.php?id='.$_POST['google-id']);
      setcookie("LastTodoSpreadsheet", $_POST['google-id']);
      echo '<script>window.location = "index.php";</script>';
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
    <title>TASKO</title>
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
      <h1>Task<span>o</span></h1>
    </header>
    <div class="container">
      <?php getTodoData(); ?>
    </div>
    <footer>
      <a href="https://github.com/Yago31/taskr/">Github</a> - <a href="https://twitter.com/share?url=http://tasko.me" target="_blank">Tweet it !</a> - made by <a href="http://yago.io">Yago</a>
    </footer>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
