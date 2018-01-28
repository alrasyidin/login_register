var tabSwitch = document.querySelectorAll(".container .navigation span");
var tabbox = document.querySelectorAll(".container .tabbox");
var h1 = document.querySelector(".container h1");

for (var i = 0; i < tabSwitch.length; i++) {
	tabSwitch[i].addEventListener("click", function(e) {
		e.preventDefault();
		if (e.target.classList[0] == "navigation-login") {
			tabbox[0].style.display = "block";
			tabbox[1].style.display = "none";
			h1.textContent = ".:Login:."
			tabSwitch[0].classList.add("current");
			tabSwitch[1].classList.remove("current");
			
		}else if(e.target.classList[0] == "navigation-signup"){
			tabbox[0].style.display = "none";
			tabbox[1].style.display = "block";
			h1.textContent = ".:Sign Up:.";
			tabSwitch[0].classList.remove("current");
			tabSwitch[1].classList.add("current");
		}
	});
}


var input_field = document.querySelectorAll(".tabbox .input-field");

for (var i = 0; i < input_field.length; i++) {
	
	if(input_field[i].childNodes[1].value !== ""){
		input_field[i].childNodes[1].classList.add("hasvalue");
	}else{
		input_field[i].childNodes[1].classList.remove("hasvalue");
	}

	input_field[i].addEventListener("focusout", function(e){
		if (e.target.value === "") {
			e.target.classList.remove("hasvalue");
		}else{
			e.target.classList.add("hasvalue");
		}
	});
}



var buton_logout = document.querySelector(".box-logout a");


if(buton_logout){	
	buton_logout.onclick = function(){
		if( confirm("Are you sure want to quit now?") ){
			return true;
		}
		return false;
	}
}

let slider = document.querySelectorAll(".slideshow .slider .slide"),
	slideLeft = document.querySelector(".slideshow .arrow-left"),
	slideRight = document.querySelector(".slideshow .arrow-right"),
	current = 0;

function slideGerak(slide, nilai1, nilai2){
		slide.style.display = nilai1;
		slide.style.opacity = nilai2;
}

function reset(){
	for (var i = 0; i < slider.length; i++) {
		slideGerak(slider[i], "none", "0");
	}
}

if(slider.length !== 0){

	console.log(slider);
	slideGerak(slider[current], "block", "1");
	var auto = setInterval(function(){
		reset();
		
		current++;

		if(current > slider.length - 1){
			current = 0;
		}
		slideGerak(slider[current], "block", "1");
	}, 2000);


	slideLeft.addEventListener("click", function(){
		clearInterval(auto);
		reset();

		current--;

		if( current < 0 ){
			current = slider.length - 1;
		}
		
		slideGerak(slider[current], "block", "1");
		// console.log()
	});

	slideRight.addEventListener("click", function(){
		clearInterval(auto);
		reset();

		current++;

		if(current > slider.length - 1){
			current = 0;
		}

		slideGerak(slider[current], "block", "1");
	});	
}


var password = document.querySelector(".login .input-field i");
var input_pass = document.querySelector(".login .input-field input[type=password]");

// console.log(password);

if(password){
	password.onclick =  function(e) {
		e.preventDefault();
		
		if(!e.target.classList[2]){
			e.target.classList.add("switch");
			input_pass.setAttribute("type", "text");
		}else{
			e.target.classList.remove("switch");
			input_pass.setAttribute("type", "password");
		}
	}
}

var imageGallery = document.querySelectorAll(".gallery .gallery-img"),
	myModal = document.querySelector("#myModal"),
	modalImg = document.querySelector("#myModal .modal-content"),
	close = document.querySelector("#myModal .modal-close"),
	caption = document.querySelector("#myModal .modal-caption");


close.addEventListener("click", function(){
	myModal.style.display = "none";
})


if(imageGallery.length !== 0){
	for (var i = 0; i < imageGallery.length; i++) {
		imageGallery[i].addEventListener("click", function(){
			myModal.style.display = "block";

			var source = this.firstElementChild.src;
			source = source.replace("thumbnail/", "");

			modalImg.src = source;
			caption.innerHTML = this.firstElementChild.alt;
		});
	}
}

