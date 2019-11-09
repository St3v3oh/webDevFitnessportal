<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "FitnesskursService.php";

$config = [
    "settings" => [ 
      "displayErrorDetails" => true,
    ],
    "foundHandler" => function() {
      return new \Slim\Handlers\Strategies\RequestResponseArgs();
    }
];

$app = new \Slim\App($config);
$app->add(new IgnoreCaseMiddleware());
$app->add(new DenyCachingMiddleware());

$app->get(
  "/fitnesskurse",
  function ($request, $response) {
	  $fitnesskurs_service = new FitnesskursService();
	  $fitnesskurse = $fitnesskurs_service->readKurse();
	  
	  foreach ($fitnesskurse as $fitnesskurs) {
		  $fitnesskurs->url = "/fitnessportal/webservice/fitnesskurs/$fitnesskurs->id";
          unset($fitnesskurs->id);
      }
      return $response->withJson($fitnesskurse);
  });
 
$app->get(
  "/fitnesskurse/{id}",
  function ($request, $response, $id) {
	$fitnesskurs_service = new FitnesskursService();
    $fitnesskurs = $fitnesskurs_service->readKurs($id);
    
	if ($fitnesskurs === FitnesskursService::DATABASE_ERROR) {
        $response = $response->withstatus(500);
    } else if ($fitnesskurs === FitnesskursService::NOT_FOUND) {
        $response = $response->withStatus(404);
    } else {
        unset($fitnesskurs->id);
        $response = $response->withHeader("Etag", $fitnesskurs->version);
        unset($fitnesskurs->version);
        $response = $response->withJson($fitnesskurs);
    }
	return $response;
  });

$app->post(
  "/fitnesskurse/",
  function ($request, $response) {
	$fitnesskurs = new Fitnesskurs();
	$fitnesskurs->title = $request->getPardesBodyParam("title");
	
	$fitnesskurs_service = new FitnesskursService();
	$result = $fitnesskurs_service->createKurs($fitnesskurs);
	
	if ($result->status_code === FitnesskursService::INVALID_INPUT){
		$response = $response->withStatus(400);
		return $response->withJson($result->validation_messages);
	}
	
	$response = $response->withStatus(201);
	$response = $response->withHeader("Location", "/webDevFitnessportal/webservice/Fitnesskurs/$result->id");
	return $response;
  });

$app->delete(
  "/fitnesskurse/{id}",
  function ($request, $response, $id) {
	$fitnesskurs_service = new FitnesskursService();
	$fitnesskurs_service->deleteKurs($id);	
  });
  
$app->put(
  "/fitnesskurse/{id}",
  function ($request, $response, $id) {
	$fitnesskurs = new Fitnesskurs();
	$fitnesskurs->id = $id;
	$fitnesskurs->title = $request->getPardesBodyParam("title");
	$fitnesskurs->trainer = $request->getPardesBodyParam("trainer");
	$fitnesskurs->numberOfPeople = $request->getPardesBodyParam("numberOfPeople");
	$fitnesskurs->version = $request->getHeaderLine("If-Match");
	
	$fitnesskurs_service = new FitnesskursService();
	$result = $fitnesskurs_service->updateKurs($fitnesskurs);
	if ($result === FitnesskursService::VERSION_OUTDATED) {
		$response = $response->withStatus(412);
		return $response;
	} elseif ($result === TodoService::NOT_FOUND) {
        $response = $response-withStatus(404);
        return $response;
    }
    
    if ($fitnesskurs->title == "") {
        $validation_messages = array();
        $validation_messages["title"] = "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel an.";
        $response = $response->withStatus(400);
        return $response->withJson($validation_messages);
    }
  });
  
$app->run();
?>