/*

    Validation function for all elements

*/
function validateName(name) {
	let nameRegEx = /^[a-zA-Z]+$/;

	if (nameRegEx.test(name))
		return true;
	else
		return false;
}

function validateCreation(name) {
    let nameRegex = /^.{1,50}$/;

    if (nameRegEx.test(name))
		return true;
	else
		return false;
}

function validateStatus(status) {
	let statusRegEx = /^[A-Z]{1,2}$/;

	if (statusRegEx.test(status))
		return true;
	else
		return false;
}

function validateUsername(uname) {
	let unameRegex = /^[a-zA-Z0-9_]+$/;

	if (unameRegex.test(uname)){
		return true;
	}
	else{
		return false;
	}
}

function validateEmail(email){
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailRegex.test(email)){
        return true;
    }
    else {
        return false;
    }
}

function validatePassword(password) {
	let passRegex = /^.{8}$/;

	if (passRegex.test(password)){
		return true;
	}
	else{
		return false;
	}
}

function validateRePassword(repassword, pass) {
    let repassRegex = /^.{8}$/;
	if (repassword === pass && repassRegex.test(repassword)){
		return true;
	}
	else {
		return false;
	}
}

function validateDateofBirth(date) {
	let DofBRegex = /^\d{4}[-]\d{2}[-]\d{2}$/

	if (DofBRegex.test(date)){
		return true;
	}
	else{
		return false;
	}
}

function validateAvatar(avatar) {
	let avatarRegex = /^[^\n]+\.[a-zA-Z]{3,4}$/;

	if (avatarRegex.test(avatar)){
		return true;
	}
	else{
		return false;
	}
}

function validateFeedback(feedback){
    let feedbackRegex = /^.{0,1500}$/;
    if (!feedbackRegex.test(feedback)){
        return false;
    }
    else {
        return true;
    }
}

/*

    Handler function for "Login Page".

*/
function loginHandler(event) {
	let uname = document.getElementById("uname");
	let pwd = document.getElementById("pass");
	let formValid = true;

    if (!validateUsername(uname.value)){
        uname.classList.add("invalid");
        document.getElementById("error-uname").classList.remove("hidden");
        console.log("'" + uname.value + "' is invalid!");
        formValid = false;
    }
    else {
        uname.classList.remove("invalid");
        document.getElementById("error-uname").classList.add("hidden");
    }

    if (!validatePassword(pwd.value)){
        pwd.classList.add("invalid");
        document.getElementById("error-pass").classList.remove("hidden");
        console.log("'" + pwd.value + "' is invalid!");
        formValid = false;
    }
    else {
        pwd.classList.remove("invalid");
        document.getElementById("error-pass").classList.add("hidden");
    }

    if (!formValid) {
		event.preventDefault();
        console.log("Validation is not successful!");
	} else {
		console.log("Validation is successful, sending data to the server");
	}
}

/*

    Handler function for all elements.

*/

function fnameHandler (event) {
    let first = document.getElementById("fname");
    if (!validateName(fname.value)){
        first.classList.add("invalid");
        document.getElementById("error-fname").classList.remove("hidden");
        console.log("'" + first.value + "' is invalid!");
    }
    else {
        first.classList.remove("invalid");
        document.getElementById("error-fname").classList.add("hidden");   
    }
}

function lnameHandler (event) {
    let last = document.getElementById("lname");
    if (!validateName(lname.value)){
        last.classList.add("invalid");
        document.getElementById("error-lname").classList.remove("hidden");
        console.log("'" + last.value + "' is invalid!");
    }
    else {
        last.classList.remove("invalid");
        document.getElementById("error-lname").classList.add("hidden");   
    }
}

function emailHandler (event) {
    let email = document.getElementById("email");
    if (!validateEmail(email.value)){
        email.classList.add("invalid");
        document.getElementById("error-email").classList.remove("hidden");
        console.log("'" + email.value + "' is invalid!");
    }
    else {
        email.classList.remove("invalid");
        document.getElementById("error-email").classList.add("hidden");   
    }
}

function unameHandler (event) {
    let uname = document.getElementById("uname");
    if (!validateUsername(uname.value)){
        uname.classList.add("invalid");
        document.getElementById("error-uname").classList.remove("hidden");
        console.log("'" + uname.value + "' is invalid!");
    }
    else {
        uname.classList.remove("invalid");
        document.getElementById("error-uname").classList.add("hidden");   
    }
}

function passHandler (event) {
    let pwd = document.getElementById("pass");
    if (!validatePassword(pwd.value)){
        pwd.classList.add("invalid");
        document.getElementById("error-pass").classList.remove("hidden");
        console.log("'" + pwd.value + "' is invalid!");
    }
    else {
        pwd.classList.remove("invalid");
        document.getElementById("error-pass").classList.add("hidden");   
    }
}

