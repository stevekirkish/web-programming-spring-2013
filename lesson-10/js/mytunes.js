// When page loads, download the whole database to make data access local and quick
// Put whole database into JSON (javascript object), then traverse locally
// Optimal mainly for small databases. It's a design choice.
// Minimizes chatty comunication between client and server
// May be right for mobile apps.
$(document).ready(function() {
	function getMusic() {
	   $.ajax({
           type: "GET",
           url: "php/get-music.php",
           datatype: "json",
           async: false  // wait until full database is returned; not async here 
      }).done(function(data) {
		   genres = $.parseJSON(data);
	  });
	  return genres;
	};
	
	function showTracks(genreID,artistID,albumID) {
		if (music[genreID].artists[artistID].albums[albumID].tracks) {
			var content = '<section class="tracks span12">',
				trackList = [];
	 		content += '<h3>Tracks&nbsp;<a data-genreid='+genreID+' data-artistid='+artistID+' data-albumid='+albumID+'  id="plustrack"><i class="icon-plus"></i></a></h3>';
			// Sort the tracks by track number (otherwise, sorted in object by trackid)
			// Create DOM element for each track, indexed by track number
			$.each(music[genreID].artists[artistID].albums[albumID].tracks, function(index, value) {
				trackList[value.track_num] = '<article data-trackid='+index+'>' + value.track_num + ": " + value.track + '</article>';
			});
			// Compile track list DOM elements, ordered by array index (= track number)
			$.each(trackList, function(index, value) {
				if (trackList[index]) {
					content += trackList[index];
				}
			});
			
			content += "</section>";
			$("#track").html(content);
			$("#plustrack").click(function() {	// #plustrack tag is the Add Track button
				$("#addtrack").modal("show");
				$("#newtrack").attr("data-albumid", $(this).attr('data-albumid'));
				$("#newtrack").attr("data-artistid", $(this).attr('data-artistid'));
				$("#newtrack").attr("data-genreid", $(this).attr('data-genreid'));
				$("#data-update").show();
			});
		} else {
			$("#track").html("");
		}
	}
	$("#newtrack").click(function() {  // #newtrack is id on SAVE button on modal box
		$.ajax({
			type: "POST",
			url: "php/new-track.php",
			data : { 
				albumid: $("#newtrack").attr("data-albumid"),
				track: $("#newtrackname").val(),
				track_num: $("#newtracknum").val()
			}
		}).done(function(data) {	// returns data = idtracks value from DB
			var newtrack = {
				albums_idalbums : $("#newtrack").attr("data-albumid"),
				idtracks : data, 
				track : $("#newtrackname").val(),
				track_num: $("#newtracknum").val()
			};
			// music[] is the object representation of the whole database - add the track data here
			//    [---- music index ----------------] .         [---- artists index --------------] .       [----- albums index --------------] data = idtracks
			music[$("#newtrack").attr("data-genreid")].artists[$("#newtrack").attr("data-artistid")].albums[$("#newtrack").attr("data-albumid")].tracks[data] = newtrack;
			$("#addtrack").modal("hide");	// Hide the Add Track popup
			showTracks($("#newtrack").attr("data-genreid"),$("#newtrack").attr("data-artistid"),$("#newtrack").attr("data-albumid"));
	  });
	});
	
	function addAlbumToPage(genreId, artistId, albumId) {
		var divAlbums = 'div[albums-artistid="' + artistId + '"]',
			content,
			value = music[genreId].artists[artistId].albums[albumId];
		content = '<article class="album" data-genreid='+genreId+' data-artistid='+artistId+' data-albumid='+albumId+'>';
		content += '<img class="tn" src="images/' + value.img_file + '" />';
		content += '<h5>' + value.album + '</h5>';	
		content += '</article>';
		
		$(divAlbums).append(content);
	};
	
	// Every time there is an artist, list their albums
	function showAlbums(genreID,artistID) {
		var content = '<section class="albums span7">';
		content += '<div albums-artistid="' + artistID + '">';
		if (genres[genreID].artists[artistID].albums) {  // As long as an artist has an album...
			$.each( genres[genreID].artists[artistID].albums, function(index,value) {
				content += '<article class="album" data-genreid='+genreID+' data-artistid='+artistID+' data-albumid='+index+'>'; 
//				content += '<img class="tn" src="php/utils/get-album-image.php?id='+index+'" />';	DB Blog Images
				content += '<img class="tn" src="images/' + value.img_file + '" />';
				content += '<h5>' + value.album + '</h5>';	
				content += '</article>';
			});	
		}
		content += '</div>';

		// Album Box footer: Add an Album prompt
		content += '<div class="albumadd"><div>';
		content += '<a data-genreid='+genreID+' data-artistid='+artistID+'  id="plusalbum' + artistID + '">+</a>';
		content += '<h3 header-artistid="' + artistID + '">Add an Album . . .</h3></div>';
		content += '<div inputs-artistid="' + artistID + '" class="newalbumbox">';
		content += '<input id="newalbum' + artistID + '" name="newalbum" size="15" type="text" placeholder="Album Name">';
		content += '<input id="newalbumyr' + artistID + '" name="newalbumyr" maxlength="4" size="4" type="text" placeholder="Year">';
		content += '<input id="newalbumimg' + artistID + '" name="newalbumimg" size="20" type="text" placeholder="Album Image File (JPEG)">';
		content += '<button type="submit" submit-genreid='+genreID+' submit-artistid="' + artistID + '">Save</button></div>';
		content += '</div></section>';
		return content;
	};
	
	// Change the "Add an Album" prompt to input boxes, or visa versa
	function toggleAddAlbum(artistId) {
		if ($("a[data-artistid=" + artistId + "]").text() === "+") {	// When the '+' shows and is clicked,
			$("a[data-artistid=" + artistId + "]").text("-");			// change the '+' to '-' and show the box
			$("h3[header-artistid=" + artistId + "]").hide();
			$("div[inputs-artistid=" + artistId + "]").show();
		} else {
			$("a[data-artistid=" + artistId + "]").text("+");
			$("h3[header-artistid=" + artistId + "]").show();
			$("div[inputs-artistid=" + artistId + "]").hide();				
		}
	};
	
	function showArtists() {
		var content = '<div class="tab-content">';
		$.each(genres, function (index, value) {
			 content += '<div class="tab-pane row" id="genre'+genres[index].idgenres+'">';
			 if (genres[index].artists) {
			   $.each(genres[index].artists, function (index2, value2) { 
			      content += '<article class="span4 hero-unit">';
				  content += '<h2>'+genres[index].artists[index2].artist+'</h2>';
				  content += '<img src="php/utils/get-artist-image.php?id='+index2+'" />';
				  content += '</article>';
				  content += showAlbums(index,index2);
			   });
			 }
    	     content += '</div>';
		});
  		content += '</div>';
		$("#genredisplay").append(content);
		$("#genredisplay div.tab-content div.tab-pane:first").addClass("active");
		$("article.album").unbind('click');  // Make sure there are no other event handlers tied to this tag
		$("article.album").click(function(e) {  // When an album is clicked, show tracks
			showTracks($(this).attr('data-genreid'),$(this).attr('data-artistid'),$(this).attr('data-albumid'));
		});
		// Handler to toggle 'Add Album' input fields
		$("div.albumadd a").unbind('click');
		$("div.albumadd a").click(function(e) {		// When Add an Album '+' is clicked, show the input fields
			// 'this' is the whole anchor tag, i.e. <a data-genreid=​"1" data-artistid=​"1" id=​"plusalbum1">​+​</a>​
			toggleAddAlbum($(this).attr('data-artistid'));
		});
		
		// Event Handler for New Album Submit Button click
		// This routine adds a new album to the DB and to the DOM (page)
		// It also detects when no albums currently exists, and adds the "albums" object to the current artist
		$('div.newalbumbox button[type="submit"]').unbind('click');
		$('div.newalbumbox button[type="submit"]').click(function() {
			// 'this' is the submit buttom DOM (i.e. <button type=​"submit" submit-artistid=​"1">​Save​</button>​)
			var artistId = $(this).attr("submit-artistid"),
				genreId = $(this).attr("submit-genreid"),
				albumsNew = {};		// Object to use to create new album set, when artist album set is empty
		
			$.ajax({
				type: "POST",	// Send input data to PHP prog. that puts it into MySQL DB
				url: "php/new-album.php",
				data : { 
					artistId: artistId,
					album: $('input[id="newalbum' + artistId + '"]').val(),
					releaseYear: $('input[id="newalbumyr' + artistId + '"]').val(),
					albumImg: $('input[id="newalbumimg' + artistId + '"]').val()
				}
			}).done(function(data) {	// Update the Page at the same time
				var newAlbum = {
					artists_idartists : artistId,
					idalbums : data, 
					album : $('input[id="newalbum' + artistId + '"]').val(),
					release_year : $('input[id="newalbumyr' + artistId + '"]').val(),
					img_file : $('input[id="newalbumimg' + artistId + '"]').val()
				};
//			console.log("Ajax Done is finished. Data (idalbums)=" + data);

			// music[] is the global object representation of the whole database in browser memory
			// -> add the new album data here			
			if (!(music[genreId].artists[artistId].albums)) {  // albums not part of this artist's object
				music[genreId].artists[artistId].albums = {};  // ... make a new "albums set" Object
			}
			music[genreId].artists[artistId].albums[data] = newAlbum;

			toggleAddAlbum(artistId);
			// addAlbumToPage(genreId, artistId, albumId)
			addAlbumToPage(genreId, artistId, data); 
	  		});
		});  
	};
	
	function showGenres() {
		var content = '<div id="genredisplay" class="tabbable">'; 
        content += '<ul class="nav nav-tabs">';
		$.each(genres, function (index,value) {
			content += '<li><a href="#genre'+genres[index].idgenres+'" data-toggle="tab">'+genres[index].genre+'</a></li>';
		});  
		content += '<li><a href="#addgenre" data-toggle="modal"><i class="icon-plus"></i></a></li>'; 
        content += '</ul>';  		     
		content += '</div>';
		
		$("#genre").html(content);
		$("#genredisplay ul li:first").addClass("active");
		showArtists();
		
		$("#newgenre").unbind("click");  // Make sure there are no other events tied to this tag
		$("#newgenre").click(function() {
		$.ajax({
		    type: "POST",
		    data: {genre:$("#newgenrename").text()},
		    url: "php/new-genre.php"
		  }).done(function(data) {
		    music = getMusic();  // When done, we do what we do when we first load the page
		    showGenres();        // It's eavy handed, because we re-load the DB and rebuild the page
		    $("#addgenre").modal("hide");  // Then, close the modal
			$("#data-update").show();
		  });
		});
		$('ul.nav-tabs a[data-toggle="tab"]').on('shown', function (e) { 
			$("#track").html("");
		})
	};

	$("#data-update").hide();
	$("#addtrack").modal("hide");
	var music = getMusic();
	showGenres();
	console.log(music);	  // Shows up in console as an Object
});