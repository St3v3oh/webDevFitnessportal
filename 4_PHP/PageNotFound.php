<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Todo-Liste</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css"/>  
    <style type="text/css">
      #message {
        display:block; 
        margin:5px; 
        text-align:center;
      }
    </style>
  </head>
  <body>
    <div id="header">      
      <h1>Seite nicht gefunden</h1>
      <a id="home" href="./index.php"><img src="images/home.png" alt=""/></a>
    </div>
    <div>
      <ul>
        <li><a href="TodoForm.php">Neues Todo</a></li>
      </ul>
      <form id="logoff_form" action="..." method="post">
        <span id="username">Marc</span>
        <input type="image" name="logoff" src="images/logoff.png" alt="Abmelden" id="logoff"/>
      </form>
      <img src="images/blank.png" alt=""/>
    </div>
    <div>
      <span id="message">Uups, die Seite '<?php echo urldecode($_SERVER["REQUEST_URI"]); ?>' konnte leider nicht gefunden werden.</span>
    </div>
  </body>
</html>