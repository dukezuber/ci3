<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/login.css';?>">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <div class="error-message" id="errorMessage"></div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');

        // Add a submit event listener to the form
        loginForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            
            errorMessage.textContent = '';

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!email || !password) {
                errorMessage.textContent = 'Both fields are required.';
                return;
            }

            const payload = {
                email: email,
                password: password
            };

            try {
                const response = await fetch('<?php echo base_url();?>index.php/Auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('data',data);
                    if (data.statusCode==200) {
                        alert('Login successful!');
                        window.location.href =data.redirctUrl;
                        localStorage.setItem('name',data.data.firstName+' '+data.data.lastName);
                        localStorage.setItem('lastLogin',data.data.lastLogin);

                    } else {
                        errorMessage.textContent = data.message || 'Login failed. Please try again.';
                    }
                } else {
                    errorMessage.textContent = 'Error: Unable to connect to the server.';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = 'Invalid Credential. Please try again.';
            }
        });
    </script>
</body>
</html>
