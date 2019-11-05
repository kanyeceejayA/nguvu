<!DOCTYPE html>
<html>
<body>

<h2>Make a table based on JSON data.</h2>
<button onclick="get()"><h2>Click to get</h2></button>
<p id="demo"></p>

<script>
// var obj, dbParam, xmlhttp, myObj, x, txt = "";
// obj = { table: "customers", limit: 20 };
// dbParam = JSON.stringify(obj);
// xmlhttp = new XMLHttpRequest();
// xmlhttp.onreadystatechange = function() {
//   if (this.readyState == 4 && this.status == 200) {
//     myObj = JSON.parse(this.responseText);
//     txt += "<table border='1'>"
//     for (x in myObj) {
//       txt += "<tr><td>" + myObj[x].name + "</td></tr>";
//     }
//     txt += "</table>"    
//     document.getElementById("demo").innerHTML = txt;
//   }
// };
// xmlhttp.open("GET", "/ingrid/actions/newspull.php", true);
// xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// xmlhttp.send("x=" + dbParam);

var myObj;
function get() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    myObj = JSON.parse(this.responseText);
	    for (var i = myObj.length - 1; i >= 0; i--) {
	    	// myObj[i]
	    document.getElementById("demo").innerHTML += myObj[i].name;
	    }
	  }
	};
	xmlhttp.open("GET", "actions/api.php", true);
	// xmlhttp.open("GET", "https://jsonplaceholder.typicode.com/todos/1", true);
	xmlhttp.send();
}
function get(search) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    myObj = JSON.parse(this.responseText);
	    for (var i = myObj.length - 1; i >= 0; i--) {
	    	// myObj[i]
	    document.getElementById("demo").innerHTML += myObj[i].name;
	    }
	  }
	};
	xmlhttp.open("GET", "actions/api.php", true);
	// xmlhttp.open("GET", "https://jsonplaceholder.typicode.com/todos/1", true);
	xmlhttp.send();
}


// get();

</script>

</body>
</html>