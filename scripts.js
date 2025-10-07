document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const updateProfilePicForm = document.getElementById('updateProfilePicForm');
    const profilePicInput = document.getElementById('profilePicInput');
    const profilePicImage = document.getElementById('profilePic');
    
    // Form validation for login
    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            if (username === "" || password === "") {
                alert("Please fill in all fields");
                e.preventDefault();
            }
        });
    }

    // Form validation for registration
    if (registerForm) {
        registerForm.addEventListener("submit", function(e) {
            const firstName = document.getElementById("firstName").value;
            const lastName = document.getElementById("lastName").value;
            const username = document.getElementById("username").value;
            const email = document.getElementById("email").value;
            const email2 = document.getElementById("email2").value;
            const password = document.getElementById("password").value;
            const password2 = document.getElementById("password2").value;
            
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z]{4,})(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (firstName === "" || lastName === "" || username === "" || email === "" || email2 === "" || password === "" || password2 === "") {
                alert("Please fill in all fields");
                e.preventDefault();
            } else if (email !== email2) {
                alert("Emails do not match");
                e.preventDefault();
            } else if (!emailPattern.test(email)) {
                alert("Please enter a valid email address");
                e.preventDefault();
            } else if (password !== password2) {
                alert("Passwords do not match");
                e.preventDefault();
            } else if (!passwordPattern.test(password)) {
                alert("Password must contain at least 1 uppercase letter, 4 lowercase letters, 1 number, 1 special character, and be at least 8 characters long.");
                e.preventDefault();
            }
        });
    }

    // Profile picture update handler
    if (updateProfilePicForm) {
        updateProfilePicForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('profilePic', profilePicInput.files[0]);

            fetch('update_profile_pic.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    profilePicImage.src = data.profilePic;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Ensure only one song plays at a time
    const audioElements = document.querySelectorAll('audio'); // Select all audio elements

    audioElements.forEach((audio) => {
        audio.addEventListener('play', function() {
            audioElements.forEach((otherAudio) => {
                if (otherAudio !== audio) {
                    otherAudio.pause();
                    otherAudio.currentTime = 0; // Reset the paused audio to the beginning
                }
            });
        });
    });
});
