// JavaScript Document for Healdsburg Galleries

$(document).ready(function() {

	var gallery_db,
		gallery_genres;

	// When page loads, download the whole database to make data access local and quick
	// Put whole database into JSON (javascript object), then traverse locally
	function getGalleries() {
		var galleries;
		$.ajax({
           type: "GET",
           url: "php/get-galleries.php",
           datatype: "json",
           async: false  // wait until full database is returned; not async here
		}).done(function(data) {
		   galleries = $.parseJSON(data);
		});
		return galleries;
	}
	// Put all Genres into an object, organized alphabetically
	function getGenres() {
		var genres;
		$.ajax({
           type: "GET",
           url: "php/get-genres.php",
           datatype: "json",
           async: false  // wait until full database is returned; not async here 
		}).done(function(data) {
		   genres = $.parseJSON(data);
		});
		return genres;
	}

	// Clean-up: Close any open gallery button-bar accordion
	function cleanupAccordions() {
		// First, add 'collapsed' class to remove bar styling (bootstrap neglects this in 'hide')
		// ==> '.in' class is only present on open accordion tab
		var openAccordion = $('.accordion-group').find('.in'),
			tabOpen = 0;

		if (openAccordion.hasClass('in')) {
			openAccordion.collapse('hide');
			openAccordion.parent().find('a').addClass('collapsed');
			tabOpen = 1;
		}
		return tabOpen;
	}

	// Build and place the galleries list filter selects
	function galleryFilter(genreTally) {
		var ii = 1,
			content = '<option value="0">All Galleries</option>';

		$.each(gallery_genres, function() {		// Maintain alphabetical sorting
			if (genreTally[gallery_genres[ii].idgenres]) {	// Only include in the menu, genres that are actually used
				content += '<option value="' + gallery_genres[ii].idgenres + '">' + gallery_genres[ii].genre + '</option>';
			}
			ii += 1;
		});
		$('#gal_filt').html(content);
	}

	// Place the gallery logo into an img tag for the page content
	function galleryLogo(index, value) {
		if (value.logos) {
			var content,
				logoUrl = value.logos[index].logo_url,  // value.idgalleries
				logoTitle = value.logos[index].logo_title;
			content = '<img src="images/logos/' + logoUrl + '" alt="' + logoTitle + '">';
			return content;
		}
	}

	// Build block with logo and genre list, called by galleryItem() and galleryDesc()
	function logoGenreBlock(index, value) {
		var contentGenre = '',
			content;
		
		content = '<div class="gal_logogenre"><div class="gal_logo">' + galleryLogo(index, value) + '</div>';
		content += '<div class="gal_genre_list"><p><em>';
		
		$.each(value.genres, function(indexGenre, valueGenre) {
			contentGenre += valueGenre.genre + ", ";
		});
		
		contentGenre = contentGenre.substr(0, contentGenre.length - 2)
		
		content += contentGenre + '</em></p></div></div>';
		
		return content;
	}

	// Build indiv. gallery tab information
	function galleryItem(index, value) {
		// Create Collapsing Accordian Button-bar Structure for Each Galery Listing
		var phone = "(" + value.gal_phone.substr(0,3) + ") " + value.gal_phone.substr(3,3) + "-" + value.gal_phone.substr(6,4),
			content = '<div id="gallery_info' + index + '" class="gal_info tab-pane">';  // Add CLASS active LATER

		// Address, Phone, URL, Logo content for each Gallery Listing
//		content += '<div class="gal_logo2">' + galleryLogo(index, value) + '</div>';
		content += logoGenreBlock(index, value);
		content += '<div class="gal_addr"><p>' + value.gal_addr1 + '<br />';
		if (value.gal_addr2) { content += value.gal_addr2 + '<br />'; }
		content += value.gal_city + ', ' + value.gal_state + ' ' + value.gal_zip + '<br />';
		content += '<a class="underline" href="tel:' + value.gal_phone + '">' + phone + '</a><br />';
		content += '<a class="underline" href="http://' + value.gal_url + '">' + value.gal_url + '</a></p></div>\n</div>';

		return content;
	}

	// "About Us" tab contents for each gallery. Contains Logo and description
	function galleryDesc(index, value) {
		var content = '<div id="gallery_desc' + index + '" class="tab-pane active">';

		content += logoGenreBlock(index, value);
		content += '<div class="gal_desc"><p>' + value.descs[index].desc_text + '</p>\n</div>\n</div>';

		return content;
	}

	// Produce collapse button-bar list of all galleries
	function galleryList() {
		var content = '<div class="accordion" id="gallery_list">',
			genreTally = [];

		// Tally up genres assigned to galleries - are any not used?
		$.each(gallery_db, function(indexGallery, valueGallery) {	// For each gallery, ...
			$.each(gallery_db[indexGallery].genres, function(indexGenre, valueGenre) {	// Check each genre for a match
				genreTally[indexGenre] = (genreTally[indexGenre]) ? (genreTally[indexGenre] + 1) : 1;
			});
		});

		galleryFilter(genreTally);  // Place the gallery list filter into the DOM, pass the tally list

		$.each(gallery_db, function(index, value) {
			// Set up each accordion button-bar group
			content += '<div class="accordion-group" data-galIndex=' + value.idgalleries + '>\n';
			content += '<div class="accordion-heading gallery_hdr">\n';
			// To remove accordian effect, remove this from the following line: data-parent="#gallery_list"
			content += '<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#gallery_list" href="#collapseGal' + index + '">';
			// Gallery name goes into the main button-bar
			content += value.gal_name + '</a>\n</div>\n';
			content += '<div id="collapseGal' + index + '" class="accordion-body collapse">\n';
			content += '<div class="accordion-inner tabbable">\n';

			// Construct inner gallery info tabs 
			if (value.descs[index].desc_text) {
				content += '<ul class="nav nav-tabs"><li class="active"><a href="#gallery_desc' + index + '" data-toggle="tab">About Us</a></li>';
			}
			content += '<li><a href="#gallery_info' + index + '" data-toggle="tab">Info</a></li>';
			content += '<li><a href="#gallery_map' + index + '" class="gal_map_tab" data-galindex="' + index + '" data-toggle="tab">Map</a></li>';
			content += '</ul>';
			// End of tab menu for each gallery listing

			// Build the content for each menu tab
			content += '<div class="tab-content">';	
			// This is the "About Us" tab content
			if (value.descs[index].desc_text) {
				content += galleryDesc(index, value);
			}
			// This is the "Info" tab: address, phone, logo, etc.
			content += galleryItem(index, value);
			// This is the gallery map tab content area
			content += '<div id="gallery_map' + index + '" class="gal_map tab-pane" style="width: 100%; height: 200px"></div>';

			content += '</div>\n</div>\n</div>\n</div>';
		});
		content += '</div>';
		// Place all the HTML contructed for the Galleries List into the DOM
		$("#gal_list").append(content);

		// Event Handler: Gallery Filter Select. When selection is made, show only galleries 
		// with matching genre selected.
		$('select#gal_filt').change(function() {
			var filtSelectIndex = $("select option:selected").attr('value'),
				tabOpen = cleanupAccordions(),   // Clean-up: Close any open gallery button-bar accordion
				timeout = (tabOpen === 0) ? 0 : 400;   // Time to hide transition end - if nothing was hidden, wait = 0

			setTimeout(function(){	// Wait for CSS hide transition to end

				if (filtSelectIndex > 0) {	// Any filter other than "All Galleries" chosen
					$('#gallery_list .accordion-group').hide();  // Hide all the galleries

					$.each(gallery_db, function(indexGallery, valueGallery) {	// For each gallery, ...
						$.each(gallery_db[indexGallery].genres, function(indexGenre, valueGenre) {	// Check each genre for a match
							if (valueGenre.idgenres === filtSelectIndex) {		// Show this gallery listing if genre matches
								$('#gallery_list div.accordion-group[data-galindex="' + valueGallery.idgalleries + '"]').show();
							}
						});
					});
				} else {	// "All Galleries" selected
					$('#gallery_list .accordion-group').show();  // Show all the galleries
				}

			}, timeout);
		});

		// Event Handler: Gallery Filter "Show All" button. When button is clicked, show all galleries 
		$('button#show_all').click(function() {
			var tabOpen = cleanupAccordions(),   // Clean-up: Close any open gallery button-bar accordion
				timeout = (tabOpen === 0) ? 0 : 400;   // Time to hide transition end - if nothing was hidden, wait = 0

			setTimeout(function(){	// Wait for CSS hide transition to end
				$('#gallery_list .accordion-group').show();	// Show all the galleries
				$("#gal_filt")[0].selectedIndex = 0;		// Reset filter to first option
			}, timeout);
		});
		
		// Event handler: Load the gallery map into the Map Tab when the tab is clicked	
		$(".gal_map_tab").click( function() {
			var galIndex = $(this).attr('data-galindex'),
				mapDiv = $(this).attr('href').slice(1),	// slice removes the leading # symbol
				locationGallery = new google.maps.LatLng(parseFloat(gallery_db[galIndex].gal_lat), parseFloat(gallery_db[galIndex].gal_long));

			$("#gallery_map" + galIndex).addClass('active');	// Unhide the tab to allow google maps to find it

			if (!$(mapDiv).html()) {	// Load the map only once, if map tab content is empty
				var map = new google.maps.Map(document.getElementById(mapDiv), {
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						center: locationGallery,
						zoom: 17
					}),
				// Place a marker at the gallery's location
					marker = new google.maps.Marker({
  	 		   	    	map: map,
  		  	   	    	position: locationGallery
					});
			}
		});
	}

	// Create a map for all the galleries on dedicated MAP page
	function galleriesMap() {
		var mapCenterLat = 38.6108,		// Centered on middle of Plaza
			mapCenterLong = -122.8701,
			mapCenter = new google.maps.LatLng(mapCenterLat, mapCenterLong),
			marker,
			map = new google.maps.Map(document.getElementById('map_galleries'), {
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: mapCenter,
					zoom: 15
			}),
			infowindow = new google.maps.InfoWindow();

		// Place a marker at each gallery's location
		$.each(gallery_db, function(index, value) {
			var locationGallery = new google.maps.LatLng(parseFloat(value.gal_lat), parseFloat(value.gal_long)),
				phone = "(" + value.gal_phone.substr(0,3) + ") " + value.gal_phone.substr(3,3) + "-" + value.gal_phone.substr(6,4);
			marker = new google.maps.Marker({
  		 	    map: map,
				position: locationGallery
			});
		
			// Add event handler for each marker to popup gallery information
			google.maps.event.addListener(marker, 'click', function () {
				var infoContent = value.gal_name + "<br />";
				infoContent += value.gal_addr1 + "<br />";
				infoContent += value.gal_city + ', ' + value.gal_state + ' ' + value.gal_zip + '<br />';
				infoContent += '<a class="underline" href="tel:' + value.gal_phone + '">' + phone + '</a><br />';
				infoContent += '<a class="underline" href="http://' + value.gal_url + '">' + value.gal_url + '</a>';

				infowindow.setContent(infoContent);
				infowindow.open(map, this);
			});
		});
	}

	// Event handler for Top Nav Tabs
	// For clicked tab, change to class 'active' (changes style) and 
	// hide all content then reveal selected DIV content
	$('#top_navbar li').click(function(e) {
		// 'this' is the selected list item. "$('a', this)" isolates the anchor tag
		e.preventDefault();  // Ignore default action to scroll down to top of selected DIV
		var newContentId = $('a', this).attr('href'),
			tabOpen = cleanupAccordions(),   // Clean-up: Close any open gallery button-bar accordion
			timeout = (tabOpen === 0) ? 0 : 400;   // Time to hide transition end - if nothing was hidden, wait = 0

		$('#top_navbar li').removeClass('active');  // Old nav button
		$(this).addClass('active');				    // New nav button

		setTimeout(function(){	// Wait for CSS hide transition to end to switch content DIVs
			$('.contents').hide();
			$(newContentId).show();

			if ((newContentId === '#gal_map') && (!$('map_galleries').html())) {
				galleriesMap();
			}
		}, timeout);
	});
	
	gallery_db = getGalleries();
	gallery_genres = getGenres();
	console.log(gallery_db);
//	console.log(gallery_genres);
	galleryList();

});