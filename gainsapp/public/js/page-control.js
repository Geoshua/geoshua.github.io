function toggleControl(divId) {
	var page = document.getElementById(divId);
	var divs = document.querySelectorAll(".page-container").forEach(function(pg){
		if(pg !== page) {
			pg.style.display = "none";
		}
	});
	page.style.display = "block";
}

function toggleActive(element){
	document.querySelectorAll(".active").forEach(function(btn){
		if(btn!== element) {
			btn.classList.remove("active");
		}
	});
	element.classList.add("active");
}

// When the user scrolls the page, execute myFunction
window.onscroll = function() {navSticky()};

// Get the navbar
var navbar = document.getElementById("topNav");


function navMedia() {
  var x = document.getElementById("topNav");
  if (x.className === "topNav") {
    x.className += " responsive";
  } else {
    x.className = "topNav";
  }
}