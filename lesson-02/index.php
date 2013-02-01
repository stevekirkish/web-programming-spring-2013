<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>CS 53.11B: Steve Kirkish Homepage</title>
<link rel="icon" href="images/favicon-hw.ico" type="image/x-icon">
<link rel="stylesheet" href="css/main_css.css" type="text/css" media="all">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>


</head>


<body>
<section id="wrapper">
  <header>
    <img src="images/Steve_headshot.jpg" width="150" height="150" alt="Steve Kirkish headshot">
    
    <hgroup>
        <h1>Steve Kirkish</h1>
        <h2>CS 53.11b: Advanced Web Programming with PHP/MySQL (Spring 2013)</h2>
    </hgroup>

  </header>

<section id="contentarea" class="clearfix">
<section id="leftnav">
	<ul class="button">
      <li><a href="#">Home</a></li>

   	  <li><a href="#">Exercises</a>
      	<ul>
        	<li><a href="exercises_other/welcome_call.html">PHP Form Sample</a></li>
        	<li><a href="exercises_class/lesson-02/agechecker.php">Age Checker</a></li>
        </ul>
      </li>
    
   	  <li><a href="#">Project</a></li>
    </ul>
   
</section>

<section id="content">
<h3>Introduction</h3>

<p>
After earning my BSEE at UC Davis and my MSEE at University of Rhode Island, I worked for <br>
16 years as an Electronics Engineer for two Silicon Valley companies. In 2003, my wife and I decided to move north to Healdsburg, where we opened a handcraft furniture and home decor gallery called Dovetail Collection. Soon after we opened, we worked with a web developer to build our website. Since then, I have maintained and often updated it.
</p>

<h3>Course Objectives</h3>

<p>
I've completed CS 50.11B and CS 50.11C (HTML5 and CSS3 courses), and CS55.11 (Javascript/JQuery). To complete the third leg of webpage coding, I want to be able to build and access databases, and create dynamic webpages based on user requests. 
</p>

<!-- Use POST method so that input value is not part of URL -->

<h2 style="background: #e2edaf;">Some Personal Numbers...</h2>
<div id="form_box">
<FORM ACTION="index.php" METHOD=POST>
<h3>Enter a Person's Birthdate to calculate their age: </h3>
<label>Month: </label><input type=text size=2 placeholder="mm" name="month">
<label>Day: </label><input type=text size=2 placeholder="dd" name="day">
<label>Year: </label><input type=text size=4 placeholder="yyyy" name="year">
<br><br>

<INPUT TYPE=SUBMIT VALUE="ENTER">
</FORM>

<?php

$dateStr = "";

// Convert individual date components into a single string value
// First checks for valid input values
function makeDate($yearInput, $monthInput, $dayInput) {
	if (( $yearInput > 1900 ) && ( $monthInput > 0 ) && ( $monthInput < 13 ) && ( $dayInput > 0 ) && ( $dayInput < 32 ) )  {
		$dateStr = strval($yearInput)."-".strval($monthInput)."-".strval($dayInput);
//		echo "Entered birthdate is ".$dateStr.", ".gettype($dateStr)."<br />";
	} else {
		$dateStr = "0";
//		echo "Entered birthdate is null: ".$dateStr.", ".gettype($dateStr)."<br />";
	}
 	return($dateStr);
}
// Calculate difference between now and birthdate
function age($birthdate) {
	return(strtotime('now') - strtotime($birthdate))/(60*60*24*365.25);
}

// Before loading the webpage, check to see if INPUTs have posted values
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Assign local vars to passed input date values, make them integers
	$yearInput = intval($_POST['year']);
	$monthInput = intval($_POST['month']);
	$dayInput = intval($_POST['day']);
	
	if ($yearInput || $monthInput || $dayInput) {
		$dateInput = makeDate($yearInput, $monthInput, $dayInput);
	}
	
	// If some sort of date was input, and it was valid...
	if (($dateInput) && ($dateInput != "0")) {
		
//		echo "<p>Formatted birthdate is ".$dateInput."</p>";
		
		$age = age($dateInput);
		
		$ageYears = intval($age);
		$ageMonths = ($age - $ageYears) * 12;
		$ageDays = ($ageMonths - intval($ageMonths)) * 30;
		
//		echo ("<p>The person's age is: $ageYears years, ".intval($ageMonths)." months, ".intval($ageDays)." days</p>");
		
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
		echo '<h3>Please Re-enter Valid Birthdate</h3>';
	}
}
?>
</div>

<p>This Age Checker doesn't swap between form and response. Here is a link to an exercise that does this swap: <a href="exercises_class/lesson-02/agechecker.php">Age Checker</a>.</p>

</section>
</section>



</section>

</body>

</html>