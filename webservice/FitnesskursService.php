<?php

require "Fitnesskurs.php";
require "CreateFitnesskursResult.php";
require "UpdateFitnesskursResult.php";

class FitnesskursService
{
    const DATABASE_ERROR = "DATABASE_ERROR";
    const NOT_FOUND = "NOT_FOUND";
    const INVALID_INPUT = "INVALID_INPUT";
    const OK = "OK";
    const VERSION_OUTDATED = "VERSION_OUTDATED";

    public function updateKurs($kurs)
    {
        $result = new UpdateFitnesskursResult();
        if ($kurs->title === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["title"] = "Der Titel ist eine Pflichtangabe." .
                " Bitte geben Sie einen Titel an.";
            return $result;
        } else if ($kurs->trainer === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["trainer"] = "Der Trainer ist eine Pflichtangabe. Bitte geben Sie einen Trainer an.";
            return $result;
        } else if ($kurs->price === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["price"] = "Der Preis ist eine Pflichtangabe. Bitte geben Sie einen Preis an.";
            return $result;
        } else if ($kurs->startdate === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["startdate"] = "Der Startzeitpunkt ist eine Pflichtangabe. Bitte geben Sie einen Startzeitpunkt an.";
            return $result;
        } else if ($kurs->duration === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["duration"] = "Die Dauer ist eine Pflichtangabe. Bitte geben Sie eine Dauer an.";
            return $result;
        }

        $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
        $update_statement = "UPDATE fitnesskurse SET " .
            "title = '$kurs->title', " .
            "startdate = '$kurs->startdate', " .
            "duration = '$kurs->duration', " .
            "notes = '$kurs->notes', " .
            "price = '$kurs->price', " .
            "trainer = '$kurs->trainer', " .
            "numberOfPeople = '$kurs->numberOfPeople', " .
            "version = version + 1 " .
            "WHERE id = $kurs->id AND version = $kurs->version";
        $affected_rows = $connection->exec($update_statement);

        if ($affected_rows === 0) {
            $select_statement = "SELECT COUNT(*) FROM fitnesskurse WHERE id = $kurs->id";
            $result_set = $connection->query($select_statement);
            $row = $result_set->fetch();
            $count = intval($row[0]);
            $connection = null;
            if ($count === 1) {
                return FitnesskursService::VERSION_OUTDATED;
            }
            return FitnesskursService::NOT_FOUND;
        } else {
            $connection = null;
        }
    }

    public function deleteKurs($id)
    {
        $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
        $delete_statement = "DELETE FROM fitnesskurse WHERE id = $id";
        $connection->query($delete_statement);
        $connection = null;
    }

    public function createKurs($kurs)
    {
        $result = new CreateFitnesskursResult();
        if ($kurs->title === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["title"] = "Der Titel ist eine Pflichtangabe." .
                " Bitte geben Sie einen Titel an.";
            return $result;
        } else if ($kurs->trainer === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["trainer"] = "Der Trainer ist eine Pflichtangabe. Bitte geben Sie einen Trainer an.";
            return $result;
        } else if ($kurs->price === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["price"] = "Der Preis ist eine Pflichtangabe. Bitte geben Sie einen Preis an.";
            return $result;
        } else if ($kurs->startdate === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["startdate"] = "Der Startzeitpunkt ist eine Pflichtangabe. Bitte geben Sie einen Startzeitpunkt an.";
            return $result;
        } else if ($kurs->duration === "") {
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["duration"] = "Die Dauer ist eine Pflichtangabe. Bitte geben Sie eine Dauer an.";
            return $result;
        }
        $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
        $insert_statement = "INSERT INTO fitnesskurse SET " .
            "startdate = '$kurs->startdate', " .
            "title = '$kurs->title', " .
            "notes = '$kurs->notes'," .
            "trainer = '$kurs->trainer', " .
            "duration = '$kurs->duration', " .
            "numberOfPeople = '$kurs->numberOfPeople', " .
            "price = '$kurs->price', ".
            "version = 1";
        $connection->query($insert_statement);
        $id = $connection->lastInsertId();
        $connection = null;
        $result = new CreateFitnesskursResult;
        $result->status_code = FitnesskursService::OK;
        $result->id = $id;
        return $result;
    }

    public function readKurs($id)
    {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
            $select_statement = "SELECT id, startdate, duration, version, " .
                "title, notes, trainer, price, numberOfPeople " .
                "FROM fitnesskurse " .
                "WHERE id = $id";

            $result_set = $connection->query($select_statement);

            if ($result_set->rowCount() === 0) {
                $connection = null;
                return FitnesskursService::NOT_FOUND;
            }
            $kurs = $result_set->fetchObject("Fitnesskurs");
            $connection = null;
            return $kurs;
        } catch (PDOException $ex) {
            $connection = null;
            error_log("Fehler beim Datenbankzugriff: " . $ex->getMessage());
            return FitnesskursService::DATABASE_ERROR;
        }
    }

    public function readKurse()
    {
        try {
            $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
            $select_statement = "SELECT id, startdate, trainer, version, numberOfPeople, " .
                "startdate <= CURDATE() as due, title, duration, price, notes " .
                "FROM fitnesskurse " .
                "WHERE startdate <= CURDATE() " .
                "ORDER BY startdate ASC";
            $result_set = $connection->query($select_statement);

            // error_log($result_set);
            if ($result_set->rowCount() == 0) {
                $connection = null;
                return FitnesskursService::NOT_FOUND;
            }

            $kurse = $result_set->fetchAll(PDO::FETCH_CLASS, "Fitnesskurs");

            $connection = null;
            return $kurse;
        } catch (PDOException $ex) {
            $connection = null;
            error_log("Fehler beim Datenbankzugriff: " . $ex->getMessage());
            return FitnesskursService::DATABASE_ERROR;
        }
    }
}
