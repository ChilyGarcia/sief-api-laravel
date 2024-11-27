<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Chat</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #chat-container {
            max-width: 600px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        #messages {
            height: 300px;
            overflow-y: auto;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
        }

        #message-input {
            width: calc(100% - 70px);
            padding: 10px;
        }

        #send-button {
            padding: 10px;
        }
    </style>
</head>

<body>
    <h3>Chat en Tiempo Real</h3>
    <div id="chat-container">
        <div id="messages"></div>
        <input id="message-input" type="text" placeholder="Escribe un mensaje..." />
        <button id="send-button">Enviar</button>
    </div>

    <script>
        // Inicializa Pusher
        const pusher = new Pusher('a7f9b80f8e8d1c4a0e09', {
            cluster: 'mt1'
        });

        // Suscríbete al canal
        const channel = pusher.subscribe('chat');

        // Escucha el evento MessageSent
        channel.bind('App\\Events\\MessageSent', function(data) {
            const messagesDiv = document.getElementById('messages');
            const messageElement = document.createElement('div');
            messageElement.innerHTML = `<strong>${data.user}:</strong> ${data.message}`;
            messagesDiv.appendChild(messageElement);

            // Desplazar hacia abajo para ver el nuevo mensaje
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });

        // Cargar mensajes al inicio
        window.onload = function() {
            fetch('/api/messages')
                .then(response => response.json())
                .then(messages => {
                    const messagesDiv = document.getElementById('messages');
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.innerHTML = `<strong>${message.user}:</strong> ${message.message}`;
                        messagesDiv.appendChild(messageElement);
                    });
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                });
        };

        // Enviar mensaje
        document.getElementById('send-button').onclick = function() {
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value;

            // Hacer la solicitud AJAX para enviar el mensaje
            fetch('/chat/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: message
                })
            }).then(response => {
                if (response.ok) {
                    messageInput.value = ''; // Limpiar el campo de entrada
                }
            });
        };
    </script>
</body>

</html>