function repassHandler (event) {
    let repwd = document.getElementById("repass");
    if (!validateRePassword(repwd.value)){
        repwd.classList.add("invalid");
        document.getElementById("error-repass").classList.remove("hidden");
        console.log("'" + repwd.value + "' is not matched!");
    }
    else {
        repwd.classList.remove("invalid");
        document.getElementById("error-repass").classList.add("hidden");   
    }
}

function dofbHandler (event) {
    let dob = document.getElementById("DofB");
    if (!validateDateofBirth(dob.value)){
        dob.classList.add("invalid");
        document.getElementById("error-dofb").classList.remove("hidden");
        console.log("Date of birth is invalid!");
    }
    else {
        dob.classList.remove("invalid");
        document.getElementById("error-dofb").classList.add("hidden");   
    }
}

function avatarHandler (event) {
    let avatar = document.getElementById("avatar");
    if (!validateAvatar(avatar.value)){
        avatar.classList.add("invalid");
        document.getElementById("error-avatar").classList.remove("hidden");
        console.log("Avatar is invalid!");
    }
    else {
        avatar.classList.remove("invalid");
        document.getElementById("error-avatar").classList.add("hidden");   
    }
}

/*

    Handler function for "Sign up page".

*/

function signupHandler(event){
    let first = document.getElementById("fname");
    let last = document.getElementById("lname");
    let email = document.getElementById("email");
    let uname = document.getElementById("uname");
    let pwd = document.getElementById("pass");
    let repwd = document.getElementById("repass");
    let dob = document.getElementById("DofB");
    let avatar = document.getElementById("avatar");
    let formValid = true;

    if (!validateName(fname.value)){
        first.classList.add("invalid");
        document.getElementById("error-fname").classList.remove("hidden");
        console.log("'" + first.value + "' is invalid!");
        formValid = false;
    }
    else {
        first.classList.remove("invalid");
        document.getElementById("error-fname").classList.add("hidden");   
    }

    if (!validateName(lname.value)){
        last.classList.add("invalid");
        document.getElementById("error-lname").classList.remove("hidden");
        console.log("'" + last.value + "' is invalid!");
        formValid = false;
    }
    else {
        last.classList.remove("invalid");
        document.getElementById("error-lname").classList.add("hidden");   
    }
    
    if (!validateEmail(email.value)){
        email.classList.add("invalid");
        document.getElementById("error-email").classList.remove("hidden");
        console.log("'" + email.value + "' is invalid!");
        formValid = false;
    }
    else {
        email.classList.remove("invalid");
        document.getElementById("error-email").classList.add("hidden");   
    }
    
    if (!validateUsername(uname.value)){
        uname.classList.add("invalid");
        document.getElementById("error-uname").classList.remove("hidden");
        console.log("'" + uname.value + "' is invalid!");
        formValid = false;
    }
    else {
        uname.classList.remove("invalid");
        document.getElementById("error-uname").classList.add("hidden");   
    }
    
    if (!validatePassword(pwd.value)){
        pwd.classList.add("invalid");
        document.getElementById("error-pass").classList.remove("hidden");
        console.log("'" + pwd.value + "' is invalid!");
        formValid = false;
    }
    else {
        pwd.classList.remove("invalid");
        document.getElementById("error-pass").classList.add("hidden");   
    }
    
    if (!validateRePassword(repwd.value, pwd.value)){
        repwd.classList.add("invalid");
        document.getElementById("error-repass").classList.remove("hidden");
        console.log("'" + repwd.value + "' is not matched!");
        formValid = false;
    }
    else {
        repwd.classList.remove("invalid");
        document.getElementById("error-repass").classList.add("hidden");   
    }
        
    if (!validateDateofBirth(dob.value)){
        dob.classList.add("invalid");
        document.getElementById("error-dofb").classList.remove("hidden");
        console.log("Date of birth is invalid!");
        formValid = false;
    }
    else {
        dob.classList.remove("invalid");
        document.getElementById("error-dofb").classList.add("hidden");   
    }
        
    if (!validateAvatar(avatar.value)){
        avatar.classList.add("invalid");
        document.getElementById("error-avatar").classList.remove("hidden");
        console.log("Avatar is invalid!");
        formValid = false;
    }
    else {
        avatar.classList.remove("invalid");
        document.getElementById("error-avatar").classList.add("hidden");   
    }

    if (formValid === false){
        event.preventDefault();
        console.log("Validation is not successful!");
    }
    else{
        console.log("Validation successful, sending data to the server!");
    }
}

/*

    Handler function for "Feedback".

*/

