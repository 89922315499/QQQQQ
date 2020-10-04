/*
var server_response = document.querySelector("#response");

document.forms.customers_form.onsubmit = function(e) {
	e.preventDefault();

	var user_input = document.forms.customers_form.second_name.value;
	user_input = encodeURIComponent(user_input);


	var xhr = new XMLHttpRequest();
	xhr.open("POST", "data.php");

	var form_data = new FormData(document.forms.customers_form);

	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
			server_response.textContent = xhr.responseText;
		}
	}

	xhr.send(form_data);
};

function getTest() {
	alert("Jopa");
}
*/