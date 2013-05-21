<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Healdsburg Art Walk</title>
<!--
<link href='http://fonts.googleapis.com/css?family=Sigmar+One|Passion+One:700|Poller+One|Acme' rel='stylesheet' type='text/css'>  -->
<link type="text/css" href="css/artwalk_poster.css" rel="stylesheet" media="all">

</head>

<body>
  <div id="artwalk_poster">
    <div id="artwalk_header">
    <p class="stretch">2nd SATURDAY&nbsp;&nbsp;<span class="gray">|</span>&nbsp;&nbsp;
       <span class="blue">
       <?php	// Insert the next Art Walk DATE into the Header
          $now=date("U");  // Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
//          $now = mktime(20, 59, 0, 11, 31, 2013);  TEST ONLY
//		    $nowMonth = 11;							 TEST ONLY
		  $nowMonth = date("n");  // Extract curent month
          $lastDayPriorMonthSecs = mktime(21, 0, 0, $nowMonth, 0, 2013);  // last day of prior month
	      $lastDayPriorMonth = date("D, d M Y ", $lastDayPriorMonthSecs);
	      $secondSatSecs = strtotime($lastDayPriorMonth . " second saturday 11pm");
	      if ($now > $secondSatSecs) {   // If "now" date is after the calculated 2nd saturday, then calculate next date
			  $lastDayPriorMonthSecs = mktime(21, 0, 0, $nowMonth + 1, 0, 2013);  // last day of current month
	      	  $lastDayPriorMonth = date("D, d M Y ", $lastDayPriorMonthSecs);
	     	  $secondSatSecs = strtotime($lastDayPriorMonth . " second saturday 11pm");
		  }
		  echo date("M&\\nb\\sp;j", $secondSatSecs);
		?>
    </span>&nbsp;
    <span class="putty">ARTWALK</span>&nbsp;
    <span class="red">5-8PM</span>
    &nbsp;&nbsp;<span class="gray">|</span>&nbsp;&nbsp;
    ART FOOD WINE
    </p>
    
    </div>
	<img src="images/hg_artwalk_poster.jpg" width="540" height="561" alt="Artwalk Main Poster">
    <h3 id="tagline">Discover Healdsburg Galleries at<br />www.healdsburggalleries.com</h3>
  </div>
</body>
</html>
