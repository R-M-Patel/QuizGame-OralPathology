<?php

require("../classes/dbutils.php");

/* convert sql query results to json */
$sql = $_GET["sql"];

$db = new DbUtilities;

$dataArray = $db->getDataset($sql);

echo json_encode($dataArray);

?>
