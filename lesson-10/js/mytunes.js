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
		var content = '<section class="tracks span12">';
	    content += '<h3>Tracks&nbsp;<a data-genreid='+genreID+' data-artistid='+artistID+' data-albumid='+albumID+'  id="plustrack"><i class="icon-plus"></i></a></h3>';

		$.each(music[genreID].artists[artistID].albums[albumID].tracks,function(index,value) {
			content += '<article data-trackid='+index+'>' + value.track_num + ": " + value.track + '</article>';
		});
		content += "</section>";
		$("#track").html(content);
				$("#plustrack").click(function() {
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
	$("#newtrack").click(function() {
		$.ajax({
			type: "POST",
			url: "php/new-track.php",
			data : { 
				albumid: $("#newtrack").attr("data-albumid"),
				track: $("#newtrackname").val(),
				track_num: $("#newtracknum").val()
			}
		}).done(function(data) {
			var newtrack = {
				albums_idalbums : $("#newtrack").attr("data-albumid"),
				idtracks : data, 
				track : $("#newtrackname").val(),
				track_num: $("#newtracknum").val()
			};
			music[$("#newtrack").attr("data-genreid")].artists[$("#newtrack").attr("data-artistid")].albums[$("#newtrack").attr("data-albumid")].tracks[data] = newtrack;
			$("#addtrack").modal("hide");
			showTracks($("#newtrack").attr("data-genreid"),$("#newtrack").attr("data-artistid"),$("#newtrack").attr("data-albumid"));
	  });
	});
	// Every time there is an artist, list their albums
	function showAlbums(genreID,artistID) {
		if (genres[genreID].artists[artistID].albums) {  // As long as an artist has an album...
			var content = '<section class="albums span7">';
			$.each( genres[genreID].artists[artistID].albums, function(index,value) {
				content += '<article class="album" data-genreid='+genreID+' data-artistid='+artistID+' data-albumid='+index+'>'; 
				content += '<img class="tn" src="php/utils/get-album-image.php?id='+index+'" />';	
				content += '<h5>'+value.album+'</h5>';	
				content += '</article>';
			});	
			content += '</section>';
		} else {
			content = "";
		}
		return content;
		
	}
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