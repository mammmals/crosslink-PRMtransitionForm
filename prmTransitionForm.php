<?php 	
	$tableName="";
	$dataset="";
	$privateFlag="";
	$pepA="";
	$pepB="";
	$siteA="";
	$siteB="";

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
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>XLink-DB | PRM Transition Form</title>
		<link href = "css/bootstrap.css" rel = "stylesheet" type = "text/css">
		<link href = "css/bootstrap-responsive.css" rel = "stylesheet" type = "text/css">
		<link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css">
		<link href = "css/bootstrap-responsive.min.css" rel = "stylesheet" type = "text/css">
		<meta name="description" content="XLink-DB helps biologists and mass-spectrometrists store, visualize and share large scale cross-linking data."/>
		<meta name="google" content="notranslate"/>
		<meta name="keywords" content="XLink-DB, biologists, mass-spectrometrists, cross-linking, cross-link, crosslinking, crosslinkingdb, peptide, protein, complexes, 3d, models, bruce, software, database, topology, interaction">
		<meta name="author" content="Bruce Laboratory">
		<meta name="copyright" content="2012-2016">
		<meta property="og:title" content="XLink-DB| Database of Protein Interaction Topology Data"/>
		<meta property="og:url" content="index.php"/>
		<meta property="og:type" content="website"/>
		<meta name="twitter:card" content="summary">
		<meta name="twitter:url" content="index.php">
		<meta name="twitter:title" content="XLink-DB| Database of Protein Interaction Topology Data">
		<meta name="twitter:description" content="XLink-DB helps biologists and mass-spectrometrists store, visualize and share large scale cross-linking data.">
		</head>
		<body>
			<div class="container">
				<div class="hero-unit">
					<h2 align="center"><b>Generate a <font style="color: green">PRM</font> transition file (.txt) for analysis of cross-links with <font style="color: blue">Skyline</font>.</b></h2><br/>
					<h4>For tutorial more information pertaining to Parallel Reaction Monitoring (PRM) and XL-MS, refer to these papers/resources:
					<br>
					<br>
					<ul>
						<li><a href="https://skyline.gs.washington.edu/labkey/project/home/software/Skyline/begin.view">Skyline</a>, a targeted mass spec environment.</li>
						<li><a href="http://www.ncbi.nlm.nih.gov/pubmed/27341434">Chavez, et al. Cell Chem Biol:</a> In Vivo Conformational Dynamics of Hsp90 and Its Interactors.</li>
						<li><a href="">Chavez, et al. (in Preparation)</a> A general method for targeted quantitative cross-linking mass spectrometry.</li>
						<li><a href="#batch">Batch input</a> to generate PRM transitions now available.</li>
					</ul>
					</h4>
				</div>
				<div class="row" align="left">
					<div class="span6">
						<h3>Single PRM Transition Input:</h3>
						<p></p>
						<form class="well form-horizontal" name='searchbox' action='downloadPRM.php' method='post' enctype="multipart/form-data">
								<!--Set peptide inputs-->
								<label class="control-label" for="input01"><b>Peptide A:&nbsp&nbsp</b></label>
								<input name='peptideA' type="text" class="input-small search-query" id="input01"  style="width: 80%" value=<?php echo $pepA;?>><br/><p></p>
								
								<label class="control-label" for="input02"><b>Peptide B:&nbsp&nbsp</b></label>
								<input name='peptideB' type="text" class="input-small search-query" id="input02"  style="width: 80%" value=<?php echo $pepB;?>><br/><p></p>
								<!--Set peptide site inputs-->
								</br>
								<label class="control-label" for="input03"><b>Site A:&nbsp&nbsp</b></label>
								<input name='pepSiteA' type="text" class="input-small search-query" id="input03" style="width: 80%" value=<?php echo $siteA;?>><br/><p></p>
								
								<label class="control-label" for="input04"><b>Site B:&nbsp&nbsp</b></label>
								<input name='pepSiteB' type="text" class="input-small search-query" id="input04"  style="width: 80%" value=<?php echo $siteB;?>><br/><p></p>
								
							<!--Set cross-linker type inputs-->
							<b><u>Cross-linker Type:</b></u></br>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox1" name="crosslinker" value="bdp" checked="checked">
									BDP-NHP
								</label><br/>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox2" name="crosslinker" value="dsso">
									DSSO
								</label><br/>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox3" name="crosslinker" value="other">
									Other
								</label><br/>
							<!--Set Precursor charge type inputs-->
							</br><b><u>Precursor Charge State:</b></u></br>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox4" name="charge" value="4" checked="checked">
									4+
								</label><br/>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox5" name="charge" value="5">
									5+
								</label><br/>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox6" name="charge" value="6">
									6+
								</label><br/>
								<br/>
							<b><u>Modifications:</b></u></br>
								<b><i>Peptide A:</b></i></br>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox7" name="pepAMod" value="none">
									None.
								</label><br/>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox8" name="pepAMod" value="acylC" checked="checked">
									use carbamidomethyl cysteine (C, monoisotopic) - 57.021464
								</label><br/>
								<label class="checkbox inline">
								<input type="radio" id="inlineCheckbox9" name="pepAMod" value="userSelectAMod">
								User Defined Modifications:
									<input type="test" id="inlineCheckbox10" name="userPepAMod" value="">
									<br>
									#@pos, i.e. "16.0@2,57.1@3", space separated for addition to N-term use '[' and for C-term use ']', e.g. "16.0@["
								</label><br/>
								<br/>
								<b><i>Peptide B:</b></i></br>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox11" name="pepBMod" value="none">
									None.
								</label><br/>
								<label class="checkbox inline">
									<input type="radio" id="inlineCheckbox12" name="pepBMod" value="acylC" checked="checked">
									use carbamidomethyl cysteine (C, monoisotopic) - 57.021464
								</label><br/>
								<label class="checkbox inline">
								<input type="radio" id="inlineCheckbox13" name="pepBMod"  value="userSelectBMod">
								User Defined Modifications:
									<input type="test" id="inlineCheckbox14" name="userPepBMod" value="">
									<br>
									#@pos, i.e. "16.0@2,57.1@3", space separated for addition to N-term use '[' and for C-term use ']', e.g. "16.0@["
								</label>
								</br></br>
								<button type='submit' class="btn btn-primary">Generate Individual PRM Transitions</button>
								</form>
							</div>
							<div class="span6">
								<h3>Batch PRM Transition input:</h3>
								<p></p>
								<form class="well form-horizontal" name='searchbox' action='downloadPRM.php' method='post' enctype="multipart/form-data">
								<u><h3>Select batch file input:</h3></u>
								</br>
								<input type="file" name="prmTsvFile" id="batch">
								</br></br>
								<button type='submit' class="btn btn-primary">Generate Batch PRM Transitions</button>
								</br></br>
								Batch input files should be tab-separated ('.txt') files of the format:</br>
								<b>PeptideA&nbsp;&nbsp;&nbsp;PeptideB&nbsp;&nbsp;&nbsp;PepModA&nbsp;&nbsp;&nbsp;PepModB&nbsp;&nbsp;&nbsp;Charge State</b>
								</br>
								</br>
								Modification sites should include stump mases for cross-linkers (e.g. BDP-NHP: 325.13 or DSSO: 182.11).</br>
								#@pos, i.e. "16.0@2,57.1@3", space separated for addition to N-term use '[' and for C-term use ']', e.g. "16.0@["
								</br>
								</br>
								<u>Example of input:</u></br>
								<table style="width:100%">
									<tr>
										<th>PeptideA</th>
										<th>PeptideB</th>
										<th>PepA Modifications</th>
										<th>PepB Modifications</th>
										<th>Charge State</th>
									</tr>
									<tr>
										<td>QKAEADKNDK</td>
										<td>QKAEADKNDK</td>
										<td>325.13@2</td>
										<td>325.13@2</td>
										<td>4</td>
									</tr>
									<tr>
										<td>MEESKCK</td>
										<td>KVEKVTISNR</td>
										<td>325.13@5,160.03@6</td>
										<td>325.13@4</td>
										<td>5</td>
									</tr>
								</table>
								</br></br>
								<h4>Download a brief example file here: <a href="http://xlinkdb.gs.washington.edu/xlinkdb/react2prm_xlinkdb/prm_batch_test.txt">Example</a>.</h4>
								</br>
								</form>
							</div>
						</form>
					</div>
				**Developed by Jimmy K Eng (UWPR) and Devin K Schweppe (Bruce Lab)**
			</div>
		</body>
	</html>
