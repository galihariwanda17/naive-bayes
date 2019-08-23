<!doctype>
<html>
	<head>
		<title>Perhitungan Naive Bayes</title>
		<link rel="icon" type="image/png" href="image/kontak.png">
		<link rel="stylesheet" type="text/css" href="semantic.min.css">
	</head>
	
	<body style="background-image:url(image/seigaiha.png)">
		<?php		
			require_once "Classes/PHPExcel.php";
			session_start();
			if (isset($_POST['unggah']) || (isset($_POST['hitung']))){
				if (isset($_POST['unggah'])) {
					$file_temp_location = $_FILES['pilihFile']['tmp_name'];
					$file_name = $_FILES['pilihFile']['name'];
					$tmpfname = 'E:\\xampp\\htdocs\\Bayes\\upload\\'.$file_name;
					
					$_SESSION['temp']=$file_temp_location;
					$_SESSION['name']=$file_name;
					$_SESSION['loc']=$tmpfname;
					
					move_uploaded_file($_SESSION['temp'], $_SESSION['loc']);
				}
				
				$excelReader = PHPExcel_IOFactory::createReaderForFile($_SESSION['loc']);
				$excelObj = $excelReader->load($_SESSION['loc']);
				$worksheet = $excelObj->getSheet(0);
				$lastRow = $worksheet->getHighestRow();
				$data[][] = array();
				$indeksRow = 0;
				for ($row = 1; $row <= $lastRow; $row++) {
					$data[0][$indeksRow] = $worksheet->getCell('A'.$row)->getValue();
					$data[1][$indeksRow] = $worksheet->getCell('B'.$row)->getValue();
					$data[2][$indeksRow] = $worksheet->getCell('C'.$row)->getValue();
					$data[3][$indeksRow] = $worksheet->getCell('D'.$row)->getValue();
					$data[4][$indeksRow] = $worksheet->getCell('E'.$row)->getValue();
					$data[5][$indeksRow] = $worksheet->getCell('F'.$row)->getValue();
					$indeksRow++;
				}
				
				$pTrue = 0.52; 
				$pFalse = 0.48;
				$purpleT = 0.42307692; $largeT = 0.42307692;
				$purpleF = 0.45833333; $smallF = 0.45833333;
				$yellowT = 0.57692308; $smallT = 0.57692308;
				$yellowF = 0.54166667; $largeF = 0.54166667;
				$stretchT = 0.76923077; $adultT = 0.76923077;
				$dipT = 0.23076923; $childT = 0.23076923;
				$stretchF = 0.25;
				$dipF = 0.75;
				$adultF = 0.20833333;
				$childF = 0.79166667;
				$hasilTrue = 1; $hasilFalse = 1;
				$hasilFitur="";
				$input [] = array();
				if(isset($_POST['hitung'])){
					if($_POST['color'] == "Yellow"){
						$input[0] = "Yellow";
					}else{
						$input[0] = "Purple";
					}

					if($_POST['size'] == "Small"){
						$input[1] = "Small";
					}else{
						$input[1] = "Large";
					}

					if($_POST['act'] == "Strech"){
						$input[2] = "Strech";
					}else{
						$input[2] = "Dip";
					}

					if($_POST['age'] == "Adult"){
						$input[3] = "Adult";
					}else{
						$input[3] = "Child";
					}
				}

				function tampilData(){
					global $indeksRow, $data;
					echo "<table class=\"ui celled table\">";
						for($i = 0; $i < $indeksRow - 7; $i++){
							echo "<tr>";
							for($j = 0; $j < 6; $j++){
								echo "<td>";
								echo $data[$j][$i];
								echo "</td>";
							}
							echo "</tr>";
						}
					echo "</table>";
				}
				
				function HasilFitur($status){
					global $hasilFitur, $input, $hasilFalse, $hasilTrue, $pTrue, $pFalse;
					for ($i = 0; $i < 4; $i++){
						cekFitur($input[$i]);
					}
					$hasilTrue *= $pTrue;
					$hasilFalse *= $pFalse;
					if ($hasilTrue > $hasilFalse)
					{
						$hasilFitur = "True";
					}else
					{
						$hasilFitur = "False";
					}
					if($status == "true"){
						echo $hasilTrue;
					}else{
						echo $hasilFalse;
					}
				}
				
				function cekFitur($fitur){
					global $hasilFalse, $hasilTrue, $purpleF, $purpleT, $yellowT, $yellowF, $largeT, $largeF,
					$smallT, $smallF, $dipT, $dipF, $stretchT, $stretchF, $childT, $childF, $adultT, $adultF;
					if ($fitur == "Purple")
					{
						$hasilTrue *= $purpleT;
						$hasilFalse *= $purpleF;
					}else if ($fitur == "Yellow")
					{
						$hasilTrue *= $yellowT;
						$hasilFalse *= $yellowF;
					}else if ($fitur == "Large")
					{
						$hasilTrue *= $largeT;
						$hasilFalse *= $largeF;
					}else if ($fitur == "Small")
					{
						$hasilTrue *= $smallT;
						$hasilFalse *= $smallF;
					}else if ($fitur == "Dip")
					{
						$hasilTrue *= $dipT;
						$hasilFalse *= $dipF;
					}else if ($fitur == "Stretch")
					{
						$hasilTrue *= $stretchT;
						$hasilFalse *= $stretchF;
					}else if ($fitur == "Child")
					{
						$hasilTrue *= $childT;
						$hasilFalse *= $childF;
					}else if ($fitur == "Adult")
					{
						$hasilTrue *= $adultT;
						$hasilFalse *= $adultF;
					}
				}
			}
			
		?>
		
		</br></br>
		<div class="ui text container" align="center">
	      <h1><b>PERHITUNGAN NAIVE BAYES</b></h1>
	    </div>
		</br></br></br>
		<div class="ui five column grid">
			<div class="two wide column"></div>
			<div class="five wide column">
				<form class="ui form" action="Naivebayes1.php" method="POST">
					<?php
						if(isset($_POST['hitung']) || isset($_POST['unggah'])){
							tampilData();
						}
						if(isset($_POST['tutup'])){
							$_POST['hitung'] = null;
							session_destroy();
						}
					?>
				</form>
			</div>
 			<div class="two wide column ">
 				<div class="ui vertical divider" style="color:gray;"><i class="code icon"></i></div>
 			</div>
 			<div class="five wide column">
 				<form class="ui form" action="Naivebayes1.php" method="POST" enctype="multipart/form-data">
 					<h4 class="ui dividing header" align="center">Menghitung dengan Dataset Baloon</h4>
					<div class="field">
						<div class="ui left icon input">
							<input type="file" name="pilihFile">
							<i class="file icon"></i>
						</div>
					</div>
					<div align="center">
						<button class="ui blue button" type="submit" name="unggah">Unggah</button>
					</div>
				</form>
				<form class="ui form" action="Naivebayes1.php" method="POST" enctype="multipart/form-data">
 					<div name="color" class="field">
						<select name="color" class="ui dropdown">
							<option value="">Color</option>
							<option value="Yellow" >Yellow</option>
							<option value="Purple" >Purple</option>
						</select>
					</div>

					<div class="field">
						<select name="size" class="ui dropdown">
							<option value="">Size</option>
							<option value="Small" >Small</option>
							<option value="Large" >Large</option>
						</select>
					</div>

					<div class="field">
						<select name="act" class="ui dropdown">
							<option value="">Act</option>
							<option value="Strecth" >Strech</option>
							<option value="Dip" >Dip</option>
						</select>
					</div>

					<div class="field">
						<select name="age" class="ui dropdown">
							<option value="">Age</option>
							<option value="Adult" >Adult</option>
							<option value="Child" >Child</option>
						</select>
					</div>
					
					<div class="field">
					<h4 align="left">Total Peluang True</h4>
				    	<div class="ui left icon input">
							  	<input name="y" type="text" placeholder="Total Peluang True" value="<?php
								if ( isset($_POST['hitung']) ){
								echo HasilFitur("true"); }
							  	?>" disabled>
				      		<i class="idea icon"></i>
				      	</div>
				    </div>
					
					<div class="field">
					<h4  align="left">Total Peluang False</h4>
				    	<div class="ui left icon input">
							  	<input name="y" type="text" placeholder="Total Peluang False" value="<?php
								if ( isset($_POST['hitung']) ){
								echo HasilFitur("false");}
							  	?>" disabled>
				      		<i class="idea icon"></i>
				      	</div>
				    </div>
					
				    <div class="field">
				    	<div class="ui left icon input">
							  	<input name="y" type="text" placeholder="Hasil Klasifikasi Kelas" value="<?php
									if ( isset($_POST['hitung']) ){
										global $hasilFitur;
										echo $hasilFitur;
									} 
							  	?>" disabled>
				      		<i class="idea icon"></i>
				      	</div>
				    </div>
					<div align="center">
						<button class="ui blue button" type="submit" name="hitung">Hitung</button>
						<button class="ui red button" type="submit" name="tutup">Tutup</button>
					</div>
 				</form>
 			</div>
		 </div>
		 
	</body>
</html>