function feedbackHandler(event){
    let comment = document.getElementById("feedback");
    let formValid = true;

    if (!validateFeedback(comment.value)){
        comment.classList.add("invalid");
        document.getElementById("error-feedback").classList.remove("hidden");
        console.log("Feedback is invalid!");
        formValid = false;
    }
    else {
        comment.classList.remove("invalid");
        document.getElementById("error-feedback").classList.add("hidden");   
    }

    if (!formValid){
        event.preventDefault();
    }
    else{
        console.log("Successfull");
    }
}

function limitWords() {
    const Length = 1500;
    let input = document.getElementById("feedback");
    let remain = document.getElementById("limit");

    let num = input.value;
    let numLength = num.length;
    let remChar = Length - numLength;

    remain.innerHTML = `${numLength}/${Length} characters<br>Remaining characters: ${remChar}`;
}


/*

    FOR CREATION PAGE

*/

function creationHandler (event) {
    let asgn = document.getElementById("asgn");
    let course = document.getElementById("course");
    let due = document.getElementById("due");
    let instructor = document.getElementById("instructor");
    let status = document.getElementById("status");
    let dataOK = true;

    if (!validateCreation(asgn.value)){
        asgn.classList.add("invalid");
        document.getElementById("error-asgn").classList.remove("hidden");
        console.log("'" + asgn.value + "' is invalid!");
        dataOK = false;
    }
    else {
        asgn.classList.remove("invalid");
        document.getElementById("error-asgn").classList.add("hidden");   
    }

    if (!validateCreation(course.value)){
        course.classList.add("invalid");
        document.getElementById("error-course").classList.remove("hidden");
        console.log("'" + course.value + "' is invalid!");
        dataOK = false;
    }
    else {
        course.classList.remove("invalid");
        document.getElementById("error-course").classList.add("hidden");   
    }

    if (!validateDateofBirth(due.value)){
        due.classList.add("invalid");
        document.getElementById("error-due").classList.remove("hidden");
        console.log("Due date is invalid!");
        dataOK = false;
    }
    else {
        due.classList.remove("invalid");
        document.getElementById("error-due").classList.add("hidden");   
    }

    if (!validateCreation(instructor.value)){
        instructor.classList.add("invalid");
        document.getElementById("error-instructor").classList.remove("hidden");
        console.log("'" + instructor.value + "' is invalid!");
        dataOK = false;
    }
    else {
        instructor.classList.remove("invalid");
        document.getElementById("error-instructor").classList.add("hidden");   
    }

    if (!validateStatus(status.value)){
        status.classList.add("invalid");
        document.getElementById("error-status").classList.remove("hidden");
        console.log("'" + status.value + "' is invalid!");
        dataOK = false;
    }
    else {
        status.classList.remove("invalid");
        document.getElementById("error-status").classList.add("hidden");   
    }

    if (!dataOK){
        event.preventDefault();
    }
    else{
        console.log("Successfull");
    }
}



function asgnHandler (event){
    let asgn = document.getElementById("asgn");
    if (!validateCreation(asgn.value)){
        asgn.classList.add("invalid");
        document.getElementById("error-asgn").classList.remove("hidden");
        console.log("'" + asgn.value + "' is invalid!");
        dataOK = false;
    }
    else {
        asgn.classList.remove("invalid");
        document.getElementById("error-asgn").classList.add("hidden");   
    }
}

function courseHandler (event){
    let course = document.getElementById("course");
    if (!validateCreation(course.value)){
        course.classList.add("invalid");
        document.getElementById("error-course").classList.remove("hidden");
        console.log("'" + course.value + "' is invalid!");
        dataOK = false;
}
    else {
        course.classList.remove("invalid");
        document.getElementById("error-course").classList.add("hidden");   
    }
}

function dueDateHandler (event){
    let due = document.getElementById("due");
    if (!validateDateofBirth(due.value)){
        due.classList.add("invalid");
        document.getElementById("error-due").classList.remove("hidden");
        console.log("Due date is invalid!");
        dataOK = false;
    }
    else {
        due.classList.remove("invalid");
        document.getElementById("error-due").classList.add("hidden");   
    }
}

function instructorHandler (event){
    let instructor = document.getElementById("instructor");
    if (!validateCreation(instructor.value)){
        instructor.classList.add("invalid");
        document.getElementById("error-instructor").classList.remove("hidden");
        console.log("'" + instructor.value + "' is invalid!");
        dataOK = false;
    }
    else {
        instructor.classList.remove("invalid");
        document.getElementById("error-instructor").classList.add("hidden");   
    }
}

