$(document).ready(function () {
	//
	// Compare Arrival and Departure Dates, Add Message to Page
	//
	function dateCompare () {
		var monthArv = parseInt($("select#arv_mon").val(), 10) - 1,
			dayArv = parseInt($("select#arv_day").val(), 10),
			yearArv = parseInt($("select#arv_year").val(), 10),
			monthDep = parseInt($("select#dep_mon").val(), 10) - 1,
			dayDep = parseInt($("select#dep_day").val(), 10),
			yearDep = parseInt($("select#dep_year").val(), 10),
			arvDate = new Date(),
			depDate = new Date(),
			numDays;

		arvDate.setFullYear(yearArv,monthArv,dayArv);
		depDate.setFullYear(yearDep,monthDep,dayDep);
		numDays = Math.round((depDate - arvDate) / 60000 / 60 / 24);
		$("div#dateMsg").html('');

//		console.log ("Arrival: "+monthArv+"/"+dayArv+"/"+yearArv+", Depart: "+monthDep+"/"+dayDep+"/"+yearDep+", Arrive Date: "+arvDate+", Depart Date: "+depDate+", Number of Days: "+numDays);
		// Output a message under the Date Select fields
		if (arvDate >= depDate) {
			$("div#dateMsg").html('<h5>Please make sure departure date follows arrival date.</h5>');
		} else if (!isNaN(numDays)) {
			$("div#dateMsg").html('<h5 class="green_msg">Your stay is ' + numDays + ' nights.</h5>');
		}
	}
	//
	// ARRIVE DATE: Every time a month is selected, configure day select
	//
	$("#arv_mon").change(function () {
		var monthArv = parseInt($("select#arv_mon").val(), 10),
			dayAmt,
			ii;
		if ( monthArv === 4 || monthArv === 6 || monthArv === 9 || monthArv === 11 ) {
			dayAmt = 30;
		} else if ( monthArv === 2 ) {
			dayAmt = 29;
		} else {
			dayAmt = 31;
		}
		dateCompare();  // Compare Arrive and Depart Dates to ensure depart follows
//		console.log ("Month Num: " + monthArv + ", Number of Days: " + dayAmt);
		// Fill options for Day Select based on Month
		$("select#arv_day").html('<option value="">Day</option>');
		for (ii = 1; ii <= dayAmt; ii += 1) {
			$("select#arv_day").append('<option value="' + ii + '">' + ii + '</option>');
		}
	});
	//
	// ARRIVE DATE: Every time a day is selected, check to see if Date is Feb. 29
	// If so, configure Year select to show only leap years.
	//
	$("#arv_day").change(function () {
		var monthArv = parseInt($("select#arv_mon").val(), 10),
			dayArv = parseInt($("select#arv_day").val(), 10),
			yearIncr = 1,
			selectLeap = "Select",
			ii;
//		console.log ("Month Num: " + monthArv + ", Day Number: " + dayArv);

		dateCompare();  // Compare Arrive and Depart Dates to ensure depart follows
		// If Feb 29 is selected, force year options to be leap years
		if (monthArv === 2 && dayArv === 29) {
			yearIncr = 4;
			selectLeap = "Leap";
		}
		// Fill out select options for Year
		$("select#arv_year").html('<option value="">'+ selectLeap + ' Year</option>');
		for (ii = 2012; ii <= 2020; ii += yearIncr) {
			$("select#arv_year").append('<option value="' + ii + '">' + ii + '</option>');
		}
	});
	$("#arv_year").change(function () {
		dateCompare();  // Compare Arrive and Depart Dates to ensure depart follows
	});

	//
	// DEPART DATE: Every time a month is selected, configure day select
	//
	$("#dep_mon").change(function () {
		var monthDep = parseInt($("select#dep_mon").val(), 10),
			dayAmt,
			ii;
		if ( monthDep === 4 || monthDep === 6 || monthDep === 9 || monthDep === 11 ) {
			dayAmt = 30;
		} else if ( monthDep === 2 ) {
			dayAmt = 29;
		} else {
			dayAmt = 31;
		}

//		console.log ("Month Num: " + monthDep + ", Number of Days: " + dayAmt);

		dateCompare();  // Compare Arrive and Depart Dates to ensure depart follows

		// Fill options for Day Select based on Month
		$("select#dep_day").html('<option value="">Day</option>');
		for (ii = 1; ii <= dayAmt; ii += 1) {
			$("select#dep_day").append('<option value="' + ii + '">' + ii + '</option>');
		}
	});
	//
	// DEPART DATE: Every time a day is selected, check to see if Date is Feb. 29
	// If so, configure Year select to show only leap years.
	//
	$("#dep_day").change(function () {
		var monthDep = parseInt($("select#dep_mon").val(), 10),
			dayDep = parseInt($("select#dep_day").val(), 10),
			monthArv = parseInt($("select#arv_mon").val(), 10),
			dayArv = parseInt($("select#arv_day").val(), 10),
			yearArv = parseInt($("select#arv_year").val(), 10),
			startYear = yearArv,
			yearIncr = 1,
			selectLeap = "Select",
			ii;

		// If Feb 29 is selected, force year options to be leap years
		if (monthDep === 2 && dayDep === 29) {
			startYear = (yearArv + ((4 - yearArv%4) * (yearArv%4 !== 0)));
			yearIncr = 4;
			selectLeap = "Leap";
		}

//		console.log ("Month Num: " + monthDep + ", Day Number: " + dayDep + ", yearIncr: " + yearIncr);

		dateCompare();  // Compare Arrive and Depart Dates to ensure depart follows

		// Fill out select options for Year
		// If Depart earlier than arrive: Increment Start Year
		if ((monthDep < monthArv) || ((monthDep === monthArv) && (dayDep <= dayArv))) {
			if (yearIncr === 4) {
				startYear = ((yearArv + 1) + (4 - (yearArv + 1) % 4));  // Calc next leap year
			} else {
				startYear = yearArv + 1;
			}
		}
		$("select#dep_year").html('<option value="">'+ selectLeap + ' Year</option>');
		for (ii = startYear; ii <= startYear + 8; ii += yearIncr) {
			$("select#dep_year").append('<option value="' + ii + '">' + ii + '</option>');
		}
	});
	$("#dep_year").change(function () {
		dateCompare();  // Compare Arrive and Depart Dates to ensure depart follows
	});

	//
	// Handler when SEND button to be clicked: Collect FORM data for reservation, send to PHP handler
	//
	$("#send-reserv").click(function () {
		// Get the data from the form
		var contact,
			requests = [],
			arriveDate = "",
			departDate = "",
			monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			monthArv = monthArray[$("select#arv_mon").val() - 1],
			monthDep = monthArray[$("select#dep_mon").val() - 1];

		arriveDate = monthArv + " " + $("select#arv_day").val() + ", " + $("select#arv_year").val();
		departDate = monthDep + " " + $("select#dep_day").val() + ", " + $("select#dep_year").val();

//		console.log ("Arrive: " + arriveDate + ", Depart: " + departDate);

		$(".requests:checked").each(function (index) {
			requests[index] = $(this).closest('label').text();
//			requests[index] = $(this).text();
		});
		contact = {
			clientname : $("#clientname").val(),
			email : $("#clientemail").val(),
			phone : $("#clientphone").val(),
			arrival : arriveDate,
			departure : departDate,
			requests : requests
		};
//		console.log (contact);
		$.ajax({
			type : "POST",
			url : "php/send-reserv.php",  // location relative to page, not JS
			data : contact	// Put the data into the AJAX request
		}).done(function () {	// What do we want to do when AJAX request is sent
			alert("Your contact information has been sent. We will contact you soon.");
		});
//		alert(contact.clientname);
	});
});