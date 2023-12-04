

function showResult(searchValue) {

    if (searchValue.length == 0) {
        document.getElementById("livesearch").innerHTML = "";
        document.getElementById("livesearch").style.border = "0px";
        return;
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("livesearch").innerHTML = this.responseText;
            document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
        }
    };

    xmlhttp.open("GET", "livesearch.php?q=" + encodeURIComponent(searchValue), true);
    xmlhttp.send();
}

function categKontr(){
    let username = document.getElementById("categname").value;
    let error = document.getElementById("categ-error");
    if (!username) {
        error.innerHTML = "name field is empty!";
        return false;
    } else if (username.length < 3 || username.length > 30 || !/^[a-zA-Z]+$/.test(username)) {
        error.innerHTML = "name field should be between 3 and 30 characters and should contain only letters!";
        return false;
    }
    error.innerHTML = "";
    console.log("userjedna");
    return true;

}
function upCategKontr(){
    let username = document.getElementById("categname2").value;
    let error = document.getElementById("upcateg-error");
    if (!username) {
        error.innerHTML = "name field is empty!";
        return false;
    } else if (username.length < 3 || username.length > 30 || !/^[a-zA-Z]+$/.test(username)) {
        error.innerHTML = "name field should be between 3 and 30 characters and should contain only letters!";
        return false;
    }
    error.innerHTML = "";
    console.log("userjedna");
    return true;

}

function userKontr() {
    let username = document.getElementById("username").value;
    let error = document.getElementById("username-error");
    if (!username) {
        error.innerHTML = "name field is empty!";
        return false;
    } else if (username.length < 3 || username.length > 30 || !/^[a-zA-Z]+$/.test(username)) {
        error.innerHTML = "name field should be between 3 and 30 characters and should contain only letters!";
        return false;
    }
    error.innerHTML = "";
    console.log("userjedna");
    return true;

}



function passKontr() {
    let password = document.getElementById("password_reg").value;
    let com_password = document.getElementById("cam_password_reg").value;
    let error = document.getElementById("password-error");
    if (!password) {
        error.innerHTML = "Password field is empty!";
        return false;
    } else if (password.length < 3 || password.length > 30) {
        error.innerHTML = "Password field should be between 3 and 30 characters!";
        return false;
    }else if(password !== com_password) {
        error.innerHTML = "Password does not match!";
        return false;
    }
    error.innerHTML = "";
    console.log("passjedna");
    return true;
}


function nameKontr() {
    let name = document.getElementById("Firstname").value;
    let error = document.getElementById("name-error");
    if (name.length > 30 || !/^[a-zA-Z]+$/) {
        error.innerHTML = "Name field should not exceed 30 characters and should contain only letters!";
        return false;
    }
    error.innerHTML = "";
    console.log("namejedna");
    return true;

}

function ageKontr() {
    let age = document.getElementById("age").value;
    let error = document.getElementById("age-error");
    if (!age) {
        error.innerHTML = "Age field is empty!";
        return false;
    } else if (age < 14 ) {
        error.innerHTML = "Age should be greater then 14 years old!";
        return false;
    }
    error.innerHTML = "";
    console.log("agejedna");
    return true;

}



function mailKontr() {
    let email = document.getElementById("mail").value;
    let error = document.getElementById("email-error");
    if (!email) {
        error.innerHTML = "Email field is empty!";
        return false;
    } else {
        // Remove all illegal characters from email
        email = email.replace(/[^\w\d@._-]+/gi, "");
        // Validate email using a regular expression
        const emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!emailRegex.test(email)) {
            error.innerHTML = "Invalid email format";
            return false;
        }
    }
    error.innerHTML = "";
    console.log("mailjedna");
    return true;
}



function myFunction() {
    let i = localStorage.getItem("dark");
    let rez = document.querySelector(".linktheme");
    let image = document.querySelector("#rezim");
    if (i == 1){
        localStorage.setItem("dark", 0);
        rez.href = "../styles/root_black.css" ;
        image.src = "../images/zlustymesic.jpeg";
    } else{
        localStorage.setItem("dark", 1);
        rez.href = "../styles/root_white.css";
        image.src = "../images/cernymesic.jpeg";
    }
}

function setmyfunction(){
    let i = localStorage.getItem("dark");
    console.log(i);
    let image = document.querySelector("#rezim");
    let rez = document.querySelector(".linktheme");
    if (i == 1){
        rez.href = "../styles/root_white.css";
        image.src = "../images/cernymesic.jpeg";
    } else{
        rez.href = "../styles/root_black.css";
        image.src = "../images/zlustymesic.jpeg";
    }
}

setmyfunction();
var a = document.getElementById("rezim")

a.addEventListener("click", myFunction);

