<html>
<head>
<link href="style.css" rel="stylesheet" />
<script type="text/javascript">
function isPrime(x){
	if(x < 2)
		return false;
	for(i=2; i<=(x/2); i++){
		if(x % i == 0)
			return false;
	}
	return true;
}

function validate(a, b, c, d, id){
	if(a=='' || b=='' || c==''){
		alert('Field M, P dan Q tidak boleh kosong');
	}else if(!isPrime(b)){
		alert('Nilai P harus merupakan bilangan PRIMA');
	}else if(!isPrime(c)){
		alert('Nilai Q harus merupakan bilangan PRIMA');
	}else{
		ajax_send(a, b, c, d, id);
	}
}

function ajax_send(a, b, c, d, id){
	var url = "proses.php?&id="+id+"&a="+a+"&b="+b+"&c="+c+"&d="+d;
	url=url+"&sid="+Math.random();
	xmlhttp = GetXmlHttpObject();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var x = xmlhttp.responseText;
			x = x.replace(/<br>/g, "\n");
			var y = x.split('|');
			$m('kunci_'+id).value = y[0];
			$m('enkrip_'+id).value = y[1];			
			$m('dekrip_'+id).value = y[2];			
			$m('submit_'+id).disabled = false;
			$m('load_'+id).innerHTML = '';
		}else{		
			$m('submit_'+id).disabled = true;
			$m('load_'+id).innerHTML = 'loading';
		}
	}
	xmlhttp.open("GET", url, true);
	xmlhttp.send();
}

function $m(theVar){
	return document.getElementById(theVar)
}

function GetXmlHttpObject(){
	if (window.XMLHttpRequest){
	  // code for IE7+, Firefox, Chrome, Opera, Safari
	  return new XMLHttpRequest();
	}
	if (window.ActiveXObject){
	  // code for IE6, IE5
	  return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
	<div class="container-fluid">
		<h1 class="text-center">
			RSA
		</h1>
		<h2 class="text-center mb-4">
			(Rivest, Shamir & Adelman)
		</h2>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="card">
					<div class="card-body">
						<form action="javascript:validate(document.RSA.txtM_RSA.value, document.RSA.txtP_RSA.value, document.RSA.txtQ_RSA.value, null, 'RSA');" name="RSA">
						<div class="mb-3">
							<label for="txtM_RSA" class="form-label">
								Plainteks:
							</label>
							<input type="text" name="txtM_RSA" id="txtM_RSA" class="form-control" />
						</div>
						<div class="mb-3">
							<label for="txtM_RSA" class="form-label">
								Nilai P:
							</label>
							<input type="text" name="txtP_RSA" id="txtP_RSA" class="form-control" />
						</div>
						<div class="mb-3">
							<label for="txtM_RSA" class="form-label">
								Nilai Q:
							</label>
							<input type="text" name="txtQ_RSA" id="txtQ_RSA" class="form-control" />
						</div>
						<div class="mb-3">
							<center>
								<input type="submit" class="btn btn-primary" value="Enkrip" id="submit_RSA"/>
							</center>
						</div>
						<div class="mb-3">
									<label for="" class="form-label"><h3>Pembentukan Kunci</h3></label>
									<textarea id="kunci_RSA" rows="7" wrap="off" class="form-control" readonly></textarea>
								</div>
								<div class="mb-3">
									<label for="" class="form-label"><h3>Proses Enkripsi</h3></label>
									<textarea id="enkrip_RSA" rows="10" readonly class="form-control"></textarea>
								</div>
								<div class="mb-3">
									<label for="" class="form-label"><h3>Proses Dekripsi</h3></label>
									<textarea id="dekrip_RSA" rows="10" readonly class="form-control"></textarea>
								</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>
<script src="jquery.min.js" type="text/javascript"></script>
<script src="function.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>