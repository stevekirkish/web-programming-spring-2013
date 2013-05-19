<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Healdsburg Galleries and Second Saturday Art Walk</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/healdsgal.css" rel="stylesheet" media="screen">
<link rel="icon" href="images/hg_logo.ico" type="image/x-icon">
<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'> <!-- other fonts: Maven+Pro|PT+Sans+Caption|Molengo -->
<script type="text/javascript"  src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCEs3OSXwWNBGW47APuXj8QcNrk9p1WM7g&sensor=true"></script>

</head>

<body>
<div id="wrapper">
<!-- HEADER BOX -->
 <header class="jumbotron subhead">
   <div class="container-fluid">
    <div class="row-fluid">
      <div class="span3" id="hdr_logo">
    	<img src="images/hg_logo.jpg" alt="Healdsburg Gallery Logo">
      </div>
      <hgroup class="span9">
          <h2>HEALDSBURG GALLERIES</h2>
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

<!-- MAP OF ALL GALLERIES -->
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
	          $secondSatSecs = strtotime($lastDayPriorMonth . " second saturday 9pm");
			  $icsFileName = 'ArtWalk_Cal_' . date("mdy", $secondSatSecs)  . '.ics';
	          if ($now < $secondSatSecs) {   // If "now" date is before the calculated 2nd saturday, then present date
				  if ($nextArtwalk == 1) {   // Isolate the next Art Walk to highlight ita
					  ?>
		<h3>Come to Healdsburg for our next Art Walk:</h3>
        <table class="event_date_group">
        	<tbody>
        		<tr>
        			<td class="event_date">
 						<h3><?php echo date("l, F&\\nb\\sp;j", $secondSatSecs); ?></h3>
        			</td>
        			<td class="add_to_cal">
 						<a href="calendar/<?php echo $icsFileName; ?>">
 							<img src="images/AddToCalIcon.jpg" alt="Add to Calendar Button">
 						</a>
        			</td>
        		</tr>
        	</tbody>
        </table>
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
        				<h4><?php echo  date("l, F&\\nb\\sp;j", $secondSatSecs);?></h4>
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
 </div>  <!-- END ARTWALK DIV -->

  
 <footer>
    <div id="copyright">
        <p>Copyright 2013. Developed by Steve Kirkish Designs for Healdsburg Galleries.</p>
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