<?php
require_once("function.php");
$id = $_REQUEST['id'];
$a = $_REQUEST['a'];
$b = $_REQUEST['b'];
$c = $_REQUEST['c'];
$d = $_REQUEST['d'];
$teks = $a; $p = $b; $q = $c;
switch($id):
case 'RSA' :	//	PROSES UNTUK RSA
	$teks = str2bin($teks);
	$n = bigInt($p * $q);
	$Tn = bigInt(($p-1) * ($q-1));
	$d = valueD($p+1, $Tn-1);	//	PROSES UNTUK MENDAPATKAN KUNCI D
	$e = bigInt(EEA($Tn, $d));	//	PROSES UNTUK MENDAPATKAN KUNCI E MENGGUNAKAN EEA	
	$b = blockTotal($n);	//	MENCARI NILAI BLOK
	for($i=0; $i<(8*strlen($a)/$b); $i++):
		$m[$i+1] = substr($teks, $i*$b, $b);	// ISIKAN PER BLOK KE M[i]
		if(strlen($m[$i+1]) < $b):
			for($j=1; $j<=$b-strlen($m[$i+1]); $j++):
				$val .= '0';
			endfor;
			$m[$i+1] .= $val;
		endif;
	endfor;		
	echo $teks.'<br>';
	echo $m[1].'<br>';
	echo "Kunci D = ".$d.'<br>';	// 	CETAK PEMBENTUKAN KUNCI	RSA
	echo "Kunci E = ".$e.'<br>';
	echo 'N = '.$n.'<br>';
	echo 'T[n] = '.$Tn.'<br>';
	echo 'B = '.$b.'<br><br>';
	echo 'Bukti : <br>';
	echo $e.' * '.$d.' MOD '.$Tn.' = '.modulo(bigInt($d*$e), $Tn);
	echo '|';
	for($i=1; $i<=sizeof($m); $i++):	//	CETAK PROSES ENKRIPSI	
		$cipher[$i] = fastExponentiation(bindec($m[$i]), $e, $n);
		echo '-----------------------------------------------------------------------<br>';
		echo 'C['.$i.'] = '.bindec($m[$i]).'^'.$e.' MOD '.$n.' = '.$cipher[$i].'<br>';
		echo '-----------------------------------------------------------------------<br>';
		echo prosesFastExponentiation(bindec($m[$i]), $e, $n).'<br>';
	endfor;	
	echo '<br>-----------------------------------------------------------------------<br>';
	for($i=1; $i<=sizeof($cipher); $i++):
		echo 'C['.$i.'] = '.$cipher[$i].'<br>';
	endfor;
	echo '-----------------------------------------------------------------------<br>';
	echo '|';
	for($i=1; $i<=sizeof($cipher); $i++):	//	CETAK PROSES DEKRIPSI
		$x = $cipher[$i];
		$tmp_1[$i] = fastExponentiation($x, $d, $n);
		$char .= dec2bin($tmp_1[$i], $b); 
		echo '-----------------------------------------------------------------------<br>';
		echo 'M['.$i.'] = '.$x.'^'.$d.' MOD '.$n.' = '.$tmp_1[$i].'<br>';
		echo '-----------------------------------------------------------------------<br>';
		echo prosesFastExponentiation($x, $d, $n).'<br><br>';
	endfor;
	echo '-----------------------------------------------------------------------<br>';
	echo $char.'<br><br>Pecah menjadi '.strlen($a).' block : <br>';
	for($i=0; $i<strlen($a); $i++):
		$tmp_2[$i+1] = substr($char, $i*8, 8);
		$plain[$i+1] = chr(bindec($tmp_2[$i+1]));
		echo 'M['.($i+1).'] = '.$tmp_2[$i+1].' = '.bindec($tmp_2[$i+1]).' = '.$plain[$i+1].'<br>';
		$tmp .= $plain[$i+1];
	endfor;
	echo '<br>Plainteks = '.$tmp.'<br>';
	echo '-----------------------------------------------------------------------<br>';
break;
endswitch;
?>