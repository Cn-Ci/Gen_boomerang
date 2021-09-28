// const _receiver = document.getElementById('mercure-content-receiver');
// const _messageInput = document.getElementById('mercure-message-input');
// const _sendForm = document.getElementById('mercure-message-form');

// const sendMessage = (message) => {
//     if (message === '') {
//     return;
//     }

//     fetch(_sendForm.action, {
//     method: _sendForm.method,
//     body: 'message=' + message,
//     headers: new Headers({
//         'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
//     })
//     }).then(() => {
//     _messageInput.value = '';
//     });
// };

// _sendForm.onsubmit = (evt) => {
//     sendMessage(_messageInput.value);

//     evt.preventDefault();
//     return false;
// };

// const url = new URL('{{ mercure_publish_url }}');
// url.searchParams.append('topic', 'https://intro-mercure.test/users/message/'+user);
// const eventSource = new EventSource(url, { withCredentials: true });
// eventSource.onmessage = (evt) => {
//     const data = JSON.parse(evt.data);
//     if (!data.message) {
//     return;
//     }
//     // _receiver.insertAdjacentHTML('beforeend', `<div class="message">${data.message}</div>`);
//     $('.toast').show
// };

// URL is a built-in JavaScript class to manipulate URLs
// const url = new URL('http://localhost:3000/.well-known/mercure');
// url.searchParams.append('topic', 'http://localhost:8000/article/like');

// const eventSource = new EventSource(url);
// eventSource.onmessage = event => {
//     $('.toast').toast('show')
//     window.setTimeout(() => {
//         $('.toast').toast('hide')
//     }, 10000)
// }

async function affichageCompteur(id) {
  const data = await fetch(
    "https://api.countapi.xyz/get/compteur-boomerang/" + id + "A"
  );
  const count = await data.json();
  document.getElementById(id).innerHTML = count.value;
}

function showPreview(event) {
  if (event.target.files.length > 0) {
    var src = URL.createObjectURL(event.target.files[0]);
    var preview = document.getElementById("file-ip-1-preview");
    console.log(src);
    preview.src = src;
    preview.style.display = "block";
  }
}
