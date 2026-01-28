setInterval(loginPage,120000);

var login = document.getElementById("login-form");
login.addEventListener("submit", loginHandler);

var uname = document.getElementById("uname");
uname.addEventListener("blur", unameHandler);

var pwd = document.getElementById("pass");
pwd.addEventListener("blur", passHandler);



