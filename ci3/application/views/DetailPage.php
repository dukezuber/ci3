<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-image {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .profile-info {
            font-size: 18px;
        }
        .profile-info p {
            margin: 10px 0;
        }
        .profile-info strong {
            font-weight: bold;
        }
        .card {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }
        .card label {
            font-weight: bold;
        }
        .card .value {
            color: #555;
        }
        .section-title {
            margin-top: 30px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
<?php $this->load->view('Header');?>
    <div class="container">
        <!-- Profile Header -->
        <div class="header1">
            <h2>User Profile</h2>
            <img id="profileImage" src="" alt="Profile Image" class="profile-image">
            <div class="profile-info">
            <div class="card">
                    <label>Created At:</label>
                    <div id="profileCreatedAt" class="value"></div>
                </div>
                <div class="card">
                    <label>Name:</label>
                    <div id="profileName" class="value"></div>
                </div>
                <div class="card">
                    <label>Email:</label>
                    <div id="profileEmail" class="value"></div>
                </div>
            </div>
        </div>

        <!-- Employment Details Section -->
        <div class="section-title">Employment Details</div>
        <div id="employmentDetails" class="profile-info">
            <!-- Employment details will be populated here dynamically -->
        </div>

        <!-- Education Details Section -->
        <div class="section-title">Education Details</div>
        <div id="educationDetails" class="profile-info">
            <!-- Education details will be populated here dynamically -->
        </div>
    </div>

    <script>

        const url = new URL(window.location.href);
        const id = url.searchParams.get("id");
        const apiUrl = '<?php echo base_url();?>index.php/user/userDetail/'+id;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data.data)
                var data = data.data;
                document.getElementById('profileName').innerText = data.firstName+' '+data.lastName;
                document.getElementById('profileEmail').innerText = data.email;
                document.getElementById('profileCreatedAt').innerText = data.created_at;
                document.getElementById('profileImage').src = data.profileImage;
                const employmentDetailsContainer = document.getElementById('employmentDetails');
                data.employmentDetails.forEach(employment => {
                    const employmentCard = document.createElement('div');
                    employmentCard.classList.add('card');
                    employmentCard.innerHTML = `
                        <label>Company:</label>
                        <div class="value">${employment.company}</div>
                        <label>Position:</label>
                        <div class="value">${employment.position}</div>
                        <label>Join Year:</label>
                        <div class="value">${employment.joinYear}</div>
                    `;
                    employmentDetailsContainer.appendChild(employmentCard);
                });

                const educationDetailsContainer = document.getElementById('educationDetails');
                data.educationDetails.forEach(education => {
                    const educationCard = document.createElement('div');
                    educationCard.classList.add('card');
                    educationCard.innerHTML = `
                        <label>Degree:</label>
                        <div class="value">${education.degree}</div>
                        <label>University:</label>
                        <div class="value">${education.institution}</div>
                        <label>Graduation Year:</label>
                        <div class="value">${education.graduationYear}</div>
                    `;
                    educationDetailsContainer.appendChild(educationCard);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    </script>
</body>
</html>