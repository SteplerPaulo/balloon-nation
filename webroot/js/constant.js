if (document.location.hostname == "localhost" || document.location.hostname == "192.168.254.123"){
	var BASE_URL = '/balloon-nation/';
}else if(document.location.hostname == "http://www.balloonrep.tssi-erb.com/"){
	var	BASE_URL = 'http://www.balloonrep.tssi-erb.com/';
}else{
	var	BASE_URL = 'https://balloonrep.com/';
}
