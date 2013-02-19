<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">

<title>CS 53.11B: Steve Kirkish Homepage</title>
<link rel="icon" href="images/favicon-hw.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/index_css.css" type="text/css" media="screen">

</head>

<body>

<!-- HEADER BOX -->
 <header class="jumbotron subhead">

    <div class="row">
      <div class="span3">
    <img src="images/Steve_headshot.jpg" width="150" height="150" alt="Steve Kirkish headshot">
      </div>
      <hgroup class="span9">
          <h1>Steve Kirkish</h1>
	      <h2>CS 53.11b | Spring 2013</h2>
          <h2>Advanced Web Programming with PHP/MySQL</h2>
     </hgroup>
   </div> 

 </header>
<!-- END HEADER BOX -->

<!--
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
-->

<!-- - - - - - - - - - - - - - - - - - - - - - -
     MAIN CONTENT BLOCK - INTRODUCTION
     - - - - - - - - - - - - - - - - - - - - - - -->
<section id="content" class="container-fluid"> 
<div id="identity" class="row-fluid">
  <div class="span12">
    <h3>Introduction</h3>
    
    <p>
    After earning my BSEE at UC Davis and my MSEE at University of Rhode Island, I worked for <br>
    16 years as an Electronics Engineer for two Silicon Valley companies. In 2003, my wife and I decided to move north to Healdsburg, where we opened a handcraft furniture and home decor gallery called Dovetail Collection. Soon after we opened, we worked with a web developer to build our website. Since then, I have maintained and often updated it.
    </p>
    
    <h3>Course Objectives</h3>
    
    <p>
    I've completed CS 50.11B and CS 50.11C (HTML5 and CSS3 courses), and CS55.11 (Javascript/JQuery). To complete the third leg of webpage coding, I want to be able to build and access databases, and create dynamic webpages based on user requests. 
    </p>
  </div>  <!-- / #identity.span12 -->
</div>  <!-- / #identity.row -->

<h3>About this Home Page...</h3>
<p>This page is styled with the help of twitter Bootstrap, using its responsive features. It has been scratch-built and formatted to work with a variety of screen widths. So far, I have tested it successfully on a wide-screen laptop, an iPad3 in both orientations, and an iPhone 5 in both orientations. I would love to hear feedback of what other platforms show.</p>
<p>Some Bootstrap features used include the basic scaffolding and the collapsing title-bars seen below. Custom CSS was created to modify various styles (fonts, block margin and padding tweaks, gradient additions, etc.) For the collapsing title-bars, I built and installed a ternary php expression to reopen a section where a form had been submitted. Without this extra code, the page reloads with all tabs closed, which could confuse a user.</p>
<h3>CSS3-based Features</h3>
<ul>
	<li>Gradient in the header, with RGBA</li>
    <li>Border-rounding on the image and header block</li>
    <li>Box-shadow on the image</li>
    <li>Box-shadow (inset) on the header block elements for a 3D effect</li>
    <li>@font-face used to specify a non-system font</li>
</ul>
<p>Also build CSS3 Transition cold to create a thumbnail to image viewer. Refer to the exercise below to see it in action.</p>
<h3>Exercises</h3>

<!-- - - - - - - - - - - - - - - - - - - - - - -
     AGE CALCULATOR
     - - - - - - - - - - - - - - - - - - - - - - -->
