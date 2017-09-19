// Set the width of the side navigation to 250px

function openNav() {
	// body...
	document.getElementById("mysidenav").style.width = "250px";

	document.getElementById("main").style.marginLeft = "150px";

	document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

// Set the width of the side navigation to 0px and the background of main to white

function closeNav() {
	// body...

	document.getElementById("mysidenav").style.width = "0px";

	document.getElementById("main").style.marginLeft = "0px";

	document.body.style.backgroundColor = "white";

}