function statusHandler (event){
    let status = document.getElementById("status");
    if (!validateStatus(status.value)){
        status.classList.add("invalid");
        document.getElementById("error-status").classList.remove("hidden");
        console.log("'" + status.value + "' is invalid!");
        dataOK = false;
    }
    else {
        status.classList.remove("invalid");
        document.getElementById("error-status").classList.add("hidden");   
    }
}


/*

    Function for Assignment 6 - Part A     

*/
function loginPage() {
    let xhr = new XMLHttpRequest();
    const maxDisplay = 5;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText){
                let asgArray = null;
				asgArray = JSON.parse(xhr.responseText);
				let asgDisplay = document.getElementById("display_login");
                asgDisplay.innerHTML = '';
			
                for (let i = 0; i < asgArray.length; i++){
                    let Object = asgArray[i];
                    let displayAsg = document.createElement("article");
                            
                    let asgn = document.createElement("p");
                    let assign = Object.asgn;
                    asgn.innerHTML = '<strong>'+ assign + '</strong>';
                    displayAsg.appendChild(asgn);

                    let link = document.createElement("button");
                    link.innerHTML = '<a href="detail_form.php">View</a>';
                    link.classList.add("status");
                    asgn.appendChild(link);

                    let due = document.createElement("p");
                        due.textContent = Object.due_date;
                        displayAsg.appendChild(due);

                        let course_inf = document.createElement("p");
                        course_inf.textContent = Object.instructor + " || " + Object.course;
                        displayAsg.appendChild(course_inf);

                        let fb = document.createElement("p");
                        fb.textContent = "Total feedbacks: " + Object.feedback_count;
                        displayAsg.appendChild(fb);

                        let status = document.createElement("p");
                        status.textContent = Object.status;
                        status.classList.add("status");
                        displayAsg.appendChild(status); 

                        asgDisplay.appendChild(displayAsg);
                    }
                    while (asgDisplay.children.length > maxDisplay){
                        asgDisplay.removeChild(asgDisplay.lastChild);
                    }
			} 
        }
    }
    xhr.open("GET", "ajax_backend_login.php", true);
	xhr.send();
}


function mainPage () {
    let xhr = new XMLHttpRequest();
    const maxDisplay = 20;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
            if(xhr.textContent){
				let asgArray = null;
				asgArray = JSON.parse(xhr.responseText);
				let asgDisplay = document.getElementById("display_main");
                asgDisplay.innerHTML = '';

                for (let i = 0; i < asgArray.length; i++){
                    let Object = asgArray[i];
                    let displayAsg = document.createElement("article");
                            
                    let asgn = document.createElement("p");
                    let assign = Object.asgn;
                    asgn.innerHTML = '<strong>'+ assign + '</strong>';
                    displayAsg.appendChild(asgn);

                    let link = document.createElement("button");
                    link.innerHTML = '<a href="detail_form.php">View</a>';
                    link.classList.add("status");
                    asgn.appendChild(link);

                    let due = document.createElement("p");
                        due.textContent = Object.due_date;
                        displayAsg.appendChild(due);

                        let course_inf = document.createElement("p");
                        course_inf.textContent = Object.instructor + " || " + Object.course;
                        displayAsg.appendChild(course_inf);

                        let fb = document.createElement("p");
                        fb.textContent = "Total feedbacks: " + Object.feedback_count;
                        displayAsg.appendChild(fb);

                        let status = document.createElement("p");
                        status.textContent = Object.status;
                        status.classList.add("status");
                        displayAsg.appendChild(status); 

                        asgDisplay.appendChild(displayAsg);
                    }
                    while (asgDisplay.children.length > maxDisplay){
                        asgDisplay.removeChild(asgDisplay.lastChild);
                    }
			} 
		}
	}
	xhr.open("GET", "ajax_backend_home.php", true);
	xhr.send();
}


/*

    Functions for Assignment 6 - Part B

*/
function detailPage() {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) { 
            if (xhr.responseText){
            let fbArray = null; 
            fbArray = JSON.parse(xhr.responseText);
            let fbDisplay = document.getElementById("feedback_box");
                fbDisplay.innerHTML = '';
                for (var i = 0; i < fbArray.length; i++) {
                    let Object = fbArray[i];
                    let display = document.createElement("p");
                    display.textContent = "- " + Object.time_stamp + ": " + Object.comment;
                    fbDisplay.appendChild(display);
                }
                let firstChild = fbDisplay.children[0];
                if (firstChild) {
                    firstChild.classList.add("highlight");
                    setTimeout(() =>{firstChild.classList.remove("highlight")}, 5000);
                }
                else {
                    console.log("No Feedbacks to be highlighted!");
                }
            }
        }
    }
    xhr.open("GET", "ajax_backend_detail.php", true);
	xhr.send();
}
