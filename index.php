<!DOCTYPE html>
<html>

<head>
	<title> Sign Up Page </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<div class="container">
		<h1 class="text-center">Sign Up Form</h1>
		<div class="card">
		<form id="signupForm" action="welcome.html">
			<div class="form-group">
				<label for="firstName">First Name</label>
				<input id ="firstName" type="text" class="form-control" name="fName" placeholder="Enter first name">
				<label for="firstName">Last Name</label>
				<input id="lastName" type="text" class="form-control" name="lName" placeholder="Enter last name">
				
				<div class="form-check">
					<input class="form-check-input" type="radio" name="gender" id="m" value="m">
					<label class="form-check-label" for="m">
						Male
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="gender" id="f" value="f">
					<label class="form-check-label" for="f">
						Female
					</label>
				</div>
			</div>
			<div class="form-group">
				Zip Code:   <input type="text" id="zip" class="form-control" name="zip">
                <span id="zipCodeError" class="text-danger text-center"><strong></strong></span></br>
				City:       <span id="city"></span><br>
				Latitude:   <span id="latitude"></span><br>
			    Longitude:  <span id="Longitude"></span><br>
			</div>
		    State:
		    <select multiple class="form-control" id="state" name="state"></select>
		    Select a County: <select multiple class="form-control" id="county"></select><br>
		    <div class="form-group">
			  <label for="username">Desired Username</label>
	          <input type="text" class="form-control" id="username" name="username"><br>
		      <span id="usernameError"></span><br>
		      <label for="password">Password</label>
	          <input type="password" class="form-control" id="password" name="password"><br>
	          <label for="password">Password Again</label>
	          <input type="password" class="form-control" id="passwordAgain" name="username"><br>
			  <span id="passwordAgainError" class="text-danger"></span>
		    </div>
		    <div class="row">
		    	<div class="col text-center">
		    		<input type="submit" class="btn btn-primary" value="Sign up!">
		    	</div>
		    </div>
		</form>
		</div>
		<br>
	</div>
    <script>
    	var usernameAvailable = false;
        $("#zip").on("change", async function(){
        let state = $("#state").val();
        let url = `https://cst336.herokuapp.com/projects/api/state_abbrAPI.php`;
        let response = await fetch(url);
        let data = await response.json();
        $("#state").html(`<option> Select one </option>`);
        for (let i=0; i < data.length; i++) {
            $("#state").append(`<option> ${data[i].usps} </option>`);
        }
    });
    	
    	//Displaying City from API after typing a zip code
    	$("#zip").on("change", async function(){
    		// alert($("#zip").val())
    		let zipCode = $("#zip").val();	
    		let url =  `https://itcdland.csumb.edu/~milara/ajax/cityInfoByZip?zip=${zipCode}`;
    		let response = await fetch(url);
    		let data = await response.json();
    		
            console.log(data);
            if(data == false) {
                $("#zipCodeError").html("Error, no zip code found");
            }
    		$("#city").html(data.city);
    		$("#latitude").html(data.latitude);
			$("#Longitude").html(data.longitude);
 
    	});//zip
    	$("#state").on("change", async function(){
    		// alert($("#state").val())
    		let state = $("#state").val();
    		let url = `https://itcdland.csumb.edu/~milara/ajax/countyList.php?state=${state}`;
    		let response = await fetch(url);
    		let data = await response.json();
    		console.log(data);
    		$("#county").html(`<option> Select one </option>`);
    		for (let i=0; i < data.length; i++) {
    			$("#county").append(`<option> ${data[i].county} </option>`);
    		}
    	});//State
    	$("#username").on("change", async function(){
    		// alert($("#username").val());
    		let username = $("#username").val();
    		let url = `https://cst336.herokuapp.com/projects/api/usernamesAPI.php?username=${username}`;
    		let response = await fetch(url);
    		let data = await response.json();
    		if (data.available) {
    			$("#usernameError").html("Username available!");
    			$("#usernameError").css("color","green");
    			usernameAvailable = true;
    		} else {
    			$("#usernameError").html("Username not available!");
    			$("#usernameError").css("color","red");
    			usernameAvailable = false;
    		}
    	});//Username
    	$("#signupForm").on("submit", function(e) {
    		// alert("Submitting form");
    		if(!isFormValid()) {
    		 e.preventDefault();
    	}
    	});
    	function isFormValid() {
    		isValid = true;
    		if(!usernameAvailable) {
    			isValid = false;
    		}
    		//Check if username is empty
    		if($("#username").val().length == 0) {
    			isValid = false;
    			$("#usernameError").html("Username is required");
    		}
    		//Check if passwords don't match
    		if($("#password").val() != $("#passwordAgain").val()) {
    			$("#passwordAgainError").html("Password Mismatch!");
    			isValid = false;
    		}
    		//Check if password is 6 characters long
    		if($("#password").val().length < 6) {
    			isValid = false;
    			$("#passwordAgainError").html("Password is less than 6 characters");
    		}
    		return isValid;
    	}
    </script>
    <footer>
        <p>@Copyright infringement and all that BS, CST 336 Lab3 - Nate Beal
    </footer>
</body>
</html>
