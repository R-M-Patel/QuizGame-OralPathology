<?php
require("classes/security.php");
require("classes/dbutils.php");
require("classes/question.php");

$pageTitle = "Practice";
require("header.php");

$_SESSION["gameAttemptID"] = uniqid();
?>

<h1> University of Pittsburgh </br> Dental School Pathology Game </h1>
<!-- This is the title of the game -->
<h2>Practice</h2>

<div id='categoryPicker'>
  <form>
    <h3> Choose from the following categories to practice your skills:</h3>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            
            <input type='checkbox'  value="1" id="BLT"/>
            <label for='BLT' class='practiceCategoryLabel'>Bone Lesions/ Tumors</label>
            <br />
        
            <input type='checkbox'  value='2' id="dentAnom"/>
            <label for='dentAnom'  class='practiceCategoryLabel'>Dental Anomalies</label>
            <br />    
        
            <input type='checkbox'  value='3' id="odon"/>
            <label for='odon' class='practiceCategoryLabel'>Odontogenic Cysts/Tumors</label>
            <br />
            
        
            <input type='checkbox'  value='4' id="soft"/>
            <label for="soft" class='practiceCategoryLabel'>Soft Tissue Lesions/Tumors</label>
            <br />
        
            <input type='checkbox'  value='6' id="devAbn"/>
            <label for="devAbn" class='practiceCategoryLabel'>Developmental Abnormalities</label>
            <br />
            
            <input type='checkbox'  value='7' id="rad"/>
            <label for="rad"  class='practiceCategoryLabel'>Radiology</label>
            <br />
        
            <input type='checkbox'  value='8' id="salivary"/>
            <label for="salivary" class='practiceCategoryLabel'>Salivary</label>
            <br />
            
            <input type='checkbox'  value='9' id="syndromes"/>
            <label for="syndromes" class='practiceCategoryLabel'>Syndromes</label>
            <br />
            
            <input type='checkbox'  value='10' id="benign"/>
            <label for="benign" class='practiceCategoryLabel'>Benign Fibro-osseous Lesions</label>
            <br />
        
            <input type='checkbox'  value='5' id="other"/>
            <label for="other" class='practiceCategoryLabel'>Other</label>
        </div>
        
    </div><!--end category row-->

    
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div align='center' class='submit'><input type='button' value='Let&#39;s begin!' id='btnPractice' class='btn btn-default'></div>
      </div>
    </div>

    </form>
</div><!--end category picker-->



<?php
require("footer.php");
?>

<script type="text/javascript">
    var correctAns;
    var questionData = {};
    var distractorData = {};
    var numAnswered = 0;
    var numQs = 4; // use this to change number of images displayed
    var questionArray = [];

    $(document).ready(function(){
        $('#btnPractice').click(function(){ //if button is clicked
            if (!$('input[type=checkbox]:checked').length) { //if no categories are selected
                alert("Please select at least one category.");
            }
            else{
                var categoryList = "";
                $('input[type=checkbox]').each(function () {
                    if(this.checked){
                        // categoryObject[$(this).attr("id")] = $(this).val();
                        if(categoryList == ""){
                            categoryList += $(this).val();
                        }
                        else{
                            categoryList += "," + $(this).val();
                        }
                    }
                });
                
                document.location.href = "level1.php?practiceCategories=" + categoryList;
            }
            
        });
    });
    
 
</script>
