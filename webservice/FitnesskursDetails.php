<?php

  require "FitnesskursService.php";

  $id = $_REQUEST["id];
  $fitnesskursService = new FitnesskursService();
  $fitnesskurs = $fitnesskursService->readFitnesskurs($id);

?>