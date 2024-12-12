<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/admin_style.css';?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/style.css';?>">
</head>

<body>

    <div class="header">
        <div class="user-info">
            <span id="userName"></span>  <span id="loginTime"></span>
        </div>
        <div>
            <button class="btn-logout" onclick="back()">Back</button>
            <button class="btn-back" onclick="logout()">Logout</button>
        </div>
    </div>

    <script>
         if(!localStorage.getItem('name')){
            window.location.href = "<?php echo base_url();?>"
        }
        document.getElementById('userName').textContent = localStorage.getItem('name') || 'Guest';
        document.getElementById('loginTime').textContent = localStorage.getItem('lastLogin') || 'Not Available';
        function logout() {
            localStorage.removeItem('name');
            localStorage.removeItem('lastLogin');            
            window.location.href = "<?php echo base_url();?>"
        }
        function back() {
            window.history.back();
        }
    </script>
</body>

</html>
