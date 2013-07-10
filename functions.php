<?php

function createCookie($value){
  echo '<script>
    $(document).ready(function(){
      $.cookie("LastTodoSpreadsheet", "'.$value.'");
    });
  </script>';
}

function reload($url){
  $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
  $host     = $_SERVER['HTTP_HOST'];
  $script   = $_SERVER['SCRIPT_NAME'];
  $params   = $_SERVER['QUERY_STRING'];
  $baseUrl  = $protocol . '://' . $host;
  echo '<script>
    $(document).ready(function(){
      window.location = "'.$baseUrl.'/index.php?id='.$url.'";
    });
  </script>';
}

function displayTaskoContent() {

  if(isset($_GET["id"])){
    $key = $_GET["id"];
    createCookie($_GET["id"]);
  }else if(isset($_COOKIE["LastTodoSpreadsheet"])){
    reload($_COOKIE["LastTodoSpreadsheet"]);
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
    require('inc/homepage.html');
    if (isset($_POST['google-id']) && $_POST['google-id'] != ''){
      reload($_POST['google-id']);
      createCookie($_POST['google-id']);
    }
  }
}

