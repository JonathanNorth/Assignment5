function call_ajax(){
	var province = document.getElementById('province').value;
	if (province != "") {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				 var msg = this.responseText;
				 document.getElementById('city_ajax').innerHTML = msg;
	}};
		xmlhttp.open("GET", "../html/cities.php?province=" + province, true);
		xmlhttp.send();
	} 
}