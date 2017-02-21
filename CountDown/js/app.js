var countDownDate = new Date("April 7, 2017").getTime();

//update the count down every 1 second

var x = setInterval(function() {
	// body...
	//get todays date
	var now = new Date().getTime();

	//find distance between now and the count down date
	var distance = countDownDate - now;

	//time calculations ffor days, minutes, seconds

	var days = Math.floor(distance/(1000 * 60 * 60 * 24));

	var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

	var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 *60));

	var seconds = Math.floor((distance % (1000 * 60 ))/ 1000);

	// display the result in an element with id

	document.getElementById("demo").innerHTML = days + " Days ||  " + hours+ " Hours ||  " +minutes+ " Mins ||  " +seconds+ " Seconds ";

	if (distance < 0) {
		clearInterval(x);
		document.getElementById("demo").innerHTML ="WE MADE IT FINALLY! GO RULE YOUR WORLD!";
	}
}, 1000);