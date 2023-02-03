<?php
function lucas($a, $b, $n){	//	FUNGSI LUCAS
	$V[0] = 2;
	$V[1] = $a;
	for($i=2; $i<=$b; $i++):
		$V[$i] = modulo(bigInt($a*$V[$i-1]) - $V[$i-2], $n);
	endfor;
	return $V[$b];
}

function prosesLucas($a, $b, $n){	//	FUNGSI CETAK PROSES LUCAS
	$V[0] = 2;
	$V[1] = $a;
	echo '==> V[0] = '.$V[0].'<br>';
	echo '==> V[1] = '.$V[1].'<br>';
	for($i=2; $i<=$b; $i++):
		$V[$i] = modulo(bigInt($a*$V[$i-1]) - $V[$i-2], $n);
		echo '==> V['.$i.'] = ('.$a.' * '.$V[$i-1].' - '.$V[$i-2].') MOD '.$n.' = '.$V[$i].'<br>';
	endfor;
}

function fastExponentiation($a, $b, $n){	//	FUNGSI FAST EXPONENTIATION
	$bin = decbin($b);
	$length = strlen($bin)-1;
	$k = array($length);
	$l= array($length);
	$j = 0;
	for($i=0; $i<=$length; $i++):
		if(substr($bin, $i, 1) == "1"):
			$k[$j] = pow(2, $length-$i);
			$l[$j] = $a;
			$j++;
		endif;
	endfor;
	while($k[0] > 1):
		for($i=0; $i<=$j-1; $i++):
			if($k[$i] > 1):
				$l[$i] = modulo(pow($l[$i], 2), $n);
				$k[$i] = $k[$i] / 2;
			endif;
		endfor;
	endwhile;
	$x = 1;
	for($i=0; $i<=$j-1; $i++):
		$x = modulo(($x * $l[$i]), $n);
	endfor;		
	return $x;
}

function prosesFastExponentiation($a, $b, $n){	//	FUNGSI CETAK PROSES FAST EXPONENTIATION
	$bin = decbin($b);
	$length = strlen($bin)-1;
	$k = array($length);
	$l= array($length);
	$j = 0;
	for($i=0; $i<=$length; $i++):
		if(substr($bin, $i, 1) == "1"):
			$k[$j] = pow(2, $length-$i);
			$l[$j] = $a;
			$j++;
		endif;
	endfor;
	while($k[0] > 1):
		$t = '==> ';
		for($i=0; $i<=$j-1; $i++):
			$t .= $l[$i];
			if($k[$i] > 1):
				$t .= '^'.$k[$i];
			endif;
			$t .= ' . ';
			if($k[$i] > 1):
				$l[$i] = modulo(pow($l[$i], 2), $n);
				$k[$i] = $k[$i] / 2;
			endif;
		endfor;
		$t .= ' MOD '.$n;
		echo $t.'<br><br>';
	endwhile;
	$x = 1;
	$y = '==> ';
	for($i=0; $i<=$j-1; $i++):
		$x = modulo(($x * $l[$i]), $n);
		$y .= $x.' . ';
	endfor;		
	$y .= ' MOD '.$n. '<br><br>==> '.$x;
	echo $y;
}

function blockTotal($n){	//	FUNGSI UNTUK MENDAPATKAN JUMLAH BLOK BERDASARKAN N
	$i = 0; $x = 2;
	while(pow(2, $i) < $n):
		$i++;
	endwhile;
	return $i-1;
}

function valueD($min, $max){	//	FUNGSI UNTUK MENDAPATKAN RANDOM KUNCI D
	$flag = true;
	while($flag):	
		$min++;	
		if(isPrime($min) and isGCD($min, $max+1)): 
			$x = $min;
			$flag = false;
		else: 
			$flag = true;
		endif;
	endwhile;
	return $x;
}

function bigInt($x){
	$x = number_format($x);
	$x = str_replace(',', '', $x);
	return $x;
}

function modulo($a, $b) {	//	FUNGSI MODULO
    $x = $a - (floor($a/$b)*$b);
    return $x;
}

function isGCD($a, $b){		//	FUNGSI UNTUK MENGECEK BILANGAN RELATIF PRIMA
	while($b!=0):
		$r = modulo($a, $b);
		$a = $b;
		$b = $r;
	endwhile;
	if($a==1) return true;
	else return false;	
}

function EEA($a, $b){	//	FUNGSI UNTUK MENDAPATKAN KUNCI MENGGUNAKAN EEA
	$i = 0; $j = 1; $c = 1;
	$q = $a;
	while($c!=0):
		$c = modulo($a, $b);
		$x = floor($a/$b);
		$k = $i - ($j*$x);
		$a = $b;
		$b = $c;
		$i = $j;
		$j = $k;
	endwhile;
	if($i<=0) return $q+$i;
	else return $i;
}
function str2dec($x){	//	FUNGSI KONVERSI STRING KE DESIMAL
	$x = unpack('H*', $x);
	$x = base_convert($x[1], 16, 10);
	return $x;
}

function str2bin($x){	//	FUNGSI KONVERSI STRING KE BINER
  if (!is_string($x)) return null;
  // Unpack as a hexadecimal string
  $biner = '';
  $val = [];
  for($i=0; $i<strlen($x); $i++):
  	$tmp[$i] = unpack('H*', $x[$i]);
	$tmp[$i] = base_convert($tmp[$i][1], 16, 2);
	if(strlen($tmp[$i]) < 8):
		for($j=1; $j<=8-strlen($tmp[$i]); $j++):
			$val[$i] .= '0';
		endfor;
		$val[$i] .= $tmp[$i];
	endif;
	$biner .= $val[$i];
  endfor;
  // Output binary representation
  return $biner;
}

function dec2bin($x, $b){	//	FUNGSI KONVERSI DESIMAL KE BINER
	$x = decbin($x); $val = '';
	if(strlen($x) < $b):
		for($i=1; $i<=$b-strlen($x); $i++):
			$val .= '0';
		endfor;
		$x = $val.$x;
	endif;
	return $x;
}

function isPrime($number){	//	FUNGSI UNTUK MENGECEK BILANGAN PRIMA
	if($number < 2)
		return FALSE;
	for($i=2; $i<=($number / 2); $i++):
		if($number % $i == 0)
			return FALSE;
	endfor;
	return TRUE;
}

function CLS5(){
}

?>