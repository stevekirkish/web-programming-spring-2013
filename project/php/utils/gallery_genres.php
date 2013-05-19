<?php require_once('../../Connections/healdsburggalleries.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_healdsburggalleries, $healdsburggalleries);
$query_Gallery_Genres = "SELECT * FROM genres ORDER BY idgenres ASC";
$Gallery_Genres = mysql_query($query_Gallery_Genres, $healdsburggalleries) or die(mysql_error());
$row_Gallery_Genres = mysql_fetch_assoc($Gallery_Genres);
$totalRows_Gallery_Genres = mysql_num_rows($Gallery_Genres);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gallery Genre List</title>
</head>

<body>
<h2>Gallery Genre List</h2>
<?php do { ?>
  <p><?php echo $row_Gallery_Genres['idgenres']; ?>: <?php echo $row_Gallery_Genres['genre']; ?></p>
  <?php } while ($row_Gallery_Genres = mysql_fetch_assoc($Gallery_Genres)); ?>

</body>
</html>
<?php
mysql_free_result($Gallery_Genres);
?>