<p><em>Click a title-bar to open or close any exercise.</em></p>
<div class="accordion" id="accord_exer">
 <div class="accordion-group">
  <div class="accordion-heading">
   <a class="accordion-toggle" data-toggle="collapse" data-parent="#accord_exer" href="#collapseAge">
     Age Calculator (PHP)
   </a>
  </div>
  <div id="collapseAge" class="accordion-body collapse <?php echo (isset($_POST['submit_age']) ? "in" : "") ?>"> <!-- Reopens AgeCalc's Accordian tab on reload -->
   <div class="accordion-inner">
   <div id="agecalc" class="row-fluid">
    <div class="form_box span6">
    <h5>Enter a Person's Birthdate to calculate their age:</h5>
    
     <!-- Use POST method so that input value is not part of URL -->
    <form action="<?php $_SERVER['PHP_SELF'] ?>#agecalc" method=post class="form-inline">
       <input type=text class="input-tiny" placeholder="Month" name="month">
       <input type=text class="input-tiny" placeholder="Day" name="day">
       <input type=text class="input-tiny" placeholder="Year" name="year">
       <input type=submit class="btn btn-success" name="submit_age" value="ENTER">
    </form>
    
    <?php
    $dateStr = "";
    define(MM2INCH, 25.4); // Trying out a CONSTANT here.
    
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
            $age = age($dateInput);
            $ageYears = intval($age);
            $ageMonths = ($age - $ageYears) * 12;
            $ageDays = ($ageMonths - intval($ageMonths)) * 30;
            ?>
            
            <p>The person's age is: <?php echo $ageYears ?> years, <?php echo intval($ageMonths) ?> months, <?php echo intval($ageDays) ?> days</p>
            
            <?php
            
            if (($age < 18) && ($age > 0)) {
                ?>
                <h4>Sorry, too young to vote or drink for now.</h4>
                <?php
            } else if ($age > 21) {
                ?>
                <h4>Hey, they are old enough to drink!</h4>
                <?php
            } else if ($age > 18) {
                ?>
                <h4>Hey, they are old enough to vote!</h4>
                <?php
            } else {
                ?>
                <h4>Sorry, you entered a birthdate in the future. Please re-enter the date.</h4>
                <?php
            }
        
        } elseif ($dateInput === "0") {	// Input Date Values not Valid
            echo '<h4>Please Re-enter Valid Birthdate</h4>';
        }
    }
    ?>
    </div>
    <div class="notes span6">
      <h4>Notes:</h4>
      <p>For this example Age Checker, the PHP code re-calls this page when the form is submitted, and adds the HTML response this page. Here is a link to an exercise that swaps the inputs with the response: <a href="exercises_class/lesson-02/agechecker.php">Age Checker</a>. For that example, when the response replaces the form, the Submit button is replaced with a &quot;New Birthdate&quot; button, allowing for another set of inputs.</p>
      <ol>
		<li>PHP fully validates the inputs, generating an error message if not valid.</li>
        <li>The age is presented as years, months and days, and some comment is made about the age.</li>
        
      </ol>
    </div>
    </div>
    </div>
    </div>
</div>

<!-- - - - - - - - - - - - - - - - - - - - - - -
     EXERCISE: GEOMETRY CALCULATOR
     - - - - - - - - - - - - - - - - - - - - - - -->
 <div class="accordion-group">
  <div class="accordion-heading">
   <a class="accordion-toggle" data-toggle="collapse" data-parent="#accord_exer" href="#collapseGeo">
     Basic Geometry Calculator (PHP)
   </a>
  </div>
  <div id="collapseGeo" class="accordion-body collapse <?php echo (isset($_POST['submit_calc']) ? "in" : "") ?>"> <!-- Reopens GeoCalc's Accordian tab on reload -->
   <div class="accordion-inner">
     
   <div id="geocalc" class="row-fluid">
    <div class="form_box span6">
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

<!-- HTML FORM CODE: GEOMETRY CALCULATOR -->

    <form action="<?php $_SERVER['PHP_SELF'] ?>#geocalc" name="measurements" method=POST class="form-inline">
      <h4>Compute Length, Area or Volume</h4>
      <p><strong>Enter at least one of the following values (length, width, height):</strong></p>
      <input type=text class="input-tiny" placeholder="Length"  name="length">
      <input type=text class="input-tiny" placeholder="Width"  name="width">
      <input type=text class="input-tiny" placeholder="Height"  name="height">
      <br><br>
      <label class="radio inline">
       <input name="units" type="radio" value="inch" <?php echo $inch_status ?>>inch</label>
       <label class="radio inline">
      <input name="units" type="radio" value="mm" <?php echo $mm_status ?>>mm</label>
      <label class="radio inline">
      <input name="units" type="radio" value="cm" <?php echo $cm_status ?>>cm</label>
      <label class="radio inline">
      <input name="units" type="radio" value="m" <?php echo $meter_status ?>>meter</label>
      <br><br>
      <input type=submit class="btn btn-success" name="submit_calc" VALUE="Calculate">
    </form>
    
<!-- END FORM: GEOMETRY CALCULATOR -->
    
  <?php		// Output Results or Error Message
  
	if (isset($_POST['submit_calc'])) {
		if (!$error) {

			?>

<!-- Output concatenation of result + unit prefix (i.e. square, cubic) + unit
     Units can be singular or plural - ternary operator is used here -->
            
            <table class="data_table">
            	<tr>
                	<th>Length</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Units</th>
                </tr>
            	<tr>
                	<td><?php print $length ?></td>
                    <td><?php print $width ?></td>
                    <td><?php print $height ?></td>
                    <td><?php print $units ?></td>
                </tr>
            </table>
            
            <h5>Results: Calculate the <?php print $dimType[$dimLevel-1] ?> </h5>
            
            <table id="calcresults" class="data_table">
              <tr>
                <td><?php print number_format($resultEngIn,3) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." ".(($resultEngIn <= 1) ? "inch" : "inches") ?></td>
              </tr>
              <tr>
                <td><?php print number_format($resultEngFt,3) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." ".(($resultEngFt == 1) ? "foot" : "feet") ?></td>
              </tr>
              <tr>
                <td><?php print number_format($resultMetMm,3) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." mm" ?></td>
              </tr>
              <tr>
                <td><?php print number_format($resultMetM,3) ?></td>
                <td><?php print $unitPrefix[$dimLevel-1]." ".(($resultMetM == 1) ? "meter" : "meters") ?></td>
              </tr>
            </table>
            
            <?php
		} else {
			?>
            <h4><?php print $error ?></h4>
            <?php
		}
	}
