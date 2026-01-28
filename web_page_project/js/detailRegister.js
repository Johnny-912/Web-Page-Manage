setInterval(detailPage, 120000);

var detail = document.getElementById("feedback-detail-form");
detail.addEventListener("submit", feedbackHandler);

var words = document.getElementById("feedback");
words.addEventListener("input",limitWords);
