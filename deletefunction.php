<?php
{
    $pdo=new PDO

    $statement = $pdo->prepare("SELECT * FROM posts") ;
    if($statement->execute()) {
        while($row=$statement->fetch()) {
            echo $row['content'];
            echo "<br>";
        }
    } else    {
        echo "Datenbank-Fehler:";
        echo $statement->errorInfo()[2];
        echo $statement->queryString;
        die();
    }
}
$sql=("DELETE FROM `posts` WHERE id='".($_GET['id'])."'");;


if ($pdo->query($sql) === TRUE) {
    echo "Datei konnte nicht gelöscht werden.";
} else {
    echo "Datei wurde gelöscht.";
}
?>

