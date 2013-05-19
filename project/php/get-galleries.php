<?php
// Create JSON string containing structured version of the whole galleries database
// healdsburggalleries.com php version is 5.3.13, as of Apr. 28, 2013
// This means that JSON_encode is available.

require_once("utils/dataconnector.php");

// Nested Queries to fetch Galleries table first,
// Then fetch connected logos, descriptions, and genres tables
if ($galleries = $mysqli->query("SELECT * from galleries order by gal_name"))  { 
	$gal_index = 1;
	while ($gallery = $galleries->fetch_object()) {  // fetch next gallery info set
//		$gal_array[$gallery->idgalleries] = $gallery;  assign gallery info set to array element
		$gal_array[$gal_index] = $gallery;  // assign gallery info set (alpha-sorted) to array element
		if ($contacts = $mysqli->query(   // Load contact info into local $contacts array
			"select idcontacts, cont_firstname, cont_lastname, cont_role, cont_phone1, cont_email
			from contacts 
			where fk_cont_galleries = " . $gallery->idgalleries
			)) {
			while ($contact = $contacts->fetch_object()) {
				$gal_array[$gal_index]->contacts[$contact->idcontacts] = $contact;
			}
			$contacts->close();
		}

		if ($logos = $mysqli->query(   // Load logo info into local $logos array
			"select idlogos, logo_title, logo_url
			from logos 
			where fk_logo_idgallery = " . $gallery->idgalleries
			)) {
			while ($logo = $logos->fetch_object()) {
				$gal_array[$gal_index]->logos[$gal_index] = $logo;  // $logo->idlogos
			}
			$logos->close();
		}

		if ($descs = $mysqli->query(   // Load logo info into local $logos array
			"select iddescriptions, desc_text
			from descriptions 
			where fk_desc_idgallery = " . $gallery->idgalleries
			)) {
			while ($desc = $descs->fetch_object()) {
				$gal_array[$gal_index]->descs[$gal_index] = $desc;
			}
			$descs->close();
		}
		
		if ($genres = $mysqli->query(   // Load genre category list into local $genres array
			"select idgenres, genre
			from genres, galgenre 
			where fk_idgalleries = " . $gallery->idgalleries . "
			and fk_idgenres = idgenres"
			)) {
			while ($genre = $genres->fetch_object()) {  // add indiv. genre sets to each gallery
				$gal_array[$gal_index]->genres[$genre->idgenres] = $genre;
			}
			$genres->close();  
		}
		$gal_index += 1;
	}
	$galleries->close();
}; 
$mysqli->close(); 

// JSON.php adds JSON capability for older versions of PHP (like on SRJC server)
// used instead of string json_encode(...) function in newer php's, >= ver. 5.2.0
 require_once('utils/JSON.php');
 $json = new Services_JSON;
 $gallery_db = $json->encode($gal_array);
// This is the code using json_encode - it works mostly, but drops five of
// the gallery descriptions. From it's manual: "This function only works with UTF-8 encoded data."
// Perhaps these five descriptions have UTF-16 chars that snuck in.
// $gallery_db = json_encode($gal_array, JSON_FORCE_OBJECT);
echo $gallery_db;	// Gallery DB is structured into an object and returned to Javascript

// By convention, pure php programs have no closing php tag