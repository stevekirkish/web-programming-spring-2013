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
.notes {
	width: 524px;
	padding: 10px;
	border: 1px solid #666;
	margin: 10px auto;
}
h3 {
	margin: 10px;
	text-align: center;
}
.genre_group {
	margin: 10px auto;
	border: 1px solid #666;
	width: 544px;
	background: #eef;
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
	padding: 1px 10px;
}

.artist_group {
	border: 1px solid #000;
	margin: 10px;
	background: #fff;
}

div.artist_group h4 {
	padding: 0 20px;
}

table.album_tracks {
	margin: 0 20px 10px 20px;
	border-top: 1px solid #000;
	border-left: 1px solid #000;
	width: 480px;
}
table.album_tracks caption{
	text-align: left;
	font-weight: bold;
}
table.album_tracks tr {
	border-collapse: collapse;
}
table.album_tracks th,
table.album_tracks td {
	border-bottom: 1px solid #000;
	border-right: 1px solid #000;
	text-align: left;
	padding-left: 10px;
}
table.album_tracks th {
	background: #ddd;
}
table.album_tracks tr td:first-child {
	width: 50px;
	padding-left: 30px;
	padding-right: 0;
}

</style>


</head>

<body>

<h3>Tabular View of Music Collection</h3>

<div id="genres">

  <?php
  // Execute connection.php before continuing. 
  // Creates $dataConn as mysqli object instance
  require('connection.php');
  
  // Within the mysqli object $dataconn, run query method
  // Create and populate objects for Genres, Artists, 
  $genres = $dataConn->query('select genre, idgenres from genres order by genre');

  // Iterate as long as there's another genre row to grab
  while ($genre_row = $genres->fetch_object()) {
    // For each genre row, create an accordian group for next genre
    $genre_index = $genre_row->idgenres;
	?>
    <div class="genre_group">
      <div class="genre_hdr">
          <h4><?php echo $genre_row->genre; ?></h4>
      </div>

      <!-- Artists Group for each Genre-->
        <?php
        // query to select artists and genres sorted by genre
        $artist = $dataConn->query('
          select artist, genre
          from artists, genres 
          where genres_idgenres = idgenres
          order by genre asc;
        ');
        // Iterate as long as there's another artist row to grab
        while ($artist_row = $artist->fetch_object()) {
          // For each artist row, create an album group for next artist
          // when the artist's genre matches the current genre
          if ($artist_row->genre == $genre_row->genre) {
			 ?>
             <div class="artist_group">
             <h4><?php echo $artist_row->artist; ?></h4>
             
             <!-- collapsing Fields for Artists -->
                <?php
				// query to select albums, release_year and artists sorted by artists
				$album = $dataConn->query('
			  	  select album, release_year, artist
			  	  from albums, artists 
			  	  where artists_idartists = idartists
			  	  order by artist asc;
				');
                // Iterate as long as there's another album row to grab
                while ($album_row = $album->fetch_object()) {
				  // For each album row, create a tracks table for next album
	              // when the album's artist matches the current artist
                  if ($album_row->artist == $artist_row->artist) {
                    ?>
                    <table class="album_tracks">
					<caption class="album_caption">
				      <?php echo $album_row->album . " - (" . $album_row->release_year . ")"; ?>
                    </caption>
					<tr>
                      <th>Track #</th>
                      <th>Track Name</th>
                    </tr>
			         <?php
          			 // query to select tracks, track_num and albums sorted by albums
          			 $track = $dataConn->query('
          			   select track_num, track, album
          			   from tracks, albums 
          			   where albums_idalbums = idalbums
          			   order by track_num asc;
          			 ');
			         // Iterate as long as there's another track row to grab
			         while ($track_row = $track->fetch_object()) {
			           // For each track row, create a table row for next album
			           // when this track is on the current album
			           if ($track_row->album == $album_row->album) {
						 ?>
                         <tr>
                           <td><?php echo $track_row->track_num ?></td>
                           <td><?php echo $track_row->track ?></td>
                         </tr>
						 <?php
			            }  // END tracks IF
			          }    // END tracks WHILE
				      ?>
                     </table> 
                  <?php                  
				  }        // END album IF
				}          // END album while
  		        ?>

  		     </div>   <!-- End div.artist_group -->
	    <?php
		  }        // END artist IF
		}          // END artist WHILE
		?>
    </div>   <!-- End div.genre_group -->

  <?php
  }          // END genre WHILE
  ?>
</div>       <!-- End div#genres -->



<div class="notes">
  <h4>Some notes about this Exercise:</h4>   
       <ol>
         <li>This exercise explores fetching and presenting database information from a MySQL database, using PHP to go between the HTML and MySQL. The full music database presented in <em>tabular</em> form, sorted and organized for easy viewing. Lots of nested PHP-HTML interactions and MySQL inner joins.</li>
         <li>The MySQL database is an expanded version of the Music database created for the class:
         <ul>
         	<li>More artists, albums and tracks were added.</li>
            <li>Extra DB columns were added: Release year, track number.</li>
            <li>TOAD was used to modify the DB, and scripts made it easier to batch up additions.</li>
          </ul>
        </li>
        <li>This example arranges four levels of Master-Detail data in a tabular format. This layout and the four data level requires many nested PHP iterative loops. For each genre loop, the artists are filtered, and when an artist falls into the current genre, the albums are checked for artist matches. Tracks are then captured for each album and inserted into an HTML framework of table elements via PHP.</li>
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