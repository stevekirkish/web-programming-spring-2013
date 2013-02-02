<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>CS 53.11B: Age Checker Exercise</title>
<link rel="icon" href="../images/favicon-hw.ico" type="image/x-icon">
<link rel="stylesheet" href="css/agechecker.css" type="text/css" media="all">
</head>

<body>
<section id="wrapper">

<section id="content">
<div id="header">
    <h2>Age Checker</h2>
    <button type="button"><a href="../../index.php">Home</a></button>
</div>  
  
<div id="form_box" class="clear">

<?php

$dateStr = "";

// Convert individual date components into a single string value
// First checks for valid input values
function makeDate($yearInput, $monthInput, $dayInput) {
	if (( $yearInput > 1900 ) && ( $monthInput > 0 ) && ( $monthInput < 13 ) && ( $dayInput > 0 ) && ( $dayInput < 32 ) )  {
		$dateStr = strval($yearInput)."-".strval($monthInput)."-".strval($dayInput);
	} else {
		$dateStr = "0";
	}
 	return($dateStr);
}
// Calculate difference between now and birthdate
function age($birthdate) {
	return(strtotime('now') - strtotime($birthdate))/(60*60*24*365.25);
}

//echo "Form Method: ".$_SERVER['REQUEST_METHOD'];

// If a FORM (date inputs) has been POSTED, run the calcs. If not, presesnt form.
// NOTE: Default is GET, and also "New Birthdate" button submit issues GET
//       which presents the Birthdate Form
if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
	// Assign local vars to passed input date values, make them integers
	$dateInput = "";
	$yearInput = intval($_POST['year']);
	$monthInput = intval($_POST['month']);
	$dayInput = intval($_POST['day']);
	
	if ($yearInput || $monthInput || $dayInput) {
		$dateInput = makeDate($yearInput, $monthInput, $dayInput);
	} else {	// Date fields empty
		echo '<h3>Please Enter a Birthdate.</h3>';
	}
	
	// Output Phrases, based on input date string and calculated age
	if (($dateInput) && ($dateInput != "0")) { // If some date values were input ...
		
		$age = age($dateInput);
		
		$ageYears = intval($age);
		$ageMonths = ($age - $ageYears) * 12;
		$ageDays = ($ageMonths - intval($ageMonths)) * 30;

		?>
        
		<p>The person's age is: <?php echo $ageYears ?> years, <?php echo intval($ageMonths) ?> months, <?php echo intval($ageDays) ?> days</p>
        
        <?php
		
		if (($age < 18) && ($age > 0)) {
			?>
			<h3>Sorry, too young to vote or drink for now.</h3>
			<?php
		} else if ($age > 21) {
			?>
			<h3>Hey, they are old enough to drink!</h3>
			<?php
		} else if ($age > 18) {
			?>
			<h3>Hey, they are old enough to vote!</h3>
			<?php
		} else {
			?>
	  <h3>Sorry, you entered a birthdate in the future. Please re-enter the date.</h3>
			
			  <?php
		}
	} elseif ($dateInput === "0") {	// Input Date Values not Valid
		echo '<h3>Please Re-enter a Valid Birthdate</h3>';
	}
// 	"New Birthdate" button submit issues GET to recall cleared birthdate form
	?>
    <form action="" method="get">
    	<input type=submit value="New Birthdate">
    </form>
    <?php
	
} else {
// If form has not been submitted, or new form request has been submitted...
	?>
    <!-- Use POST method so that input value is not part of URL -->
	<FORM ACTION="" METHOD=POST>
        <h3>Enter a Person's Birthdate to calculate their age: </h3>
        <label>Month: </label><input type=text size=2 placeholder="mm" name="month">
        <label>Day: </label><input type=text size=2 placeholder="dd" name="day">
        <label>Year: </label><input type=text size=4 placeholder="yyyy" name="year">
        <br><br>
        
        <INPUT TYPE=SUBMIT VALUE="ENTER">
    </FORM>
<?php

}  // Close brace for [METHOD === POST]? IF statement

?>
</div>

<div id="notes">
<h3>Some notes about this Exercise:</h3>
<p>This code uses PHP for the following tasks:</p>
<ol>
	<li>Calculate an age based on an input date,</li>
    <li>Check that input fields are not blank,</li>
    <li>Check that input values are valid calendar values,</li>
    <li>Output a statement based on the person's age, or output an error message (i.e. Birthdate is in the future.)</li>
</ol>
<p>The program consists of two main "screens": The input form and the response message. When the page loads, it checks to see if a form has POSTed data. If not, the form is presented. When data is submitted from the form, the page is reloaded, sees that data was POSTed, and runs the response screen code.</p>
<p>Another important part to this was allowing the form to be re-accessed. Chrome seems to force the user to recall previous entries upon refresh, meaning that when the page is reloaded, it detects the POST situation and does not present the form. to fix this, a button was added to the response page called "New Birthdate" that reloads the page using the GET method. The page reloads, sees that the method is GET, not POST, and thus presents the birthdate FORM again. Nifty!</p>
    


</div>
</section>  <!-- END #content DIV -->


</section>

</body>

</html>