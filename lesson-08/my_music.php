<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>My Music</title>
<link rel="icon" href="images/favicon-hw.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" type="text/css" media="screen">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>

<style>
#accord_genre, .notes {
	width: 500px;
	padding: 10px;
	border: 1px solid #666;
	margin: 10px auto;
}

#accord_artist {
	padding: 7px;
	margin: 0px;
}

.genre_hdr {
background: #d0e4f7; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIzMyUiIHN0b3AtY29sb3I9IiNkMGU0ZjciIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjODE5ZWVhIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
background: -moz-linear-gradient(top,  #d0e4f7 33%, #819eea 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(33%,#d0e4f7), color-stop(100%,#819eea)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #d0e4f7 33%,#819eea 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #d0e4f7 33%,#819eea 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #d0e4f7 33%,#819eea 100%); /* IE10+ */
background: linear-gradient(to bottom,  #d0e4f7 33%,#819eea 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d0e4f7', endColorstr='#819eea',GradientType=0 ); /* IE6-8 */

	letter-spacing: .1em;
}


.accordion-toggle {
	color: black;
	font-weight: bold;
	font-size: 1.2em;
}

h3 {
	margin: 10px;
	text-align: center;
}



</style>


</head>

<body>

<h3>Heirarchical View of Music Collection</h3>

<!-- Outer layer of Collapsing Fields -->
<div class="accordion" id="accord_genre">

  <?php

  // Execute connection.php before continuing. 
  // Creates $dataConn as mysqli object instance
  require('connection.php');
  
  // Within the mysqli object $dataconn, run query method
  $genres = $dataConn->query('select genre, idgenres from genres order by genre');

  // Iterate as long as there's another genre row to grab
  while ($genre_row = $genres->fetch_object()) {
    // For each genre row, create an accordian group for next genre
    $genre_index = $genre_row->idgenres;
	?>
    <div class="accordion-group">
      <div class="accordion-heading genre_hdr">
        <a class="accordion-toggle" data-toggle="collapse" 
         data-parent="#accord_genre" 
         href="#collapseGenre<?php echo $genre_index ?>">
          <?php echo $genre_row->genre; ?>
        </a>
      </div>
      <div id="collapseGenre<?php echo $genre_index ?>" class="accordion-body collapse">
        <div class="accordion-inner">
        
        <!-- collapsing Fields for Artists -->
        <div class="accordion" id="accord_artist<?php echo $genre_index ?>">
          <?php
          // query to select artists and genres sorted by genre
          $artist = $dataConn->query('
            select artist, genre, idartists
            from artists, genres 
            where genres_idgenres = idgenres
            order by genre asc;
          ');
          
          // Iterate as long as there's another artist row to grab
          while ($artist_row = $artist->fetch_object()) {
			 $artist_index += $artist_row->idartists;
			 // For each artist row, create an accordian group for next artist
	         // when the artist's genre matches the current genre
             if ($artist_row->genre == $genre_row->genre) {
			 ?>
			 <div class="accordion-group">
			  <div class="accordion-heading info_hdr">
			   <a class="accordion-toggle" data-toggle="collapse" 
			    data-parent="#accord_artist<?php echo $genre_index ?>" 
			    href="#collapseArtist<?php echo $artist_index ?>">
                <?php echo $artist_row->artist; ?>
			   </a>
			  </div>
			  <div id="collapseArtist<?php echo $artist_index ?>" class="accordion-body collapse">
			   <div class="accordion-inner">
         
                <!-- collapsing Fields for Artists -->
                <div class="accordion" id="accord_album<?php echo $artist_index ?>">
                 <?php
                 // query to select albums, release_year and artists sorted by artists
                 $album = $dataConn->query('
                  select idalbums, album, release_year, artist
                  from albums, artists 
                  where artists_idartists = idartists
                  order by artist asc;
                 ');
          
                // Iterate as long as there's another artist row to grab
                while ($album_row = $album->fetch_object()) {
				  // For each album row, create an accordian group for next album
	              // when the album's artist matches the current artist
                  if ($album_row->artist == $artist_row->artist) {
                    $album_index = $album_row->idalbums;
                    ?>
				    <div class="accordion-group">
				     <div class="accordion-heading info_hdr">
				      <a class="accordion-toggle" data-toggle="collapse" 
				       data-parent="#accord_album<?php echo $artist_index ?>" 
				       href="#collapseAlbum<?php echo $artist_index . "_" . $album_index ?>">
				        <?php echo $album_row->album . " - (" . $album_row->release_year . ")"; ?>
				      </a>
				     </div>
				    <div id="collapseAlbum<?php echo $artist_index . "_" . $album_index ?>" class="accordion-body collapse">
			         <div class="accordion-inner">
			          <?php
			          // query to select tracks, track_num and albums sorted by albums
			          $track = $dataConn->query('
			            select track_num, track, album
			            from tracks, albums 
			            where albums_idalbums = idalbums
			            order by track_num asc;
			          ');
          
			          // Iterate as long as there's another artist row to grab
			          while ($track_row = $track->fetch_object()) {
			            // For each srtist row, create an accordian group for next artist
			            // when the artist's genre matches the current genre
			            if ($track_row->album == $album_row->album) {
			              echo $track_row->track_num . ". " . $track_row->track . "<br />\n";
			            }
			          }
  		              ?>
  		             </div>   <!-- End album accordian-inner -->
                    </div>    <!-- End album collapse -->
                   </div>     <!-- End album accordian-group -->
                   <?php
			      }  // End IF
		         }    // End WHILE
			     ?>
                 </div>       <!-- End album accordian -->
                </div>   <!-- End artist accordian-inner -->
               </div>    <!-- End artist collapse -->
              </div>     <!-- End artist accordian-group -->
              <?php
			  }  // End IF
		    }    // End WHILE
			?>
            </div>       <!-- End artist accordian -->
        </div>   <!-- End genre accordian-inner -->
      </div>     <!-- End genre collapse -->
    </div>       <!-- End genre accordian-group -->
  <?php
  }  // END genre while
//  $dataconn->close()
  ?>
</div>           <!-- End genre accordian -->

<div class="notes">
  <h4>Some notes about this Exercise:</h4>   
       <ol>
         <li>This exercise explores fetching and presenting database information from a MySQL database, using PHP to go between the HTML and MySQL. The full music database presented in hierarchical form using accordion-style buttons to make viewing compact and easy. Lots of nested DIVs, PHP-HTML interactions, and MySQL inner joins.</li>
         <li>The MySQL database is an expanded version of the Music database created for the class:
         <ul>
         	<li>More artists, albums and tracks were added.</li>
            <li>Extra DB columns were added: Release year, track number.</li>
            <li>TOAD was used to modify the DB, and scripts made it easier to batch up additions.</li>
          </ul>
        </li>
        <li>This example arranges four levels of Master-Detail data in a hiearchical format. I did not want a long exploded list of levels of data, so I used Bootstrap's Collapse accordian styling to create multiple levels of drop-open menus. I love the effect, but the code require many layers of nested DIV's. Each nested accordian section (the DIVs) is framed in HTML, and each level is filled out by iterative database fetches using PHP. The PHP grabs data, matching artists to genres, albums to artists, and tracks to albums, and generates the HTML code for the accordian hierarchy.</li>
        <li>Further, each level requires unique ID values. A PHP <code>echo</code> <em>appends</em> primary key values from the database (i.e. idgenres, idartists, etc.) to hard-coded HTML IDs  every iterative loop, making the DIV ID's unique each time a new level is built.
        </li>

       </ol>  
</div>   <!--  END DIV notes -->

<?php
  // Close the Data Connection
//  $thread_id = $dataConn->thread_id;
//  echo "<p>Thread ID: " . $thread_id;
  
  // Kill connection
//  $dataConn->kill($thread_id);

  // Close the Connection
  $dataConn->close();
?>

</body>
</html>