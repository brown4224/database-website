<!doctype html>
<!-- Sean McGlincy -->
<!-- ADV Databses -->
<html lang="en">
<head>
	<meta charset="utf-8">

	<title>The HTML5 Herald</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/styles.css?v=1.0">

	<!-- Bootstrap Files -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="./main.js"></script>
</head>

<body>


	<?php
	$val_1 = 'name';
	$val_2 = 'stars';
	$val_3 = 'address';
	$val_4 = 'city';
	$val_5 = 'postal_code';
	$query = "";
	$city  = "";

	if(isset($_GET["city"]) && $_GET["city"] != "" ){
		$city = htmlspecialchars($_GET["city"]);
	}
	?>



	<div class='container'>
		<div class='jumbotron'>


			<!-- PHP Form:  List -->
			<form action="list.php" method="get">

				<!-- Toool Bar -->
				<div id="toolbar" class="input-group input-group-sm">
					<input id="toolbar-text" type="text" name='city' class="form-control" placeholder="City or Zip"  value="<?php echo  $city ?>"></input>
					<span class="input-group-btn">
						<button id='toolbar-button' type='submit' type="button" class="btn btn-default "><i class="glyphicon glyphicon-search"></i></button>
					</span>
				</div>
			</div>
		</form>




<!-- <div class="show">
<input id="review-text" type="text" name='review-text' class="form-control" placeholder="Please leave a review"  value=""></input>
<div style="  display: flex; flex-direction: row;">
<input id="review-stars"  type="number" name='review-stars' class="form-control" placeholder="stars"  value=""></input>
<input id="review-useful"   type="number" name='review-useful' class="form-control" placeholder="useful"  value=""></input>
<input id="review-funny"  type="number" name='review-funny' class="form-control" placeholder="funny"  value=""></input>
<input id="review-cool"  type="number" name='review-cool' class="form-control" placeholder="cool"  value=""></input>
</div>
</div> -->


		<?php
				// Database
$link = mysqli_connect("localhost:3306", "root", "pass", "yelp_db");  //Don't do this on production.... 
			$safeSQL = mysqli_real_escape_string($link, $city);  // Escapes string

			if(is_numeric($safeSQL)){
				$query = "select * from business where postal_code like '" .$safeSQL. "' limit 20"; 

			} else{
				$query = "select * from business where city like '" .$safeSQL. "' limit 20"; 
			}


			$result = mysqli_query($link, $query);
			?>



			<div class='table-responsive'>



				<div id="toolbar-business" class="input-group input-group-sm">
					<input id="toolbar-text-business" type="text" class="form-control" placeholder="Search Businesses..."></input>
					<span class="input-group-btn">
						<button onclick="filter(document.getElementById('toolbar-text-business').value)" id='toolbar-button-business' type="button" class="btn btn-default dropdown">Filter</button>
					</span>
				</div>
				<?php
				echo "<table class='table' style='width:100%''> <tr><th>". $val_1. "</th><th>".$val_2."</th><th>".$val_3."</th><th>".$val_4."</th><th>"."zip"."</th></tr></br>";


  			// output data of each row
				$rowID = 0;
				$rowBlock = 0;
				$numRows = 5;
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$rowBlock = $rowID ;
						// Row 1:  Bussiness Name
						echo "<tr class='' name='results' id='". $row['name']."'  onclick='toggle(". ($rowBlock) .", ". ($numRows).")'> <td>" . $row[$val_1] . "</td><td>" . $row[$val_2] . "</td><td>" . $row[$val_3] . "</td><td>" . $row[$val_4] .  "</td><td>".$row[$val_5]."</td></tr>";
						$rowID++;
						if($row['is_open'] == 1){$open = 'Open';} else{$open = 'Closed';}
						// Row 2:  Bussiness Details
						echo "<tr id='".$rowID."'  class='hide' name='results-sublist'  onclick='toggle(". ($rowBlock) .", ". ($numRows).")'><td><b>ID:</b> ".$row['id']."</td><td><b>Neighborhood: </b>".$row['neighborhood']."</td><td><b>Address: </b>".$row['address']."</td></tr>";
						$rowID++;
						// Row 3:  Bussiness Details
						echo "<tr id='".$rowID."' class='hide' name='results-sublist' onclick='toggle(". ($rowBlock) .", ". ($numRows).")'><td><b>Latitude: </b>".$row['latitude']."</td><td><b>longitude: </b>".$row['longitude']."</td><td><b>Review Count: </b>".$row['review_count']."</td><td><b>".$open."</b></td></tr>";
						$rowID++;

						// INPUT Form
						// Row 4: Review Text
						// echo "<div id='".$rowID."' name='results-sublist' class=''>";
						echo "<tr id='".$rowID."' class='hide' name='results-sublist'  onclick='toggle(". ($rowBlock) .", ". ($numRows).")'><td colspan='5' > <input id='review-text' type='text' name='review-text' class='form-control' placeholder='Please leave a review'  value=''></input></td></tr>";  // Row 1
						$rowID++;
						// Row 5: Review numerical values
						echo "<tr id='".$rowID."'    class='hide' name='results-sublist' onclick='toggle(". ($rowBlock) .", ". ($numRows).")'> <td  colspan='5'  >";
						echo "<div style='display: flex; flex-direction: row;'>";
						echo "<input id='review-stars'  type='number' name='review-stars' class='form-control' placeholder='stars'  value=''></input>";
						echo "<input id='review-useful'   type='number' name='review-useful' class='form-control' placeholder='useful'  value=''></input>";
						echo "<input id='review-funny'  type='number' name='review-funny' class='form-control' placeholder='funny'  value=''></input>";
						echo "<input id='review-cool'  type='number' name='review-cool' class='form-control' placeholder='cool'  value=''></input>";
						echo "</td></tr>";
						echo "</div>";
						// echo "</div>";
						$rowID++;
						


					}

					echo "</table>";
					mysqli_free_result($result);
				}else{
					echo "<table style='width:100%''> <tr><th></th><th></th><th></th><th></th></tr></th></tr>";

				}
				echo "</div>";



				mysqli_close($link);
				?>
			</div>
		</body>
		</html>


