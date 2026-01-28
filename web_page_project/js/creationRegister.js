var creation = document.getElementById("feedback-creation-form");
creation.addEventListener("submit", feedbackHandler);

var words = document.getElementById("feedback");
words.addEventListener("input",limitWords);

var form = document.getElementById("creation-form");
form.addEventListener("submit", creationHandler);

var asgn = document.getElementById("asgn");
asgn.addEventListener("blur", asgnHandler);

var course = document.getElementById("course");
course.addEventListener("blur", courseHandler);

var due = document.getElementById("due");
due.addEventListener("blur", dueDateHandler);

var instructor = document.getElementById("instructor");
instructor.addEventListener("blur", instructorHandler);

var status = document.getElementById("status");
status.addEventListener("blur", statusHandler);