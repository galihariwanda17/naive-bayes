var username = document.querySelector('#username');
var message = document.querySelector('#message');

username.addEventListener('blur',()=> {
	if (username.value == ''){
		return;
	}

	message.innerHTML = 'Checking...';

	var xhr = new XMLHttpRequest();
	var url = 'http://localhost/form/ajax-form.php?username=' + username.value;

	xhr.open('GET',url,true);
	xhr.onreadystatechange = () => {
		if (xhr.readyState === 4 &&
			xhr.status === 200){
			message.innerHTML = xhr.responseText;
		}
	};
	xhr.send(null);
});

// Suggestion: open your developer tools!