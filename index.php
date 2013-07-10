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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>

  </head>
  <body>

    <header>
      <h1>Task<span>o</span></h1>
    </header>
    <div class="container">
      <?php require('functions.php'); ?>
      <?php getTodoContent(); ?>
    </div>
    <footer>
      <a href="https://github.com/Yago31/taskr/">Github</a> - <a href="https://twitter.com/share?url=http://tasko.me" target="_blank">Tweet it !</a> - made by <a href="http://yago.io">Yago</a>
    </footer>

    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
