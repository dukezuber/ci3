<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Form</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    </head>
    <body>
        <?php $this->load->view('Header'); ?>
        <div style="max-width: 800px; margin: 50px auto; background-color: white; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
            <h2 style="text-align: center; color: #333;">Registration Form</h2>

            <form id="registrationForm" action="#" method="POST" enctype="multipart/form-data">
                <!-- First Name and Last Name -->
                <div style="margin-bottom: 15px;">
                    <label for="firstName" style="display: block; font-size: 16px; color: #333;">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required style="width: 95%; padding: 10px; margin-top: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="lastName" style="display: block; font-size: 16px; color: #333;">Last Name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required style="width: 95%; padding: 10px; margin-top: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">
                </div>

                <!-- Email -->
                <div style="margin-bottom: 15px;">
                    <label for="email" style="display: block; font-size: 16px; color: #333;">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required style="width: 95%; padding: 10px; margin-top: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">
                </div>

                <!-- Password -->
                <div style="margin-bottom: 15px;">
                    <label for="password" style="display: block; font-size: 16px; color: #333;">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required style="width: 95%; padding: 10px; margin-top: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">
                </div>

                <!-- Profile Image -->
                <div style="margin-bottom: 15px;">
                    <label for="profileImage" style="display: block; font-size: 16px; color: #333;">Profile Image</label>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*" required style="width: 95%; padding: 10px; margin-top: 5px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">
                </div>

                <img src="" id="showProfileImage" alt="Profile Image" style="display: none; width: 150px; height: 150px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px;">

                <div class="modal" id="cropModal" style="display: none;">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Crop Image</h2>
                        <div id="cropper-container">
                            <!-- Image will be loaded here for cropping -->
                            <img id="imageToCrop" src="" alt="Image to crop" style="max-width: 95%;"/>
                        </div>
                        <button id="saveCroppedImage" type="button" onclick="saveCroppedImage()">Save Image</button>

                    </div>
                </div>

                <!-- Employee Details Section -->
                <div id="employmentDetailsSection" style="margin-bottom: 15px;">
                    <h3 style="color: #333;">Employee Details</h3>
                    <div class="employmentDetails" style="margin-bottom: 10px;">
                        <label for="empCompany" style="display: block; margin: 4px; font-size: 16px; color: #333;">Company Name</label>
                        <input type="text" name="empCompany[]" placeholder="Enter your company name" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                        <label for="empPosition" style="display: block; margin: 4px; font-size: 16px; color: #333;">Designation</label>
                        <input type="text" name="empPosition[]" placeholder="Enter your designation" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                        <label for="empJoinYear" style="display: block; margin: 4px; font-size: 16px; color: #333;">Join Year</label>
                        <input type="number" name="empJoinYear[]" placeholder="Enter your join year" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                        <button type="button" onclick="removeemploymentDetails(this)" style="background-color: #ff4747; color: white; border: none; padding: 10px 15px; margin-top: 5px; cursor: pointer; border-radius: 5px; font-size: 14px;">Delete</button>
                    </div>
                    <button type="button" onclick="addemploymentDetails()" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;">Add More Employee Details</button>
                </div>

                <!-- Education Details Section -->
                <div id="educationDetailsSection" style="margin-bottom: 15px;">
                    <h3 style="color: #333;">Education Details</h3>
                    <div class="educationDetail" style="margin-bottom: 10px;">
                        <label for="degree" style="display: block; margin: 4px; font-size: 16px; color: #333;">Degree</label>
                        <input type="text" name="degree[]" placeholder="Enter your degree" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                        <label for="institution" style="display: block; margin: 4px; font-size: 16px; color: #333;">Institution</label>
                        <input type="text" name="institution[]" placeholder="Enter the institution name" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                        <label for="graduationYear" style="display: block; margin: 4px; font-size: 16px; color: #333;">Year of Graduation</label>
                        <input type="number" name="graduationYear[]" placeholder="Enter year of graduation" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                        <button type="button" onclick="removeEducationDetail(this)" style="background-color: #ff4747; color: white; border: none; padding: 10px 15px; margin-top: 5px; cursor: pointer; border-radius: 5px; font-size: 14px;">Delete</button>
                    </div>
                    <button type="button" onclick="addEducationDetail()" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;">Add More Education Details</button>
                </div>

                <!-- Submit Button -->
                <div style="text-align: center;">
                    <button type="button" id="submitBtn" onclick="submitForm(event)" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
                        Submit
                    </button>
                </div>
            </form>
            <div id="responseMessage" style="text-align: center; margin-top: 20px;"></div>
        </div>

        <script>
            function addemploymentDetails() {
                var employmentDetailsSection = document.getElementById("employmentDetailsSection");
                var newemploymentDetails = document.createElement("div");
                newemploymentDetails.classList.add("employmentDetails");
                newemploymentDetails.style.marginBottom = "10px";
                newemploymentDetails.innerHTML = `
                    <label for="empCompany" style="display: block; margin: 4px; font-size: 16px; color: #333;">Company Name</label>
                    <input type="text" name="empCompany[]" placeholder="Enter your company name" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                    <label for="empPosition" style="display: block; margin: 4px; font-size: 16px; color: #333;">Designation</label>
                    <input type="text" name="empPosition[]" placeholder="Enter your designation" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                    <label for="empJoinYear" style="display: block; margin: 4px; font-size: 16px; color: #333;">Join Year</label>
                    <input type="number" name="empJoinYear[]" placeholder="Enter your join year" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                    <button type="button" onclick="removeemploymentDetails(this)" style="background-color: #ff4747; color: white; border: none; padding: 10px 15px; margin-top: 5px; cursor: pointer; border-radius: 5px; font-size: 14px;">Delete</button>
                `;
                employmentDetailsSection.appendChild(newemploymentDetails);
            }

            // Function to remove employee detail fields
            function removeemploymentDetails(button) {
                var employmentDetails = button.parentElement;
                employmentDetails.remove();
            }

            // Function to add new education detail fields
            function addEducationDetail() {
                var educationDetailsSection = document.getElementById("educationDetailsSection");
                var newEducationDetail = document.createElement("div");
                newEducationDetail.classList.add("educationDetail");
                newEducationDetail.style.marginBottom = "10px";
                newEducationDetail.innerHTML = `
                    <label for="degree" style="display: block; margin: 4px; font-size: 16px; color: #333;">Degree</label>
                    <input type="text" name="degree[]" placeholder="Enter your degree" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                    <label for="institution" style="display: block; margin: 4px; font-size: 16px; color: #333;">Institution</label>
                    <input type="text" name="institution[]" placeholder="Enter the institution name" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                    <label for="graduationYear" style="display: block; margin: 4px; font-size: 16px; color: #333;">Year of Graduation</label>
                    <input type="number" name="graduationYear[]" placeholder="Enter year of graduation" style="width: 95%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ddd;">

                    <button type="button" onclick="removeEducationDetail(this)" style="background-color: #ff4747; color: white; border: none; padding: 10px 15px; margin-top: 5px; cursor: pointer; border-radius: 5px; font-size: 14px;">Delete</button>
                `;
                educationDetailsSection.appendChild(newEducationDetail);
            }

            function removeEducationDetail(button) {
                var educationDetail = button.parentElement;
                educationDetail.remove();
            }

            function gatherFormData() {
                const basicData = {
                    firstName: document.getElementById('firstName').value,
                    lastName: document.getElementById('lastName').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    profileImage: document.getElementById('profileImage').files[0]
                };

                const employmentDetails = [];
                const employeeElements = document.querySelectorAll('.employmentDetails');
                employeeElements.forEach((empElement) => {
                    const company = empElement.querySelector('input[name="empCompany[]"]').value;
                    const position = empElement.querySelector('input[name="empPosition[]"]').value;
                    const joinYear = empElement.querySelector('input[name="empJoinYear[]"]').value;

                    employmentDetails.push({ company, position, joinYear });
                });

                const educationDetails = [];
                const educationElements = document.querySelectorAll('.educationDetail');
                educationElements.forEach((eduElement) => {
                    const degree = eduElement.querySelector('input[name="degree[]"]').value;
                    const institution = eduElement.querySelector('input[name="institution[]"]').value;
                    const graduationYear = eduElement.querySelector('input[name="graduationYear[]"]').value;

                    educationDetails.push({ degree, institution, graduationYear });
                });

                return { basicData, employmentDetails, educationDetails };
            }

            async function submitForm(event) {
                event.preventDefault();

                document.getElementById('submitBtn').disabled = true;
                document.getElementById('submitBtn').innerText = 'Submitting...';

                const formData = gatherFormData();

                const formDataObj = new FormData();
                formDataObj.append('firstName', formData.basicData.firstName);
                formDataObj.append('lastName', formData.basicData.lastName);
                formDataObj.append('email', formData.basicData.email);
                formDataObj.append('password', formData.basicData.password);

                formDataObj.append('employmentDetails', JSON.stringify(formData.employmentDetails));
                formDataObj.append('educationDetails', JSON.stringify(formData.educationDetails));

                if (formData.basicData.profileImage) {
                    formDataObj.append('profileImage', formData.basicData.profileImage);
                }

                try {
                    const response = await fetch('<?php echo base_url();?>index.php/user/create_user', {
                        method: 'POST',
                        body: formDataObj
                    });

                    // Handle the response
                    const responseMessage = document.getElementById('responseMessage');
                    if (response.ok) {
                        const result = await response.json();
                        responseMessage.innerHTML = `<p style="color: green;">Registration successful!</p>`;
                        alert(result.statusMsg);
                        window.location.href=result.redirctUrl;
                        console.log('Registration successful:', result);
                    } else {
                        const result = await response.json();
                        responseMessage.innerHTML = `<p style="color: red;">Error: ${result.message}</p>`;
                        console.error('Error:', result.message);
                    }
                } catch (error) {
                    const responseMessage = document.getElementById('responseMessage');
                    responseMessage.innerHTML = `<p style="color: red;">An error occurred. Please try again later.</p>`;
                    console.error('Error:', error);
                } finally {
                    document.getElementById('submitBtn').disabled = false;
                    document.getElementById('submitBtn').innerText = 'Submit';
                }
            }

            let cropper;

            let imageFile;

            // Function to open the modal and initialize cropping
            document.getElementById('profileImage').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    imageFile = file;

                    const imageUrl = URL.createObjectURL(file);

                    const imageElement = document.getElementById('imageToCrop');
                    imageElement.src = imageUrl;

                    document.getElementById('cropModal').style.display = 'block';

                    imageElement.onload = function() {
                        if (cropper) {
                            cropper.destroy();
                        }
                        cropper = new Cropper(imageElement, {
                            aspectRatio: 1,
                            viewMode: 1,
                            responsive: true,
                            autoCropArea: 0.8,
                            cropBoxResizable: true,
                            modal: true,
                        });
                    };
                }
            });

            // Function to close the modal
            function closeModal() {
                document.getElementById('cropModal').style.display = 'none';
                if (cropper) {
                    cropper.destroy();
                }
            }

            document.getElementById('saveCroppedImage').addEventListener('click', function(event) {
                event.preventDefault();
                if (!cropper) return;

                const canvas = cropper.getCroppedCanvas();

                canvas.toBlob(function(blob) {
                    const imageUrl = URL.createObjectURL(blob);
                    document.getElementById('showProfileImage').src = imageUrl;
                    croppedImageBlob = blob;
                    document.getElementById('cropModal').style.display = 'none';
                    document.getElementById('showProfileImage').style.display = 'block';
                   
                }, 'image/jpeg', 0.7);
            });
        </script>
    </body>
</html>
