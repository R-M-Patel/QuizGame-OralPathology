function currentDateTime() {
    var dateObject = new Date();
    var currentDateTime = dateObject.getFullYear();
    m = dateObject.getMonth();
    m = m + 1;
    currentDateTime += "-" + ('0' + m).slice(-2);
    currentDateTime += "-" + ('0' + dateObject.getDate()).slice(-2);
    currentDateTime += " " + ('0' + dateObject.getHours()).slice(-2);
    currentDateTime += ":" + ('0' + dateObject.getMinutes()).slice(-2);
    currentDateTime += ":" + ('0' + dateObject.getSeconds()).slice(-2);
    return currentDateTime;
}


function updateAccess(userID, attemptID, levelAccess) {
    var accessData = {};
    accessData.userID = userID;
    accessData.attemptID = attemptID;
    accessData.levelAccess = levelAccess;

    $.post("rest/updateaccess.php", accessData).done(function (data) {
        //console.log("Data Loaded: " + data);
    });
}

// This function gathers the userId, selectedImageID, and if the question was answered correctly or not and sends all of this information to the updatescore.php file to be input into the database.
function updateAnswerLog(attemptID, levelID, levelAttemptNumber, userID, questionID, selectedImageID, isCorrect) {
    var logData = {};
    logData.userID = userID;
    logData.selectedImageID = selectedImageID;
    logData.questionID = questionID;
    logData.attemptID = attemptID;
    logData.levelID = levelID;
    logData.levelAttemptNumber = levelAttemptNumber;
    if(isCorrect){
        logData.isCorrect = 1;    
    }
    else{
        logData.isCorrect = 0;
    }
    
    $.post("rest/updateanswerlog.php", logData).done(function (data) {
        console.log("Data Loaded: " + data);
    });
}

function updateScoreLog(attemptID, levelID, userID, levelAttemptNumber, isLevelComplete, finalLevelScore, numberQuestionsAnswered, numberCorrect, numberIncorrect) {
    
    var scoreData = {};
    scoreData.userID = userID;
    scoreData.attemptID = attemptID;
    scoreData.levelID = levelID;
    scoreData.levelAttemptNumber = levelAttemptNumber;
    scoreData.isLevelComplete = isLevelComplete;
    scoreData.finalLevelScore = finalLevelScore;
    scoreData.numberQuestionsAnswered = numberQuestionsAnswered;
    scoreData.numberCorrect = numberCorrect;
    scoreData.numberIncorrect = numberIncorrect;
    $.post("rest/updatescorelog.php", scoreData).done(function (data) {
        console.log("Data Loaded: " + data);
    });
}

function convertDate(givenDate){
    var tempDate = givenDate.split(/[- :]/);
    var javaDate = new Date(tempDate[0], tempDate[1]-1, tempDate[2], tempDate[3], tempDate[4], tempDate[5]);
    return javaDate;
}

function findDifference(endDate, startDate){
    var difference = (endDate.getTime() - startDate.getTime())/1000;
    return difference;
}

/** This function takes in the attempts, userID, and level ID
 It proceeds to display the number of correct answers per level and the number of
 attempts you have tried.

 If the number of correct attempts on any individual level meets a certain amount
 designated by that level the user has won that level
 **/

function getScoreData(attemptID, userID, levelID) {
    var scoreData = {};
    scoreData.userID = userID;
    scoreData.levelID = levelID;
    scoreData.attemptID = attemptID;
    $.post("rest/getscore.php", scoreData).done(function (data) {
        var jsonData = JSON.parse(data);
        // console.log(JSON.parse(data));
    });
}



// This function allows a user to zoom in on a picture **REPLACED BY INTENSIFY**
function showImagePreview(imagePath) {
    $('#overlay').empty();
    $('#overlay').append("<img src= '" + imagePath + "' alt='Test Image' title='Test Image' style='width: 100%;' />");
    $('#overlay').css({
        'position':'absolute',
        'display': 'block',
        'width': '100%',
        'height': '100%',
        'top': '0px',
        'left': '0px'
    });
    
    $('#overlay').click(function(){
        $('#overlay').css('display', 'none');
    });
}

function setSession(name, value) {
    var sendData = {};
    sendData.name = name;
    sendData.value = value;
    $.post("rest/setsession.php", sendData).done(function () {


    });
}


function getFileName() {
    // gets the full url
    var url = document.location.href;
    // removes the anchor at the end, if there is one
    url = url.substring(0, (url.indexOf("#") == -1) ? url.length : url.indexOf("#"));
    // removes the query after the file name, if there is one
    url = url.substring(0, (url.indexOf("?") == -1) ? url.length : url.indexOf("?"));
    // removes everything before the last slash in the path
    url = url.substring(url.lastIndexOf("/") + 1, url.length);
    return url;
}

