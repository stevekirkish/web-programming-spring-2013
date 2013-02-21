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
<div id="agecalc">
<h4>Age Calculator</h4>
<div class="form_box">
<FORM ACTION="<?php $_SERVER['PHP_SELF'] ?>#agecalc" METHOD=POST>
<h3>Enter a Person's Birthdate to calculate their age: </h3>
<label>Month: </label><input type=text size=2 placeholder="mm" name="month">
<label>Day: </label><input type=text size=2 placeholder="dd" name="day">
<label>Year: </label><input type=text size=4 placeholder="yyyy" name="year">
<br><br>

<INPUT TYPE=SUBMIT name="submit_age" VALUE="ENTER">
</FORM>

<?php

$dateStr = "";
define(MM2INCH, 25.4); // Trying out a CONSTANT here...

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
  if (isset($_POST['submit_age'])) {  // If the AGE form submit button was clicked...
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
</div>

<div id="volcalc">
  <h4>Basic Geometry Calculator</h4>

  <div class="form_box">
  <?php 
    // Initialize variables
  	$error = "";
	$dimType = array("Length", "Area", "Volume");
	$unitPrefix = array("", "Square", "Cubic");

	$dimValue = 1;
    $inch_status = "checked";  // default selection on initial page load
    $mm_status = "";
    $cm_status = "";
    $meter_status = "";
	
	if (isset($_POST['submit_calc'])) { // If the form submit button was clicked...

		$length = floatval($_POST['length']);  // change $_POST string value to a number
		$width = floatval($_POST['width']);    // Empty field or non-number return zero
		$height = floatval($_POST['height']);
		$units = $_POST['units'];  // $units contains which radio button was selected
		$dimLevel = ($length > 0) + ($width > 0) + ($height > 0);
		
		if (($length < 0) || ($width < 0) || ($height < 0)) {
			$error = "Please make sure no dimension values are negative.";
		} else if ((!$length) && (!$width) && (!$height)) {
			$error = "Please enter at least one non-zero dimension value.";
		}
		
		// Calculate the Geometric Result: Can be length, area or volume.
		if ($length > 0) {
			$dimValue = $dimValue * $length;
		}
		if ($width > 0) {
			$dimValue = $dimValue * $width;
		}
		if ($height > 0) {
			$dimValue = $dimValue * $height;
		}
		
		// Compute result values, set selected radio button as checked
		// When page is reloaded, selected radio button must be marked as checked.
		switch ($units) {
			case 'inch':
			  $inch_status = "checked";
			  $resultEngIn = $dimValue;
			  $resultEngFt = $dimValue / pow(12, $dimLevel);
			  $resultMetMm = $dimValue * pow(MM2INCH, $dimLevel);
			  $resultMetM = $dimValue * pow(0.0254, $dimLevel);
			  break;
			case 'mm':
			  $mm_status = "checked";
			  $resultEngIn = $dimValue / pow(MM2INCH, $dimLevel);
			  $resultEngFt = $dimValue / pow((12*MM2INCH), $dimLevel);
			  $resultMetMm = $dimValue;
			  $resultMetM = $dimValue / pow(1000, $dimLevel);
			  break;
			case 'cm':
			  $cm_status = "checked";
			  $resultEngIn = $dimValue / pow(2.54, $dimLevel);
			  $resultEngFt = $dimValue / pow((12*2.54), $dimLevel);
			  $resultMetMm = $dimValue;
			  $resultMetM = $dimValue / pow(100, $dimLevel);
			  break;
			case 'm':
			  $meter_status = "checked";
			  $resultEngIn = $dimValue / pow(0.0254, $dimLevel);
			  $resultEngFt = $dimValue / pow((12*0.0254), $dimLevel);
			  $resultMetMm = $dimValue * pow(1000, $dimLevel);
			  $resultMetM = $dimValue;
			  break;
		}
	}
  
  ?>

    <form action="<?php $_SERVER['PHP_SELF'] ?>#volcalc" name="measurements" method=POST>
      <h3>Compute Length, Area or Volume</h3>
      <p class="boldtype">Enter at least one of the following values:</p>
      <label>Length: </label><input type=text size=4 name="length">
      <label>Width: </label><input type=text size=4 name="width">
      <label>Height: </label><input type=text size=4 name="height">
      <br><br>
       <input name="units" type="radio" value="inch" <?php echo $inch_status ?>><label>inches</label>
      <input name="units" type="radio" value="mm" <?php echo $mm_status ?>><label>mm</label>
      <input name="units" type="radio" value="cm" <?php echo $cm_status ?>><label>cm</label>
      <input name="units" type="radio" value="m" <?php echo $meter_status ?>><label>meter</label>
      <br><br>
      <INPUT TYPE=SUBMIT name="submit_calc" VALUE="Calculate">
    </form>
    
  <?php		// Output Results or Error Message
  
	if (isset($_POST['submit_calc'])) {
		if (!$error) {

			?>
            
<!-- Output concatenation of result + unit prefix (i.e. square, cubic) + unit
     Units can be singular or plural - ternary operator is used here -->
            
            
            <table class="data_table">
            	<tr>
                	<td>Length: <?php print $length ?></td>
                    <td>Width: <?php print $width ?></td>
                    <td>Height: <?php print $height ?></td>
                    <td><?php print $units ?></td>
                </tr>
            </table>
            
            <h3>Results: Calculate the <?php print $dimType[$dimLevel-1] ?> </h3>
            
            <table id="calcresults" class="data_table">
              <tr>
                <td><?php print number_format($resultEngIn,4) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." ".(($resultEngIn <= 1) ? "inch" : "inches") ?></td>
              </tr>
              <tr>
                <td><?php print number_format($resultEngFt,4) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." ".(($resultEngFt == 1) ? "foot" : "feet") ?></td>
              </tr>
              <tr>
                <td><?php print number_format($resultMetMm,4) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." mm" ?></td>
              </tr>
              <tr>
                <td><?php print number_format($resultMetM,4) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." ".(($resultMetM == 1) ? "meter" : "meters") ?></td>
              </tr>
            </table>
            
            <?php
		} else {
			?>
            <h3><?php print $error ?></h3>
            <?php
		}
	}
?>
<div id="notes">
<h3>Some notes about this Exercise:</h3>
<p>This code uses a variety of PHP techniques to automatically compute either length, area or volume based on how many values were filled in. User selects the desired units, and results are presented in both English and Metric systems. The code checks for valid inputs and generates error messages if needed.</p>
<ol>
	<li>Arrays simplify the output message formation, placing &quot;Length&quot;, &quot;Area&quot; or &quot;Volume&quot; in the result header and for a unit prefix (square, cubic), both based on the number of input vlaues entered.</li>
    <li><code>isset($_POST[&quot;submit_calc&quot;])</code> is used to determine if the submit button for this form (as opposed to the Age form above,) was clicked.</li>
    <li><code>switch-case</code> statements are used to determine proper calculations based on selected radio button.</li>
    <li>Radio buttons were added to the form. They need special treatment: The selected radio button needs to be re-&quot;checked&quot; upon reload, so this is partially done in the <code>switch</code> code.</li>
    <li>The <code>checked</code> and <code>unchecked</code> attributes are added dynamically to the <code>button</code> tags by PHP code.</li>
    <li>String concatenation is used to form the result messages, combining the result value with a unit prefix and unit type (inch, foot, etc.) Additionally, a ternary operator is used within each message to select a singular or plural unit type (i.e. foot or feet, inch or inches).</li>
</ol>

</div>
</div>
</div> <!-- END DIV volcalc -->

</section>
</section>



</section>

</body>

</html>