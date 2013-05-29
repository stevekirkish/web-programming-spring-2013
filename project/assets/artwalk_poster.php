<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Healdsburg Galleries and Second Saturday Art Walk</title>
<meta name="description" content="Healdsburg Galleries host and exhibit art from internationally known and local artists, photographers, jewelers and craftsmen. Find gallery information, maps and Second Saturday Art Walk details here.">
<meta name="robots" content="all">
<meta name="author" content="Steve Kirkish">
<meta name="owner" content="Healdsburg Galleries and Second Saturday Artwalk">
<meta name="copyright" content="Copyright &copy; 2013 Steve Kirkish Designs">
<meta name="rating" content="general">
<meta name="keywords" content="Healdsburg, Galleries, Second, Saturday, Artwalk, Art Walk, ceramics, framing, furniture, glass, paintings, photography, sculptures, textiles, wood turnings">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">  <!-- run in full-screen mode -->

<link type="text/css" href="../css/artwalk_poster.css" rel="stylesheet" media="all">
<script src="http://code.jquery.com/jquery.js"></script>
</head>

<body>
  <div id="page_controls">
  <button type="button" id="back_btn">
  <a href="..">Back</a>
  </button>
  </div>
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
        
	<img src="../images/hg_artwalk_poster.jpg" width="540" height="561" alt="Artwalk Main Poster">

    <h3 id="tagline">Discover Healdsburg Galleries at www.healdsburggalleries.com</h3> 
  </div>
  
  
<script type="text/javascript">
	if (window.print) {		// only allow print feature if Javascript present
		var printPrompt = '<div id="print_pg"><img src="../images/print.png" width="14" height="13" alt="Print"><p>Print</p></div>';
		$('#page_controls').append(printPrompt);
		$('#print_pg').click(function() {
			$('#page_controls').hide();
			window.print();
			$('#page_controls').show();
		});
	}
</script>
</body>
</html>
