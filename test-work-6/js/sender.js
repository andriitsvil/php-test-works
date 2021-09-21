function send() {
    let location = window.location;
    let requestData = {
        'page': location.pathname,
        'ts': Math.round(Date.now() / 1000) // is seconds
    };
    let xhr = new XMLHttpRequest();
    let url = location.protocol + '//' + location.host + '/php-test-works/test-work-6/refresh.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.send(JSON.stringify(requestData));
    xhr.onload = function () {
        let response = JSON.parse(xhr.response);
        displayActiveUsers(response);
    }
}

function displayActiveUsers(jsonParsed) {
    let element = document.getElementById('current_users_counter');
    element.innerText = jsonParsed['activeUsers'];
}

send();
let timer = setInterval(() => send(), 10000); // every 10 sec