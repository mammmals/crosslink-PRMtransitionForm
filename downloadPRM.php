<?php 
/*
Developed by Devin K Schweppe (UW) and Jimmy K Eng (UWPR)

Copyright 2017 Bruce Lab, University of Washington

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
	set_time_limit(0);
	$crosslinker="";
	$reporter="";
	$XL_mod="";
	$stump_long="";
	$stump_short="";
	$lysine_mass=128.094963; //monoisotopic
	if($_POST['crosslinker']=="bdp") {
		$crosslinker=$_POST['crosslinker'];
		$reporter = 751.406065; //protonate form: 752.412356
		$stump_long = 948.4386001;
		$stump_short = $lysine_mass + 197.032422;
	} elseif($_POST['crosslinker']=="dsso"){
		$crosslinker=$_POST['crosslinker'];
		$reporter = 0;
		$XL_mod = 158.0048619;
		$stump_long = 85.98318412;
		$stump_short = $lysine_mass + 54.01111312;
	} else {
		$crosslinker=$_POST['crosslinker'];
		$reporter = 0; //needs updating
		$stump = 0; //needs updating
	}
	
	$precursorCharge="";
	if(isset($_POST['charge'])) {
		$precursorCharge=$_POST['charge'];
	}
	$peptideA="";
	if(isset($_POST['peptideA'])) {
		$peptideA=$_POST['peptideA'];
	}
	$peptideB="";
	if(isset($_POST['peptideB'])) {
		$peptideB=$_POST['peptideB'];
	}
	$pepSiteA="";
	if(isset($_POST['pepSiteA'])) {
		$pepSiteA=$_POST['pepSiteA'];
	}
	$pepSiteB="";
	if(isset($_POST['pepSiteB'])) {
		$pepSiteB=$_POST['pepSiteB'];
	}
	
	//If a file is uploaded, use it to make the PRM library
	$no_upload_file = 1; //1 when no file exists, 0 when file does exist.
	$uploaded_file="";
//NEED TO SPECIFY THE UPLOAD DIRECTORY
	$upload_dir = "";
	if($_FILES["prmTsvFile"]["size"] != 0) {
		$tmp_prm_file = $_FILES["prmTsvFile"]["tmp_name"];
		$uploaded_file= $upload_dir . basename($tmp_prm_file).".txt";
		move_uploaded_file($tmp_prm_file,$uploaded_file);
		$no_upload_file = 0;
	}

	//Determine parameters for each peptide
	$pepAMod="";
	if($_POST['pepAMod']=="userSelectAMod") {//for user modifications
		$pepAMod=$_POST['userPepAMod'];
	} elseif($_POST['pepAMod']=="acylC") {//for C mod only
		$pepA_C_count=substr_count($peptideA,"C");
		$modificationAA = "C";
		$pepA_C_position=0;
		$offsetA=0;
		$pepA_allCMods="";
		for ($i = 1; $i<=$pepA_C_count; $i++){
			$pepA_C_position=strpos($peptideA,$modificationAA,$offsetA);
			$offsetA=$pepA_C_position+1;
			$pepA_allCMods.="57.021464@".$offsetA.",";
		}
		//echo($pepA_allCMods);//check
		$pepAMod=$pepA_allCMods;
	} else $pepAMod="";//no modifications
	
	$pepBMod="";
	if($_POST['pepBMod']=="userSelectBMod") {//for user modifications
		$pepBMod=$_POST['userPepBMod'];
	} elseif($_POST['pepBMod']=="acylC") {//for C mod only
		$pepB_C_count=substr_count($peptideB,"C");
		$modificationAA = "C";
		$pepB_C_position=0;
		$offsetB=0;
		$pepB_allCMods="";
		for ($i = 1; $i<=$pepB_C_count; $i++){
			$pepB_C_position=strpos($peptideB,$modificationAA,$offsetB);
			$offsetB=$pepB_C_position+1;
			$pepB_allCMods.="57.021464@".$offsetB.",";
		}
		$pepBMod=$pepB_allCMods;
	} else $pepBMod="";//no modifications
	
	//add on cross-linker stump masses to pepMods
	$pepAMod.=",".$stump_short."@".$pepSiteA;
	$pepBMod.=",".$stump_short."@".$pepSiteB;

	//execute react2prm
	if($no_upload_file === 1) {
		$name_of_output_file = "PRM-Transition_".$peptideA."_".$peptideB.".txt";
		$r2pParameters = $peptideA." ".$peptideB." ".$pepAMod." ".$pepBMod." ".$crosslinker." ".$reporter." ".$precursorCharge;
	} else {
		$name_of_output_file = "Batch_PRM-Transition_".time().".txt";
		$r2pParameters = "-f ".$uploaded_file." ".$reporter;
	}

	exec("http://xlinkdb.gs.washington.edu/xlinkdb/react2prm_xlinkdb/react2prm_web $r2pParameters", $prmOutput);

	$finalOuput.=implode("\n",$prmOutput);
	
	//download the output
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	//Content disposition: attachment tells the page to print as a file
	header('Content-Disposition: attachment; filename='.$name_of_output_file);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	
	//print out the final transition table
	echo($finalOuput);
?>