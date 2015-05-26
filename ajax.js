function showMatch(matchId) {	
		
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("match").innerHTML = xmlhttp.responseText;
		}
	}	

	xmlhttp.open("GET","show_match.php?matchId="+matchId, true);
	xmlhttp.send();
}

function submitUserRating(matchId, userId, rating, ratingTime) {
	
	window.alert("Called submit rating with rating="+rating);	
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("match").innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("GET","handle_match_rating.php?skipped=false&matchId="+matchId+"&userId="+userId+"&rating="+rating+"&ratingTime="+ratingTime, true);
	xmlhttp.send();
}

function skipRating(matchId, userId) {	
		
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("match").innerHTML = xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET","handle_match_rating.php?skipped=true&matchId="+matchId+"&userId="+userId, true);
	xmlhttp.send();
}