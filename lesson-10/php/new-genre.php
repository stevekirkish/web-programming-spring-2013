<?php
require_once("utils/dataconnector.php");
if ($_POST["genre"]) {
	$newgenre = $mysqli->query('insert into genres (genre) values ("'.$_POST["genre"].'")');
}
$mysqli->close();

// By convention, pure php programs have no closing php tag