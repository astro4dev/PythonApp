<!DOCTYPE html>
<html lang = "en-UK">
<!----------------------------------------------------------------------------->
  <head>

  <meta charset = "UTF-8">

  <title>Retrieve Data</title>

  <img src="IAU.jpg" alt="IAU header picture" width="1210"/img>

  <style type = "text/css">
    body{background-color: lightgray};
    table, th, td {border: 1px white};
    h1, h3, p, form{color: white};
  </style>

  <h1>OAD Projects</h1>

  </head>
<!----------------------------------------------------------------------------->
<body>

  <form action="Retrieve.php" method="POST">

  <h3> Query past funded projects </h3>

  <p align="center">Select a field and input a search value:</p>
<!----------------------------------------------------------------------------->
<div align="center">

<select name="field" >
  <option value=" "> </option>
  <option value="AllOpt">Everything</option>
  <option value="TtlOpt">Title</option>
  <option value="TFOpt">Task Force</option>
  <option value="CtryOpt">Country</option>
  <option value="YrOpt">Year</option>
  <option value="KeyOpt">Keyword</option>

</select> <br><br>
<!----------------------------------------------------------------------------->
Project Name <br>
<input type="text" name="TtlValue"> <br><br>

Task Force (1,2,3) <br>
<input type="number" min="1" max="3" name="TFValue"> <br><br>

Country <br>
<input type="text" name="CtryValue"> <br><br>

Year implemented <br>
<input type="year" name="YrValue"> <br><br>

Keywords <br>
<input type="text" name="KeyValue"> <br><br>

<input type="submit"> <br><br>
<!----------------------------------------------------------------------------->
</div>
</form>
<!----------------------------------------------------------------------------->
<?php
  //<!--Building a normal MySQL connection-->
  $con = new PDO('mysql:host=dbint.astro4dev.org;dbname=melosbdb',"melo","R@!nf0r3st");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//----------------------------------------------------------------------------

  if($_POST['field']=='TtOpt'){$i = 0;}
    elseif ($_POST['field']=='TFOpt') {$i = 1;}
    elseif ($_POST['field']=='CtryOpt') {$i = 2;}
    elseif ($_POST['field']=='YrOpt') {$i = 3;}
    elseif ($_POST['field']=='KeyOpt') {$i = 4;}
    elseif ($_POST['field']=='AllOpt') {$j = 5;}

	$fieldInputs = array("TtlValue","TFValue", "CtryValue", "YrValue", "KeyValue", "Everything");
	$fieldSQL = array("Title", "Task_Force", "Country","Year_Implemented", "Proposal_Summary", "NULL");

  //----------------------------------------------------------------------------
  //<!--Determine your query-->
	$init_data = $_POST[$fieldInputs[$i]];

  if ($j==5){$query = "SELECT * FROM PastFundedProjects" ;}
    elseif ($i<5){$query = "SELECT * FROM PastFundedProjects WHERE $fieldSQL[$i]='$init_data'";}



  //<!--Print the table tag before extracting any results-->
  print "<table> ";

 	//<!--First pass to extract column/field names-->
 	$result = $con->query($query);
 	//return only the first row (we only need field names)
 	$row = $result->fetch(PDO::FETCH_ASSOC);

 	//<!--Print the field names as table headers-->
 	print "<tr> ";
 	foreach ($row as $field => $value) {
   	print "<th>$field</th> ";
 	}
 	print "</tr> ";

 	//<!--Make a second query-->
 	//second query gets the data
 	$data = $con->query($query);
 	$data->setFetchMode(PDO::FETCH_ASSOC);

  // Number of records of result
  $total = $data->rowCount();
  print "Number of resulting projects: " . $total;

 	//<!--Use nested loops to print out data elements-->
 	foreach ($data as $row) {
   	print " <tr> ";
   	foreach ($row as $name => $value) {
   	print " <td>$value</td> ";
   	}
   	print " </tr> ";
 	}
 	print "</table> ";
?>
<!----------------------------------------------------------------------------->
  </body>
</html>
