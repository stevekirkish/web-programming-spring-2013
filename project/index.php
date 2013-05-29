<!DOCTYPE html>
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

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">  <!-- run in full-screen mode -->

<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/healdsgal.css" rel="stylesheet" media="screen">
<link rel="icon" href="images/hg_logo.ico" type="image/x-icon">
<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'> <!-- other fonts: Maven+Pro|PT+Sans+Caption|Molengo -->
<script type="text/javascript"  src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCEs3OSXwWNBGW47APuXj8QcNrk9p1WM7g&sensor=true"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41205642-1', 'healdsburggalleries.com');
  ga('send', 'pageview');

</script>

</head>

<body>
<div id="wrapper">
<!-- HEADER BOX -->
 <header class="jumbotron subhead">
   <div class="container-fluid">
    <div class="row-fluid">
      <div class="span3 photo" id="hdr_logo">
    	<img src="images/hg_logo.jpg" alt="Healdsburg Galleries Logo">
      </div>
      <hgroup class="span9">
          <h2 class="fn org">HEALDSBURG GALLERIES</h2>
      </hgroup>
     </div>
    </div>
 </header>
<!-- END HEADER BOX -->

<!-- NAVIGATION BAR -->
 <div id="top_navbar" class="navbar">
   <ul class="nav">
     <li class="active"><a href="#galleries">Galleries</a></li>
     <li><a href="#gal_map">Map</a></li>
<!--     <li><a href="#gal_events">Events</a></li> -->
     <li><a href="#artwalk">Art Walk</a></li>
   </ul>
 </div>
<!-- END NAVIGATION BAR -->

<!-- GALLERIES -->
 <div id="galleries" class="contents">
 	<div id="gal_filter">
	    <label class="filt-label">Pick a genre:</label>
	    <select name="gal_filt" id="gal_filt" class="filt_select"></select>
        <button type="button" class="btn btn-warning" id="show_all">Show All</button>
    </div>
    <div id="gal_list"></div>
 </div>
<!-- END GALLERIES --> 

<!-- MAP OF ALL GALLERIES -->
 <div id="gal_map" class="contents" style="display: none;">
 	<div id="map_galleries"></div>
 </div>
<!-- END MAP OF ALL GALLERIES --> 

<!-- ART WALK PAGE -->
 <div id="artwalk" class="contents"  style="display: none;">
  <div id="artwalk_hdr">
   <div class="container-fluid">
    <div class="row-fluid">
      <div class="span3" id="hg_logo">
    	<img src="images/hg_logo.jpg" alt="Healdsburg Gallery Logo">
      </div>
      <div class="span9">
          <img src="images/artwalk_title.jpg" alt="Art Walk Title">
      </div>
     </div>
    </div>
    <div id="town_bar">
      <div class="centered">
        <p>DOWNTOWN HEALDSBURG</p>
      </div>
    </div>
   </div>
    
    <div id="artwalk_subtext">
       <div class="container-fluid">
         <div class="row-fluid">
           <div class="span5" id="sec_sat">
    		 <p class="stretch">SECOND SATURDAYS</p>
           </div>
           <div class="span7" id="subtext_info">
             <h3>5-8pm | <span class="redtext">ART. FOOD. WINE.</span></h3>
             <p>Some Galleries will stay open later.<br />
                Some galleries will pour Local Artisan Wines.</p>
           </div>
         </div>
       </div>
     </div>
     
     <div id="artwalk_dates">
       <?php
          $now=date("U");  // Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
//           $now = mktime(20, 59, 0, 10, 31, 2013);  TEST ONLY
		  $nextArtwalk = 1;  // Flag used to mark the next Art Walk
          for ($month = 4; $month <=12; $month += 1) {   // LOOP: From Apr. - Dec., calculate each 2nd Sat.
	          $lastDayPriorMonthSecs = mktime(21, 0, 0, $month, 0, 2013);  // last day of prior month
	          $lastDayPriorMonth = date("D, d M Y ", $lastDayPriorMonthSecs);
			  $dtstart = strtotime($lastDayPriorMonth . " second saturday 5pm");
	          $dtend = strtotime($lastDayPriorMonth . " second saturday 8pm");
			  $icsFileName = 'ArtWalk_Cal_' . date("mdy", $dtend)  . '.ics';
	          if ($now < $dtend) {   // If "now" date is before the calculated 2nd saturday, then present date
				  if ($nextArtwalk == 1) {   // Isolate the next Art Walk to highlight ita
					  ?>
        <span class="vevent">  <!-- Microformats for hCalendar Event follow... -->              
		<h3><span class="summary">Come to Healdsburg for our next Art Walk</span>:</h3>
        <table class="event_date_group">
        	<tbody>
        		<tr>
        			<td class="event_date">
 						<h3>
                        <time class="dtstart" datetime="<?php echo date('c', $dtstart); ?> "><?php echo date("l, F&\\nb\\sp;j", $dtstart); ?></time>
                        <time class="dtend" datetime="<?php echo date('c', $dtend); ?> "></time>
                        </h3>
        			</td>
        			<td class="add_to_cal">
 						<a href="calendar/<?php echo $icsFileName; ?>">
 							<img src="images/AddToCalIcon.jpg" alt="Add to Calendar Button">
 						</a>
        			</td>
        		</tr>
                <tr>
                	<td colspan="2" class="brochure-click">
                    	<a href="assets/artwalk_poster.php">(Click here for printable brochure)</a>
                    </td>
                </tr>
        	</tbody>
        </table>
        </span>
                       <?php
                      if ($month < 12) { ?>
        <h4 class="eventListHdr">Art Walks continue in <?php echo date("Y", $now); ?>:</h4>
        <table class="event_date_group">
        	<tbody>
                      <?php
                      }
                      
                      $nextArtwalk = 0;
				  } else {
		          ?>
        		<tr>
        			<td class="event_date">
        				<h4><?php echo  date("l, F&\\nb\\sp;j", $dtend);?></h4>
        			</td>
        			<td class="add_to_cal">
        				<a href="calendar/<?php echo $icsFileName; ?>">
                           <img src="images/AddToCalIcon.jpg" alt="Add to Calendar Button">
        				</a>
        			</td>
        		</tr>

				  <?php
				  }
		      
	          } 
          }
       ?>
        	</tbody>
        </table>

     </div>
       <h4 class="closing">We look forward to seeing you in Healdsburg!</h4>     
 </div>
 
 <!-- END ART WALK PAGE -->

  
 <footer>
    <div id="copyright">
        <p>Copyright &copy; 2013. Developed by <span class="fn">Steve Kirkish</span> Designs for <span class="fn org">Healdsburg Galleries</span>.</p>
    </div>
    <div id="footer_extras">
        <iframe src="https://www.facebook.com/plugins/like.php?href=www.healdsburggalleries.com"
        scrolling="no" frameborder="0">
        </iframe>
    </div>
 </footer>


<!-- END MAP OF ALL GALLERIES --> 
 
</div>  <!-- END WRAPPER DIV -->
  <script src="http://code.jquery.com/jquery.js"></script> 
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="js/healdsgal.js"></script>
  <!-- <script type="text/javascript" src="js/jquery.addtocal.js"></script> -->
</body>
</html>