<?php
  require "Fitnesskurs.php";
  require "CreateFitnesskursResult.php";
  
  class FitnesskursService {
	const DATABASE_ERROR = "DATABASE_ERROR";
	const NOT_FOUND = "NOT FOUND";
	const INVALID_INPUT = "INVALID_INPUT";
	const OK = "OK";
	const VERSION_OUTDATED = "VERSION_OUTDATED";
	
	public function updateFitnesskurs($fitnesskurs) {
		$connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8","root","");
		$update_statement = "UDPATE INTO fitnesskurse SET ".
							"startdate = CURDATE(), ".
							"duration = '$fitnesskurs->duration', ".
							"trainer = '$fitnesskurs->trainer', ".
							"price = '$fitnesskurs->price', ".
							"numberOfPeople = '$fitnesskurs->numberOfPeople', ".
							"version = version + 1 ";
							"WHERE id = $fitnesskurs->id AND version = $fitnesskurs->version";
		$affectes_rows = $connection->exec($update_statement);
		$connection = null;
		if ($affectes_rows === 0) {
			return FitnesskursService::VERSION_OUTDATED;
		}
	}
	
	public function deleteFitnesskurs($id) {
		$connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8","root","");
		$delete_statement = "DELETE FROM fitnesskurse WHERE id = $id";
		$connection->query($delete_statement);
		$connection = null;
	}
	  
    public function readFitnesskurs($id) {
		$connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8","root","");
		$select_statement = "SELECT id, title, notes, startdate, duration, trainer, price, numberOfPeople, version".
							"FROM fitnesskurse".
							"WHERE id = $id";
		$result_set = $connection->query($select_statement);
		$fitnesskurs = $result_set->fetchObject("Fitnesskurs");
		$connection = null;
		return $fitnesskurs;
    }
	
	public function readFitnesskurs() {
		$connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8","root","");
		$select_statement = "SELECT id, title, notes, startdate, duration, trainer, price, numberOfPeople, version".
							"FROM fitnesskurse".
							"WHERE id = $id";
		$result_set = $connection->query($select_statement);
		$fitnesskurs = $result_set->fetchAll(PDO::FETCH_CLASS, "Fitnesskurs");
		$connection = null;
		return $fitnesskurs;
	}
	
	public function createFitnesskurs($fitnesskurs) {
		if ($todo->title === ""){
			$result = new CreateFitnesskursResult();
			$result->status_code = FitnesskursService::INVALID_INPUT;
			$result->validation_messages["title"] = 
			  "Der Titel ist eine Pflichtangabe. Bitte geben Sie einen Titel ein.";
			return result;
		}		
		$connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8","root","");
		$insert_statement = "INSERT INTO fitnesskurse SET ".
							"startdate = CURDATE(), ".
							"duration = '$fitnesskurs->duration', ".
							"trainer = '$fitnesskurs->trainer', ".
							"price = '$fitnesskurs->price', ".
							"numberOfPeople = '$fitnesskurs->numberOfPeople', ".
							"version = 1 ";
							
		$connection->query($select_statement);
		$id = $connection->lastInsertId();
		$connection = null;
		$result = new CreateFitnesskursResult();
		$result->status_code = FitnesskursService::OK;
		$result->id = $id;
		return $result;
	}
  }
?>