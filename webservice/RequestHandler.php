<?php
require "vendor\autoload.php";
require "IgnoreCaseMiddleware.php";
require "DenyCachingMiddleware.php";
require "FitnesskursService.php";

$config = [
    "settings" => [
        "displayErrorDetails" => true,
    ],
    "foundHandler" => function () {
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

        if ($fitnesskurse === FitnesskursService::DATABASE_ERROR) {
            $response = $response->withStatus(500);
            return $response;
        }
        if ($fitnesskurse === FitnesskursService::NOT_FOUND) {
            $response = $response->withStatus(500);
            return $response;
        }

        foreach ($fitnesskurse as $fitnesskurs) {
            $fitnesskurs->startdate = date("Y-m-d\TH:i:s", strtotime($fitnesskurs->startdate));
            $fitnesskurs->url = "/fitnessportal/webservice/fitnesskurse/$fitnesskurs->id";
            unset($fitnesskurs->id);
        }
        return $response->withJson($fitnesskurse);
    }
);

$app->get(
    "/fitnesskurse/{id}",
    function ($request, $response, $id) {
        $fitnesskurs_service = new FitnesskursService();
        $fitnesskurs = $fitnesskurs_service->readKurs($id);

        if ($fitnesskurs === FitnesskursService::DATABASE_ERROR) {
            return $response->withstatus(500);
        } else if ($fitnesskurs === FitnesskursService::NOT_FOUND) {
            return $response->withStatus(500);
        } else {
            $fitnesskurs->startdate = date("Y-m-d\TH:i:s", strtotime($fitnesskurs->startdate));
            unset($fitnesskurs->id);
            $response = $response->withHeader("Etag", $fitnesskurs->version);
            unset($fitnesskurs->version);
            return $response->withJson($fitnesskurs);
        }
    }
);

$app->post(
    "/fitnesskurse",
    function ($request, $response) {
        $fitnesskurs = new Fitnesskurs();
        $fitnesskurs->title = $request->getParsedBodyParam("title");
        $fitnesskurs->trainer = $request->getParsedBodyParam("trainer");
        $fitnesskurs->numberOfPeople = $request->getParsedBodyParam("numberOfPeople");
        $fitnesskurs->price = $request->getParsedBodyParam("price");
        $fitnesskurs->notes = $request->getParsedBodyParam("notes");
        $fitnesskurs->startdate = $request->getParsedBodyParam("startdate");
        $fitnesskurs->duration = $request->getParsedBodyParam("duration");

        $fitnesskurs_service = new FitnesskursService();
        $result = $fitnesskurs_service->createKurs($fitnesskurs);

        if ($result->status_code === FitnesskursService::INVALID_INPUT) {
            $response = $response->withStatus(400);
            return $response->withJson($result->validation_messages);
        }

        $response = $response->withStatus(201);
        $response = $response->withHeader("Location", "/fitnessportal/webservice/fitnesskurs/$result->id");
        return $response;
    }
);

$app->delete(
    "/fitnesskurse/{id}",
    function ($request, $response, $id) {
        $fitnesskurs_service = new FitnesskursService();
        $fitnesskurs_service->deleteKurs($id);
    }
);

$app->put(
    "/fitnesskurse/{id}",
    function ($request, $response, $id) {
        $fitnesskurs = new Fitnesskurs();
        $fitnesskurs->id = $id;
        $fitnesskurs->title = $request->getParsedBodyParam("title");
        $fitnesskurs->trainer = $request->getParsedBodyParam("trainer");
        $fitnesskurs->numberOfPeople = $request->getParsedBodyParam("numberOfPeople");
        $fitnesskurs->price = $request->getParsedBodyParam("price");
        $fitnesskurs->notes = $request->getParsedBodyParam("notes");
        $fitnesskurs->startdate = $request->getParsedBodyParam("startdate");
        $fitnesskurs->duration = $request->getParsedBodyParam("duration");
        $fitnesskurs->version = $request->getHeaderLine("If-Match");


        $fitnesskurs_service = new FitnesskursService();
        $result = $fitnesskurs_service->updateKurs($fitnesskurs);
        if ($result === FitnesskursService::VERSION_OUTDATED) {
            $response = $response->withStatus(412);
            return $response;
        }
        if ($result === FitnesskursService::NOT_FOUND) {
            $response = $response->withStatus(404);
            return $response;
        }
        if ($result->status_code === FitnesskursService::INVALID_INPUT) {
            $response = $response->withStatus(400);
            $response = $response->withJson($result->validation_messages);
            //$response = $response->withJson($result->missing_field_messages);	
            return $response;
        }
    }
);

$app->run();
