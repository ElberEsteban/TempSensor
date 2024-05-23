var apiKey = 'mndsndñkqj4[L#*Pwsf';
var url = 'http://devprojects.wuaze.com/pages/api.php';

fetch(url, {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + apiKey
    }
})
.then(response => response.json())
.then(data => console.log(data))
.catch((error) => {
    console.error('Error:', error);
});