// Hides the play link if user is engaged within a level of the game
function hidePlay() {
    if (getFileName() == "level1.php" || getFileName() == "level2.php" || getFileName() == "level3.php" || getFileName("win.php") || getFileName("caught_cheating.php")) {
        //document.getElementById("playGame").style.visibility = "hidden";
    }
}

//gets top five scores for leaderboard
function getTopFive() {
    var targetDiv = document.getElementById("standings");
	var stage = "TOPFIVE";
	var scoreData = {};
    scoreData.userID = stage;
    scoreData.levelID = stage;
    scoreData.attemptID = stage;
    $.post("rest/getscore.php", scoreData).done(function (data) {
        var jsonData = JSON.parse(data);
        //console.log(JSON.parse(data));
        for (var i = 0; i < jsonData.score.length; i++) {
			var uid = {};
			uid.ID=jsonData.score[i].userID;
			//$.post("rest/getuserlist.php", uid, function (dataArray) {
			//	var jsonData2 = JSON.parse(dataArray);
			//	targetDiv.innerHTML+= jsonData2[0].name + "<br>";
			//});
			targetDiv.innerHTML+= jsonData.score[i].Score + "<br>";
        }
	});
}


/****************************************************************
Added by Dmitriy as part of refactoring 05/20/2016
****************************************************************/
/*
This function retrieves a single question from the JSON array returned by the web service
and renders associated information on the screen, including:
    1. question text,
    2. hint (if there is a hint associated with the question)
    3. associated image
    4. distractor images
This function also sets properties and functionalities of image select buttons and image 
magnifiers
*/
function getQuestion(data){
    question = data; // data.questions[usedQuestionsCounter];
    // console.log(question);

    $('#questionText').html(question.diagnosisName + '<br />');

    // If there is no hint, do not even display the hint button
    if(question.hint.length <= 2){
        $('#hintButton').css("display", "none");
    }
    else{
        // If there is a hint, add a click event handler for the modal popup
        $('#hintButton').click(function(){
            showHint(question.hint)
        });
    }

    // Load images
    imageList = shuffle(question.imageList); // getQuestionImages(question, data.distractors); 
    // console.log(imageList);
    var imgIdx = 0;

    // Iterate through all image containers
    $('.imageContainer').each(function(index){
        if(imageList[imgIdx]){
            /****************************** 
            Set properties for the images
            ******************************/
            $img = $(this).children('.intense'); // Get image object

            /*
            $img.attr({
                "src" : imageList[imgIdx].fullThumbnailPath,    // set ID of the image
                "id" : "img_" + imageList[imgIdx].imageID,   // set image source (path to thumbnail)
                "title" : imageList[imgIdx].isCorrectChoice   // This line is for debugging only!!! 
            }); 
            */
            $img.attr({
                "src" : imageList[imgIdx].fullThumbnailPath,    // set ID of the image
                "id" : "img_" + imageList[imgIdx].imageID   // set image source (path to thumbnail)
                
            });
            
            $img.css({
                "border" : "1px solid #000000"   
            });
            
            // Create on-click event for zoom / preview functionality
            $img.click(function(){
                var largeImagePath = $(this).attr('src').replace("dentalthumbnails", "dentalimages");
                showImagePreview(largeImagePath);
            });
        

            /****************************** 
            End properties for the images
            ******************************/


            /****************************** 
            Set properties for the magnifying glass
            ******************************/
            $mag = $(this).children('.selectors').children('.magnify'); // Get magnifying glass object
            $mag.attr('id', "mag_" + imageList[imgIdx].imageID); // Set object ID
            /* 
                Create on-click event.  When user clicks on magnifying glass, 
                associated image is displayed full screen
            */  
            $mag.click(function(){
                var magGlassControlID = $(this).attr('id'); // Get ID of magnifying glass
                /*
                    The code below is a hack to deal with scope and lifecycle of jQuery
                    objects and event handlers.  All objects generated by this function have 
                    the same pattern for IDs - the type of object followed by underscore (_)
                    followed by the ID of the image that the object is connected to.
                    - Image: img_xxxxxxxxxxxxxxxxxxxxxx
                    - Magnifying glass: mag_xxxxxxxxxxxxxxxxxxxxxx
                    - Select button: sel_xxxxxxxxxxxxxxxxxxxxxx
                    In order to get the associated image, we split the ID of linked object
                    into an array - the second element of that array will always be the image ID
                */
                var imgControl = getImageFromControlID(magGlassControlID); 
                var largeImagePath = 
                    getImageFromControlID($(this).attr('id')).attr('src').replace("dentalthumbnails", "dentalimages");
                showImagePreview(largeImagePath);
            });
            /****************************** 
            End properties for the magnifying glass
            ******************************/


            /****************************** 
            Set properties for the select button
            ******************************/
            $sel = $(this).children('.selectors').children('.imageSelector');
            $sel.attr('id', "sel_" + imageList[imgIdx].imageID);
            $sel.css({
                "visibility" : "visible"
            });
            /****************************** 
            End properties for the select button
            ******************************/
            imgIdx = imgIdx + 1;
        } // end if valid image
    });

}


