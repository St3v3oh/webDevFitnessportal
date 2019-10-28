<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Kurs-Liste</title>
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
      <h1>Kurs nicht gefunden</h1>
      <a id="home" href="./index.php"><img src="images/home.png" alt=""/></a>
    </div>
    <div>
      <ul>
        <li><a href="KursForm.php">Neuer Kurs</a></li>
      </ul>
      <form id="logoff_form" action="..." method="post">
        <span id="username">Stefan</span>
        <input type="image" name="logoff" src="images/logoff.png" alt="Abmelden" id="logoff"/>
      </form>
      <img src="images/blank.png" alt=""/>
    </div>
    <div>
      <span id="message">Das Kurs mit der ID '<?php echo $_REQUEST["id"]; ?>' konnte leider nicht gefunden werden.</span>
    </div>
  </body>
</html>