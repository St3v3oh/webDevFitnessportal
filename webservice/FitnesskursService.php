<?php

require "Fitnesskurs.php";

class FitnesskursService
{
    const DATABASE_ERROR = "DATABASE_ERROR";
    const NOT_FOUND = "NOT_FOUND";
    const INVALID_INPUT = "INVALID_INPUT";
    const OK = "OK";
    const VERSION_OUTDATED = "VERSION_OUTDATED";

    public function updateKurs($kurs)
    {
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
        $link = new mysqli("localhost", "root", "", "fitnessportal");
        $link->set_charset("utf8");
        $delete_statement = "DELETE FROM fitnesskurse WHERE id = $id";
        $link->query($delete_statement);
        $link->close();
    }

    public function createKurs($kurs)
    {
        if ($kurs->title === "") {
            $result = new CreateKursResult();
            $result->status_code = FitnesskursService::INVALID_INPUT;
            $result->validation_messages["title"] = "Der Titel ist eine Pflichtangabe." .
                " Bitte geben Sie einen Titel an.";
            return $result;
        }
        $link = new mysqli("localhost", "root", "", "fitnessportal");
        $link->set_charset("utf8");
        $insert_statement = "INSERT INTO fitnesskurse SET " .
            "startdate = '$kurs->startdate', " .
            "title = '$kurs->title', " .
            "notes = '$kurs->notes'," .
            "trainer = '$kurs->trainer'" . 
            "duration = '$kurs->duration'" .
            "numberOfPeople = '$kurs->numberOfPeople'" .
            "price = '$kurs->price'" .
            "version = version + 1 " .
            "WHERE id = $kurs->id AND version = $kurs->version";
        "version = 1";
        $link->query($insert_statement);
        $id = $link->insert_id;
        $link->close();
        $result = new CreateKursResult();
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

            $kurse = array();
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
