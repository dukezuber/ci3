<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard2</title>
</head>

<body>
    <?php $this->load->view('Header');?>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="<?php echo base_url();?>index.php/AddUserPage" class="btn btn-add">Add User</a>
        <H3 id='totalUserCount'>total user Count : </H3>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userList">
                <!-- Dynamic rows will be added here -->
            </tbody>
        </table>
    </div>

    <script>
        function loadUsers() {
            fetch('<?php echo base_url();?>index.php/User/userList', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.statusCode === 200) {
                        const users = data.data;

                        const totalCount = data.totalCount;
                        const userCountElement = document.getElementById('totalUserCount');
                        userCountElement.innerText = `Total User Count: ${totalCount}`;

                        const userList = document.getElementById('userList');
                        userList.innerHTML = '';
                        users.forEach(user => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${user.id}</td>
                                <td>${user.firstName}</td>
                                <td>${user.lastName}</td>
                                <td>${user.email}</td>
                                <td><img src="${user.profileImage}" alt="User Image" style="height: 67px; width: 70px;"></td>
                                <td>
                                    <button class="btn btn-edit" onclick='editUser(${JSON.stringify(user).replace(/'/g, "\\'")})'>Update</button>
                                    <button class="btn btn-delete" onclick="deleteUser({id: '${user.id}'})"> Delete </button>
                                    <button  class="btn btn-view" onclick='detailPage(${JSON.stringify(user).replace(/'/g, "\\'")})'>view</button>
                                </td>
                            `;
                            userList.appendChild(row);
                        });
                    } else {
                        console.error('Error: No data found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                });
        }
        loadUsers();

        function deleteUser(user) {
            const apiUrl = "<?php echo base_url();?>index.php/user/delete_userList"
            const method = 'POST';
            fetch(apiUrl, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(user),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.statusCode === 200) {
                        alert(data.statusMsg);
                        loadUsers();
                    } else {
                        console.error('Error saving user:', data.message || 'Unknown error');
                    }
                })
                .catch(error => {
                    console.error('Error sending data to API:', error);
                });
        }

        function editUser(user) {
            var userId = user.id;
            window.location.href = '<?php echo base_url();?>index.php/UpdateUserPage?id=' + encodeURIComponent(userId);
        }

        function detailPage(user) {
            var userId = user.id;
            window.location.href = '<?php echo base_url();?>index.php/DetailPage?id=' + encodeURIComponent(userId);
        }
    </script>
</body>

</html>