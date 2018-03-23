var allowedErrors = new Array(3, 2, 1);

var score = 0;

function displayAssociatedDiagnosis(imageID, leftX, topX) {
	for (var i = 0; i < imageList.length; i++) {
		if (imageList[i].imageID == imageID) {
			$('#responseFeedback').html("What the hell were you thinking?  This image represents <b>" + imageList[i].diagnosis + "</b>");
			$('#responseFeedback').css({
				"display": "block",
				"left": leftX,
				"top": topX
			});
		}
	}
	return "";
}

/*
function checkIfCorrect(imageID) {
	correctImage = getCorrectImage();
	console.log("CORRECT: " + correctImage.imageID);
	if (correctImage != null) {
		if (correctImage.imageID == imageID) {
			return true;
		}
	}
	return false;
}*/

function checkIfCorrect(imageID) {
	correctImageList = getCorrectImageList();
	for (var i = 0; i < correctImageList.length; i++) {
		if (correctImageList[i].imageID == imageID) {
			console.log("CORRECT: " + correctImageList[i].imageID);
			return true;
		}
	}
	return false;
}


function getCorrectImage() {
	for (var i = 0; i < imageList.length; i++) {
		if (imageList[i].isCorrect) {
			return imageList[i];
		}
	}
	return null;
}

function getCorrectImageList(){
	correctImageList = new Array();
	for (var i = 0; i < imageList.length; i++) {
		if (imageList[i].isCorrect) {
			correctImageList.push(imageList[i]);
		}
	}
	return correctImageList;
}

function getDistractorImageList() {
	for (var i = 0; i < imageList.length; i++) {
		console.log(imageList[i].diagnosis);
	}
}


// This function gathers the userId, selectedImageID, and if the question was answered correctly or not and sends all of this information to the updatescore.php file to be input into the database.
function updateScoreData(attemptID, userID, questionID, selectedImageID, isCorrect, levelID, scoreRecieved) {
	var scoreData = {};
	scoreData.userID = userID;
	scoreData.selectedImageID = selectedImageID;
	scoreData.questionID = questionID;
        scoreData.scoreRecieved = scoreRecieved;
	
	if(isCorrect){
		scoreData.isCorrect = 1;	
	}
	else{
		scoreData.isCorrect = 0;
	}
		
	scoreData.attemptID = attemptID;
	scoreData.levelID = levelID;
	$.post("rest/updatescore.php", scoreData).done(function(data) {
		console.log("Data Loaded: " + data);
	});
}

function updateQuestionCompletion(attemptID, userID, questionID, levelID) {
	var scoreData = {};
	scoreData.userID = userID;
	scoreData.questionID = questionID;
	scoreData.attemptID = attemptID;
	scoreData.levelID = levelID;
	$.post("rest/updatequestioncomplete.php", scoreData).done(function(data) {
		console.log("Data Loaded: " + data);
	});
}



/** This function takes in the attempts, userID, and level ID
It proceeds to display the number of correct answers per level and the number of 
attempts you have tried.

If the number of correct attempts on any individual level meets a certain amount
designated by that level the user has won that level
**/

