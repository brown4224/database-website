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
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
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
	// var $form_text  = "";
	$review_text  = "";
	$review_stars = "";
	$review_useful  = "";
	$review_funny = "";
	$review_cool = "";
	$review_business_id = "";
	$user_id = "mcq1qdkjI7M-E1BXeFXstg";
	$add_review = false;
	$user_reviews = 0;

	if(isset($_GET["city"]) && $_GET["city"] != "" ){
		$city = htmlspecialchars($_GET["city"]);
	}



	if(isset($_POST["review_text"]) && $_POST["review_text"] != "" ){
		$review_business_id = htmlspecialchars($_POST["review_business_id"]);
		$review_text = htmlspecialchars($_POST["review_text"]);
		$review_stars = htmlspecialchars($_POST["review_stars"]);
		$review_useful = htmlspecialchars($_POST["review_useful"]);
		$review_funny = htmlspecialchars($_POST["review_funny"]);
		$review_cool = htmlspecialchars($_POST["review_cool"]);

		if(is_numeric($review_stars) && is_numeric($review_useful) && is_numeric($review_funny) && is_numeric($review_cool) ){
			
			if((int)$review_stars == $review_stars && (int)$review_useful == $review_useful && (int)$review_funny == $review_funny && (int)$review_cool == $review_cool  ){
				$add_review = true;
			}

		} else{
				// Send message to user
		}
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






		<?php
				// Database
$link = mysqli_connect("localhost:3306", "root", "pass", "yelp_db");  //Don't do this on production.... 


				// Escapes string
	$safeSQL = mysqli_real_escape_string($link, $city);  // Escapes string
	$safeUserID = mysqli_real_escape_string($link, $user_id);  

			// Add review before getting DB
if($add_review){

				// Escapes string
	$safeBusinessID = mysqli_real_escape_string($link, $review_business_id);  
	$safeText = mysqli_real_escape_string($link, $review_text);  
	$safeStars = mysqli_real_escape_string($link, $review_stars);  
	$safeUseful = mysqli_real_escape_string($link, $review_useful);  
	$safeFunny = mysqli_real_escape_string($link, $review_funny);  
	$safeCool = mysqli_real_escape_string($link, $review_cool);  

	$query = "call add_review('".$safeBusinessID."', '".$safeUserID."', '".$safeText."', ".$safeStars.", ".$safeUseful.", ".$safeFunny.", ".$safeCool.")";
	$results =mysqli_query($link, $query);

	if($results){
		$review_text  = "";
		$review_stars = "";
		$review_useful  = "";
		$review_funny = "";
		$review_cool = "";
		$review_business_id = "";

	}else{

		echo "</br>There was an error...</br>";
		echo $results;
	}
}


			$query = "select get_reviews_count('" .$safeUserID. "') as count"; 
			$result = mysqli_query($link, $query);
			$user_reviews = $result->fetch_assoc()['count'];


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

				echo "<b>Number of Reviews:  </b>".$user_reviews."</br>";


  			// output data of each row
				$rowID = 0;
				$rowBlock = 0;
				$numRows = 5;
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$rowBlock = $rowID ;
						// Row 1:  Bussiness Name
						echo "<tr class='' name='results' id='". $row['name']."'  onclick='toggle(". ($rowBlock) .", ". ($numRows).")'> <td >" . $row[$val_1] . "</td><td>" . $row[$val_2] . "</td><td>" . $row[$val_3] . "</td><td>" . $row[$val_4] .  "</td><td>".$row[$val_5]."</td></tr>";
						$rowID++;
						if($row['is_open'] == 1){$open = 'Open';} else{$open = 'Closed';}
						// Row 2:  Bussiness Details
						echo "<tr id='".$rowID."'  class='hide' name='results-sublist'  onclick='toggle(". ($rowBlock) .", ". ($numRows).")'><td colspan='2'><b>Address:</b> ".$row['address']."</td><td><b>Neighborhood: </b>".$row['neighborhood']."</td><td><b>ID: </b>".$row['id']."</td></tr>";
						$rowID++;
						// Row 3:  Bussiness Details
						echo "<tr id='".$rowID."' class='hide' name='results-sublist' onclick='toggle(". ($rowBlock) .", ". ($numRows).")'><td><b>Latitude: </b>".$row['latitude']."</td><td><b>longitude: </b>".$row['longitude']."</td><td><b>Review Count: </b>".$row['review_count']."</td><td><b>".$open."</b></td></tr>";
						$rowID++;

						// INPUT Form
						echo "<form action='list.php' method='post'>";
						// Row 4: Review Text
						echo "<tr id='".$rowID."' class='hide' name='results-sublist'  ><td colspan='4' > <input id='review_text' type='text' name='review_text' class='form-control' placeholder='Please leave a review'  value=''></input></td></tr>";  
						$rowID++;
						// Row 5: Review numerical values
						echo "<tr id='".$rowID."'    class='hide' name='results-sublist' > <td  colspan='4'  >";
						echo "<div style='display: flex; flex-direction: row;'>";
						echo "<input id='review_stars'  type='number' name='review_stars' class='form-control' placeholder='stars'  value=''></input>";
						echo "<input id='review_useful'   type='number' name='review_useful' class='form-control' placeholder='useful'  value=''></input>";
						echo "<input id='review_funny'  type='number' name='review_funny' class='form-control' placeholder='funny'  value=''></input>";
						echo "<input id='review_cool'  type='number' name='review_cool' class='form-control' placeholder='cool'  value=''></input>";
						echo "</td>";
						echo "<td>  <button style='background-color: red; color: white;'   id='toolbar-button-business'type='submit' type='button' class='btn btn-default dropdown'>Post Review</button>  </td>";
						echo "</tr>";


						echo "<input type='hidden' name='review_business_id' value='".$row['id']."' />";  // Business ID

						echo "</div>";
						echo "</form>";
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


