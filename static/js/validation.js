/*
    THIS SCRIPT IS RESPONSIBLE FOR USER INPUT VALIDATION
*/


// username field
const username = document.querySelector('input[name=username]');

// message field to display wether username is available or not
const message_box = document.querySelector('.username-validation');


// listen for focus out
// and then make a request to backend with the username
// check wether it is valid or not
username.addEventListener('focusout', (event) => {
    let userName = username.value;

    if (userName && userName.length >= 5) {

        // make an API call
        fetch("/Ecommer/checkValidUserName", {
            method: "POST",
            headers: {
                "Content-Type" : "application/x-www-form-urlencoded"
            },
            body: `username=${userName}`
        })
        .then(resp => {
            return resp.text();
        })
        .then(response => {
            response = JSON.parse(response);
            if (response['isValid'] == 'YES') {
                if (message_box.classList.contains("not-valid")) {
                    message_box.classList.remove('not-valid');
                }
                message_box.classList.add("valid");
                message_box.textContent = "The username is available";
            }
            else {
                if (message_box.classList.contains("valid")) {
                    message_box.classList.remove('valid');
                }
                message_box.classList.add("not-valid");
                message_box.textContent = "The username is not available";
            }
        });
    }
    else if (userName.length >= 1 || userName.length < 5) {
        message_box.textContent = "Username should be of minimum 5 characters";
    }
    else {
        // clear the message, if field is empty
        message_box.textContent = "";
    }
})