?>
    </div>
    <div class="notes span6">
<h4>Some notes about this Exercise:</h4>
<p>This code uses a variety of PHP techniques to automatically compute either length, area or volume based on how many values were filled in. User selects the desired units, and results are presented in both English and Metric systems. The code checks for valid inputs and generates error messages if needed.</p>
<ol>
	<li>Arrays simplify the output message formation, placing &quot;Length&quot;, &quot;Area&quot; or &quot;Volume&quot; in the result header and for a unit prefix (square, cubic), both based on the number of input vlaues entered.</li>
    <li><code>isset($_POST[&quot;submit_calc&quot;])</code> is used to determine if the submit button for this form (as opposed to the Age form above,) was clicked.</li>
    <li><code>switch-case</code> statements are used to determine proper calculations based on selected radio button.</li>
    <li>Radio buttons were added to the form. They need special treatment: The selected radio button needs to be re-&quot;checked&quot; upon reload, so this is partially done in the <code>switch</code> code.</li>
    <li>The <code>checked</code> and <code>unchecked</code> attributes are added dynamically to the <code>button</code> tags by PHP code.</li>
    <li>String concatenation is used to form the result messages, combining the result value with a unit prefix and unit type (inch, foot, etc.) Additionally, a ternary operator is used within each message to select a singular or plural unit type (i.e. foot or feet, inch or inches).</li>
</ol>
</div>  <!-- END DIV .notes.span6 -->
</div>  <!-- END DIV #goecalc.row-fluid -->
</div>  <!-- END DIV accordian-inner -->
</div>  <!-- END DIV #collapseGeo.accordian_body.collapse -->

</div>  <!-- END accordian_group -->

<!-- - - - - - - - - - - - - - - - - - - - - - -
     EXERCISE: GEOMETRY CALCULATOR
     - - - - - - - - - - - - - - - - - - - - - - -->
 <div class="accordion-group">
  <div class="accordion-heading">
   <a class="accordion-toggle" data-toggle="collapse" data-parent="#accord_exer" href="#collapseImgTrans">
     CSS3 Transitions: Expand Thumbnail to Full Image
   </a>
  </div>
  <div id="collapseImgTrans" class="accordion-body collapse">
   <div class="accordion-inner">
    <div id="imgTrans" class="row-fluid">
     <div class="form_box span7">
       <h5>Hover over the image below to see the full picture</h5>
       <p><em>(Note: Will not transition with Internet Explorer)</em></p>
       <div id="css3-trans">
		<img src="images/Hyatt_Scenic_Sunrise_1.jpg" alt="Grand Hyatt Poipu, Kauai, Hawaii"> 
       </div>
       <p>This exercise uses CSS3 transition properties to move certain style properties from one set of values to another set of values. Here, two HTML elements are controlled. An image-containing DIV is set to thumbnail-sized dimensions, with a full sized image inside. The <code>overflow: hidden</code>  property crops the image. When the mouse hovers over the image, transition effects change the DIV size to full image size. The image is also shifted to remain inside the DIV box; initial margin values determine which part of the image peeks through the thumbnail-seized window.</p>
     </div>   <!--  END DIV .form_box.span6 -->
     <div class="notes span5">
	   <h4>Some notes about this Exercise:</h4>
       <ol>
         <li>When using Bootstrap with a dedicated CSS file, unexpected results may occur. This happens when Bootstrap styles a tag that is further styled in the dedicated CSS. When the page doesn't look as expected, search Bootstrap for the tag(s) in question - you may need to reset (unmodify) certain properties to ensure correct results. To troubleshoot the problem, separate out the code bit (with it's CSS, but no bootstrap) to get it working first.</li>
         <li><code>@media (max-width: 480px)</code> was used to limit the expanded image size for smaller screeens (i.e. iPhone) so they don't grow past the edge of the page.</li>
       </ol>
     </div>   <!--  END DIV .form_box.span6 -->
    </div>   <!-- END DIV #imgTrans.row-fluid -->
   </div>   <!-- END DIV accordian-inner -->
  </div>  <!-- END DIV #collapseImgTrans.accordian_body.collapse -->

 </div>  <!-- END accordian_group -->
</div>  <!-- END div#accord_exer .accordian -->

<br>
<br>
<br>
<br>
<br>
<br>
<br>

</section>  <!-- END #content.container-fluid -->
<!-- </section> -->

<footer class="row">
  <div class="span12">
  <p>Reserved for future footer action.</p>
  
  </div>

</footer>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>

</body>

</html>