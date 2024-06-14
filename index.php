<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let autoScroll = true;
        let userScrolling = false;

        function fetchChats() {
            fetch('fetch_chats.php')
                .then(response => response.json())
                .then(data => {
                    const chatList = document.querySelector('.chat-list');
                    chatList.innerHTML = '';
                    data.forEach(chat => {
                        const chatItem = document.createElement('div');
                        chatItem.classList.add('chat-item');
                        chatItem.textContent = chat.name;
                        chatItem.onclick = () => selectChat(chat.id, chat.name);
                        chatList.appendChild(chatItem);
                    });
                });
        }

        function fetchPosts(chatId) {
            fetch(`fetch_posts.php?chat_id=${chatId}`)
                .then(response => response.text())
                .then(data => {
                    const postsContainer = document.querySelector('.posts');
                    const previousScrollHeight = postsContainer.scrollHeight;
                    const previousScrollTop = postsContainer.scrollTop;
                    postsContainer.innerHTML = data;

                    if (autoScroll && !userScrolling) {
                        postsContainer.scrollTop = postsContainer.scrollHeight;
                    } else {
                        postsContainer.scrollTop = previousScrollTop + (postsContainer.scrollHeight - previousScrollHeight);
                    }
                });
        }

        function fetchUsers(chatId) {
            fetch(`fetch_users.php?chat_id=${chatId}`)
                .then(response => response.json())
                .then(data => {
                    const userList = document.querySelector('.user-list');
                    userList.innerHTML = '';
                    data.forEach(user => {
                        const userItem = document.createElement('div');
                        userItem.classList.add('user-item');
                        userItem.textContent = user.nickname;
                        userList.appendChild(userItem);
                    });
                });
        }

        function selectChat(chatId, chatName) {
            document.querySelector('#chat_id').value = chatId;
            document.querySelector('#chat-title').textContent = chatName;
            document.querySelector('.chat-header').style.display = 'flex';
            document.querySelector('#message-form').style.display = 'flex';
            document.querySelector('.welcome-message').style.display = 'none';
            autoScroll = true;
            userScrolling = false;
            fetchPosts(chatId);
            fetchUsers(chatId);
            document.querySelector('#message-form textarea').focus();
        }

        function setNickname() {
            const nickname = localStorage.getItem('nickname') || '';
            if (nickname) {
                document.querySelector('.nickname-display').textContent = `Привет, ${nickname}`;
                document.querySelector('#login-button').style.display = 'none';
            } else {
                document.querySelector('#login-button').style.display = 'block';
            }
        }

        function showLoginForm() {
            document.querySelector('.overlay').style.display = 'flex';
            document.querySelector('.login-form').style.display = 'flex';
        }

        function showRegisterForm() {
            document.querySelector('.login-form').style.display = 'none';
            document.querySelector('.register-form').style.display = 'flex';
        }

        function hideForms() {
            document.querySelector('.overlay').style.display = 'none';
            document.querySelector('.login-form').style.display = 'none';
            document.querySelector('.register-form').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchChats();
            setNickname();
            setInterval(() => {
                const chatId = document.querySelector('#chat_id').value;
                if (chatId) {
                    fetchPosts(chatId);
                    fetchUsers(chatId);
                }
            }, 1000);

            document.querySelector('#message-form').addEventListener('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                formData.append("nickname", localStorage.getItem('nickname'));
                fetch(`post.php`, {
                    method: 'POST',
                    body: formData;
                }).then(response => {
                    this.reset();
                    autoScroll = true;
                    fetchPosts(document.querySelector('#chat_id').value);
                    document.querySelector('#message-form textarea').focus();
                });
            });

            document.querySelector('#message-form textarea').addEventListener('keydown', function(event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    this.form.dispatchEvent(new Event('submit', {cancelable: true}));
                }
            });

            const postsContainer = document.querySelector('.posts');
            postsContainer.addEventListener('scroll', () => {
                if (postsContainer.scrollTop + postsContainer.clientHeight >= postsContainer.scrollHeight) {
                    autoScroll = true;
                } else {
                    autoScroll = false;
                    userScrolling = true;
                }
            });

            const textarea = document.querySelector('#message-form textarea');
            textarea.setAttribute('style', 'height: 40px; overflow-y: hidden;');
            textarea.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            document.querySelector('#login-button').addEventListener('click', showLoginForm);
            document.querySelector('.overlay').addEventListener('click', hideForms);
            document.querySelector('.login-form').addEventListener('click', e => e.stopPropagation());
            document.querySelector('.register-form').addEventListener('click', e => e.stopPropagation());
            document.querySelector('#register-link').addEventListener('click', showRegisterForm);

            document.querySelector('#loginForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('login.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.setItem('nickname', formData.get('nickname'));
                        document.querySelector('.nickname-display').textContent = `Привет, ${formData.get('nickname')}`;
                        document.querySelector('#login-button').style.display = 'none';
                        hideForms();
                    } else {
                        document.getElementById('loginError').style.display = 'block';
                    }
                });
            });

            document.querySelector('#registerForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('register.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.setItem('nickname', formData.get('nickname'));
                        document.querySelector('.nickname-display').textContent = `Привет, ${formData.get('nickname')}`;
                        document.querySelector('#login-button').style.display = 'none';
                        hideForms();
                    } else {
                        // Обработка ошибок регистрации
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Чаты</h2>
            <div class="chat-list">
                <!-- Список чатов будет загружаться здесь -->
            </div>
            <form action="create_chat.php" method="POST" class="create-chat-form">
                <input type="text" name="chat_name" placeholder="Название чата" required>
                <button type="submit">Создать</button>
            </form>
            <div class="nickname-display"></div>
            <button id="login-button" style="display:none; margin-top: auto;">Войти</button> <!-- Переместил кнопку вниз -->
        </div>
        <div class="main">
            <div class="chat-header">
                <h1 id="chat-title"></h1>
            </div>
            <div class="posts">
                <!-- Сообщения будут загружаться здесь -->
            </div>
            <div class="welcome-message">
                <h1>Здравствуйте, выберите чат</h1>
            </div>
            <form id="message-form" action="post.php" method="POST" style="display: none;">
                <input type="hidden" id="chat_id" name="chat_id" value="">
                <textarea name="message" placeholder="Введите ваше сообщение..." required></textarea>
            </form>
        </div>
        <div class="user-sidebar">
            <h2>Пользователи в чате</h2>
            <div class="user-list">
                <!-- Список пользователей будет загружаться здесь -->
            </div>
        </div>
    </div>

    <div class="overlay" style="display: none;">
        <div class="login-form">
            <h2>Вход</h2>
            <form id="loginForm" action="login.php" method="POST">
                <input type="text" name="nickname" placeholder="Никнейм" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
            <p id="loginError" style="color: red; display: none;">Неверный логин или пароль</p>
            <p>Нет аккаунта? <a href="#" id="register-link">Зарегистрироваться</a></p>
        </div>
        <div class="register-form" style="display: none;">
            <h2>Регистрация</h2>
            <form id="registerForm" action="register.php" method="POST">
                <input type="text" name="nickname" placeholder="Никнейм" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</body>
</html>
