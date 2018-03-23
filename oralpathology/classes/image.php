<?php



class Image{
	/* Global variables */
	public $imageID = ""; //ID for the image
	public $imageFolder = ""; //name of folder the image is located
	public $imageName = ""; //Name of image
	public $fullThumbnailPath = ""; //full path to thumbnail
	public $fullImagePath = ""; //full path to image
	public $isCorrectChoice = false; //boolean to indicate that image is correct answer to question
	public $associatedDiagnosis = ""; //associated diagnosis for image
	public $hint = ""; //image hint

	/* constructor function for image */
	function __construct($_imageID, $_imageFolder, $_imageName, $_isCorrect, $_associatedDiagnosisID, $_associatedDiagnosis, $_hint){
		$this->imageID = $_imageID;
		$this->imageFolder = $_imageFolder;
		$this->imageName = $_imageName;
		$this->isCorrectChoice = $_isCorrect;
		$this->associatedDiagnosisID = $_associatedDiagnosisID; //Should this be a global variable?
        $this->associatedDiagnosis = $_associatedDiagnosis;
		$this->hint = $_hint;
		$this->fullThumbnailPath = "dentalthumbnails/" . $_imageFolder . "/" . $_imageName;
		$this->fullImagePath = "dentalimages/" . $_imageFolder . "/" . $_imageName;
		
	}
	
	public function getImageFullPath(){
		return $this->fullImagePath;
	}
	
	public function getThumbnailFullPath(){
		return $this->fullThumbnailPath;
	}
	
	public function isCorrectChoice(){
		return $this->isCorrectChoice;
	}
	
	public function getImageID(){
		return $this->imageID;
	}
	
	public function getAssociatedDiagnosis(){
		return $this->associatedDiagnosis;
	}
	
	public function getHint(){
		return $this->hint;
	}
	
	

}


?>