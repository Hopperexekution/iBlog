<?php

class Album
{
    public static function create($data)
    {
        global $dbh;

        $stmt = $dbh->prepare("INSERT INTO album (artist, album, year)
            VALUES (:artist, :album, :year)");

        $stmt->execute($data);
    }

    public static function read($id)
    {
        global $dbh;

        $stmt = $dbh->prepare("SELECT * FROM album WHERE id = ?)");

        $stmt->execute(array($id));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data)
    {
        global $dbh;

        $stmt = $dbh->prepare("UPDATE album
            SET artist = :artist, album = :album, year = :year)
            WHERE ID = :id");

        $data['id'] = $id;

        $stmt->execute($data);
    }

    public static function delete($id)
    {
        global $dbh;

        $stmt = $dbh->prepare("DELETE FROM album WHERE id = ?");

        $stmt->execute(array($id));
    }

    public static function getAll()
    {
        global $dbh;

        return $dbh->query("SELECT * FROM album")->fetchAll(PDO::FETCH_ASSOC);
    }
}