function getScoreData(attemptID, userID, levelID){
	var scoreData = {};
	scoreData.userID = userID;
	scoreData.levelID = levelID;
	scoreData.attemptID = attemptID;
	$.post("rest/getscore.php", scoreData).done(function(data) {
		var jsonData = JSON.parse(data);
		console.log(JSON.parse(data));
		var numberCorrect = 0;
		var questionsCompleted = jsonData.questionComplete.length;
		for(var i = 0; i<jsonData.score.length; i++){
			if(jsonData.score[i].isCorrect == 1){
				numberCorrect++;
                                score += +parseInt(jsonData.score[i].scoreRecieved);
			}
		}

		//score = numberCorrect * pointMultiplier;
		$('#scoreDisplay').html("Number of attempts on Level " + levelID + ": " + jsonData.score.length + ". Questions completed: " + questionsCompleted + ". Correct choices: " + numberCorrect + ". Your score: " + score);
		
		var numberIncorrect = jsonData.score.length - numberCorrect;
		console.log("ALLOWED: " + allowedErrors[levelID - 1]);
		console.log("INCORRECT: " + numberIncorrect);
		if(allowedErrors[levelID - 1] <= numberIncorrect){
			alert("You screwed up, we are kicking you out. Your final score was " + score);
			document.location.href = "gameattempt.php?levelID="+levelID;
		}
		
		else{
			if(levelID == 1 && questionsCompleted == 8){
				if (numberIncorrect == 0){
                                        setSession("levelAccess", "level2.php");
                                        updateScoreData(attemptID, userID, "bonus", "none", 1, levelID, 1000)
					score += 1000;
					alert("You have passed Level 1 and gotten a perfect score, here is a bonus!!! Your score now is " + score);
					document.location.href = "level2.php";
				}else{
                                        setSession("levelAccess", "level2.php");
					alert("You have passed Level 1!");
					document.location.href = "level2.php";
				}
			}
			if(levelID == 2 && questionsCompleted == 6){
				if (numberIncorrect == 0){
                                        setSession("levelAccess", "level3.php");
                                        updateScoreData(attemptID, userID, "bonus", "none", 1, levelID, 3000);
					score += 3000;
					alert("You have passed Level 2 and gotten a perfect score, here is a bonus!!! " + score );
					document.location.href = "level3.php";
				}else{
                                        setSession("levelAccess", "level3.php");
					alert("You have passed Level 2!");
					document.location.href = "level3.php";
				}
			}
			
			// Level 3 actually has 3 "questions", but each of those questions contains 6 individual questions
			if(levelID == 3 && questionsCompleted == 18){
				if (numberIncorrect == 0){
                                        setSession("levelAccess", "win.php");
                                        updateScoreData(attemptID, userID, "bonus", "none", 1, levelID, 5000);
					score += 5000;
					alert("You have passed Level 3 and gotten a perfect score, here is a bonus!!! " + score );
					document.location.href = "win.php";
				}else{
                                        setSession("levelAccess", "win.php");
					alert("You have passed Level 3!");
					document.location.href = "win.php";
				}
			}
		}
		
	});
}



// This function allows a user to zoom in on a picture
function showImagePreview(imagePath) {
	$('#overlay').append("<div id='zoomControls'><input type='button' id='btnCloseZoom' value='Close'></div>");
	$('#overlay').append("<img src= '" + imagePath + "' alt='Test Image' title='Test Image' style='width: 100%;' />");
	$('#overlay').css({
		'display':'block',
		'width': '80%',
		'height': '80%',
		'position': 'fixed',
		'top': '50%',
		'left': '50%',
		'transform': 'translate(-50%, -50%)'
	});
	
	$('#zoomControls').css({
		'text-align' : 'right'
	});
	
	$('#btnCloseZoom').click(function(){
		$('#overlay').empty();
		$('#overlay').css({
			'display':'none'
		});
	});
}

function setSession(name, value) {
    var sendData = {};
	sendData.name = name;
	sendData.value = value;
    $.post("rest/setsession.php", sendData).done(function() {
                
                
    });
}

// Hides the play link if user is engaged within a level of the game
function hidePlay(){
	if(pageTitle == "Level 1" || pageTitle == "Level 2" || pageTitle == "Level 3"){
	document.getElementById("playGame").style.visibility = "hidden";
	}
}

//gets top five scores for leaderboard
function getTopFive(){
	var sql = "SELECT userID,scoreRecieved FROM dentalgame.score ORDER BY scoreRecieved DESC LIMIT 5;";
	var targetDiv = document.getElementById("standings");
	var tableName = "";
	    jQuery.ajax({
        type: "GET",
        url: "rest/resultstojson.php?sql=" + sql,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data, status, jqXHR) {
			targetDiv.innerHTML=("<table>");
			targetDiv.innerHTML+=("<tr><td>User ID</td><td>Score</td></tr>");
			for(i=0; i<data.length; i++){
			targetDiv.innerHTML+=("<tr><td>"+data[i].userID+"</td><td>"+data[i].scoreRecieved+"</td></tr>");
			targetDiv.innerHTML+=("</n>");
			}
			targetDiv.innerHTML+=("</table>");
        },
        error: function(jqXHR, status) {
            console.log(status);
        }
    });
}