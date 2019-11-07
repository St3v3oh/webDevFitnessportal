<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "FitnesskursService.php";


$config = [
  'settings' => [
    'displayErrorDetails' => true,
  ],
  'foundHandler' => function() {
	return new \Slim\Handlers\Strategies\RequestResponseArgs();
  }
];

$app = new \Slim\App($config);
$app->add(new DenyCachingMiddleware());

$app->get(
  "/fitnesskurse",
  function ($request, $response) {
	  $fitnesskurs_service = new FitnesskursService();
	  $fitnesskurse = $fitnesskurs_service->readFitnesskurs();
	  
	  foreach ($fitnesskurse as $fitnesskurs) {
		  $fitnesskurs->url = "/Github/webDevFitnessportal/webservice/Fitnesskurs/$fitnesskurs->id";
		  unset($fitnesskurs->id);
  });
 
$app->get(
  "/fitnesskurse/{id}";
  function ($request, $response, $id) {
	$fitnesskurs_service = new FitnesskursService();
	$fitnesskurs = $fitnesskurs_service->readFitnesskurs($id);
	
	unset($fitnesskurs->id);
	$response = $response->withHeader("Etag", $fitnesskurs->version);
	unset($fitnesskurs->version);
	$response = $response->withJson($fitnesskurs);
	return $response;
  });

$app->post(
  "/fitnesskurse/";
  function ($request, $response) {
	$fitnesskurs = new Fitnesskurs();
	$fitnesskurs->title = $request->getPardesBodyParam("title");
	
	$fitnesskurs_service = new FitnesskursService();
	$result = $fitnesskurs_service->createFitnesskurs($Fitnesskurs);
	
	if ($result->status_code ==== FitnesskursService::INVALID_INPUT){
		$response = $response->withStatus(400);
		$response = $response->withJson($result->validation_messages);
		return $response;
	}
	
	$response = $response->withStatus(201);
	$response = $response->withHeader("Location", "/Github/webDevFitnessportal/webservice/Fitnesskurs/$result->id");
	return $response;
  });

$app->delete(
  "/fitnesskurse/{id}";
  function ($request, $response, $id) {
	$fitnesskurs_service = new FitnesskursService();
	$fitnesskurs_service->deleteFitnesskurs($id);	
  });
  
$app->put(
  "/fitnesskurse/{id}";
  function ($request, $response, $id) {
	$fitnesskurs = new Fitnesskurs();
	$fitnesskurs->id = $id;
	$fitnesskurs->title = $request->getPardesBodyParam("title");
	$fitnesskurs->trainer = $request->getPardesBodyParam("trainer");
	$fitnesskurs->numberOfPeople = $request->getPardesBodyParam("numberOfPeople");
	$fitnesskurs->version = $request->getHeaderLine("If-Match");
	
	$fitnesskurs_service = new FitnesskursService();
	$result = $fitnesskurs_service->updateFitnesskurs($fitnesskurs);
	if ($result === FitnesskursService::VERSION_OUTDATED) {
		$response = $response->withStatus(412);
		return $response;
	}
  });
  
$app->run();
?>