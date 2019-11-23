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
        $link = new mysqli("localhost", "root", "", "fitnessportal");
        $link->set_charset("utf8");
        $update_statement = "UPDATE kurs SET " .
            "title = '$kurs->title', " .
            "startdate = '$kurs->startdate', " .
            "duration = '$kurs->duration', " .
            "notes = '$kurs->notes', " .
            "price = '$kurs->price', " .
            "trainer = '$kurs->trainer', " .
            "numberOfPeople = '$kurs->numberOfPeople', " .
            "version = version + 1 " .
            "WHERE id = $kurs->id AND version = $kurs->version";
        $link->query($update_statement);
        $affected_rows = $link->affected_rows;
        if ($affected_rows === 0) {
            $select_statement = "SELECT COUNT(*) FROM kurs WHERE id = $kurs->id";
            $result_set = $link->query($select_statement);
            $row = $result_set->fetch_row();
            $count = intval($row[0]);
            $link->close();
            if ($count === 1) {
                return FitnesskursService::VERSION_OUTDATED;
            }
            return FitnesskursService::NOT_FOUND;
        } else {
            $link->close();
        }
    }

    public function deleteKurs($id)
    {
        $link = new mysqli("localhost", "root", "", "fitnessportal");
        $link->set_charset("utf8");
        $delete_statement = "DELETE FROM kurs WHERE id = $id";
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
        $insert_statement = "INSERT INTO kurs SET " .
            "created_date = CURDATE(), " .
            "due_date = '$kurs->due_date', " .
            "title = '$kurs->title', " .
            "notes = '$kurs->notes'";
        "version = 1";
        $link->query($insert_statement);
        $id = $link->insert_id;
        $link->close();
        $result = new CreateKursResult();
        $result->status_code = FitnesskursService::OK;
        $result->id = $id;
        return $result;
    }

    public function readKurs($id) {
    try {
        $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
        $select_statement = "SELECT id, created_date, due_date, version, " .
            "due_date <= CURDATE() as due, author, title, notes " .
            "FROM kurs " .
            "WHERE id = $id";
        $result_set = $connection->query($select_statement);
        if ($result_set->rowCount() === 0) {
            $connection = null;
            return FitnesskursService::NOT_FOUND;
        }
        $kurs = $result_set->fetch_object("Kurs");
        $connection = null;
        return $kurs;
        }
    catch (PDOException $ex) {
        $connection = null;    
        return FitnesskursService::DATABASE_ERROR;
        }
    }

    public function readKurse()
    {
        try {

            $connection = new PDO("mysql:host=localhost;dbname=fitnessportal;charset=UTF8", "root", "");
            $select_statement = "SELECT id, startdate, numberOfPeople, version, " .
                "startdate <= CURDATE() as due, title " .
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