function highlightCorrectIncorrect(question){
    $('.imageSelector').css({
       "visibility" : "hidden" 
    });
    for(var i = 0; i<question.imageList.length; i++){
        if(question.imageList[i].isCorrectChoice){
            $('#img_' + question.imageList[i].imageID).css("border", "10px solid green");
        }
        else{
            $('#img_' + question.imageList[i].imageID).css("border", "10px solid red");
        }
    }
}

function showHint(hintText, isAnswerNotification){
    // alert(isAnswerNotification);
    $("#dialog-confirm").html(hintText);
    $("#dialog-confirm").dialog({
        title: 'Hint',
        resizable: false,
        closeOnEscape: true,
        open: function (event, ui) {
            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
        },
        height: 180,
        modal: true,
        buttons: {
            "Ok": function () {
                $(this).dialog("close");
            }
        }
    });
}
    
/*
Displays a jQueryUI modal popup to confirm whether an answer is correct
or incorrect
*/
function showAnswerConfirm(messageText, titleBarColor, titleText){
    $("#dialog-confirm").html(messageText);
    $("#dialog-confirm").dialog({
        title: titleText,
        resizable: false,
        closeOnEscape: true,
        open: function (event, ui) {
            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
        },
        height: 180,
        modal: true,
        show: 'fade',
        hide: 'fade',
        position: { my: "center", at: "center", of: window },
        buttons: {
            "Ok": function () {
                $(this).dialog("close");
                if(levelPassed){
                    var nextLevel = levelID + 1;
                    // document.location.href = "level" + nextLevel + "tutorial.php";
                }
                
                // Load next question
                if(levelID == 1){
                    initQuestion();    
                }
                
                
            }
        }
    }).prev(".ui-dialog-titlebar").css("background",titleBarColor);;
}

function showMessage(messageText){
    $("#dialog-confirm").html(messageText);
    $("#dialog-confirm").dialog({
        title: "Attention",
        resizable: false,
        closeOnEscape: true,
        open: function (event, ui) {
            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
        },
        modal: true,
        show: 'fade',
        hide: 'fade',
        position: { my: "center", at: "center", of: window },
        buttons: {
            "Ok": function () {
                $(this).dialog("close");
            }
        }
    }).prev(".ui-dialog-titlebar").css("background","blue");;
}

/*
Updates values displayed in the scoreboard
*/
function updateScoreBoard(){
    $('#divLevelAttempts').html("# Level Attempts: " + levelAttempts);
    $('#divQuestionsAnswered').html("Questions Completed: " + questionsCompleted);
    $('#divNumberCorrect').html("Number Correct: " + numberCorrect);
    $('#divCurrentScore').html("Your Score: " + currentScore);
}

/*
This function shuffles (randomly orders) values in an array passed as 
an argument.
The code from this function was copied from
http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
*/
function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}


/*
    All levels have a time-based performance bonus:
        a. Time-based bonus has an initial value declared in timeBonus global variable
        b. For each second spent on Level 1 learner loses 5 points from the time-based bonus
    */
    function updateTimeBonus(){
        timeBonus = timeBonus - 5;
    }

    /*
    This function is a hack to deal with scope and lifecycle of jQuery
    objects and event handlers.  All objects generated by this function have 
    the same pattern for IDs - the type of object followed by underscore (_)
    followed by the ID of the image that the object is connected to.
    - Image: img_xxxxxxxxxxxxxxxxxxxxxx
    - Magnifying glass: mag_xxxxxxxxxxxxxxxxxxxxxx
    - Select button: sel_xxxxxxxxxxxxxxxxxxxxxx
    In order to get the associated image, we split the ID of linked object
    into an array - the second element of that array will always be the image ID
    */
    function getImageFromControlID(controlID){
        var tmp = controlID.split('_');
        return $('#img_' + tmp[1]);
    }


    /*
    This function is a hack to deal with scope and lifecycle of jQuery
    objects and event handlers.  
    In order to get the associated image, we split the ID of select button 
    (HTML button used to select an image) into an array - the second element 
    of that array will always be the image ID.
    
    This function retuns an image object with all of its associated properties
    by matching the button ID to an ID of one of the images displayed on the screen
    */
    function getSelectedImageData(selObject){
        var tmp = selObject.attr('id').split('_');
        
        for(var i = 0; i<imageList.length; i++){
            // console.log(tmp[1] + ' = ' + imageList[i].id);
            if(tmp[1] == imageList[i].imageID){
                return imageList[i];
            }
        }
        return null;
    }


function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}


function countRedirect(){
    // Load next question
    $('.intense').css({
        "border" : "2px solid #000000"
    });
    if(levelPassed){
        document.location.href = "completedlevelsummary.php?levelID=" + levelID;
    }
    else{
        clearInterval(redirectTimerID);
        initQuestion();    
    }
}
