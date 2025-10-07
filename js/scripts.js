document.addEventListener("DOMContentLoaded", function() {
    // Form Validation Logic
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

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

    // Audio Player Logic
    const audioPlayer = document.getElementById('audioPlayer');
    const playPauseIcon = document.getElementById('playPauseIcon');

    function togglePlayPause() {
        // Pause all other playing audio elements
        const audioElements = document.querySelectorAll('audio');
        audioElements.forEach(audio => {
            if (audio !== audioPlayer && !audio.paused) {
                audio.pause();
                audio.currentTime = 0; // Optional: Reset the playback position
            }
        });

        if (audioPlayer.paused) {
            audioPlayer.play();
            playPauseIcon.src = 'assets/icons/pause.png'; // Change to pause icon
        } else {
            audioPlayer.pause();
            playPauseIcon.src = 'assets/icons/play.png'; // Change back to play icon
        }
    }

    function playPreviousSong(prevSongId) {
        if (prevSongId) {
            window.location.href = 'song.php?song=' + prevSongId;
        } else {
            alert("No previous song available.");
        }
    }

    function playNextSong(nextSongId) {
        if (nextSongId) {
            window.location.href = 'song.php?song=' + nextSongId;
        } else {
            alert("No next song available.");
        }
    }

    function toggleLoop() {
        const loopBtn = document.getElementById('loopBtn').querySelector('img');
        audioPlayer.loop = !audioPlayer.loop;
        loopBtn.src = audioPlayer.loop ? 'assets/icons/loop-enabled.png' : 'assets/icons/loop.png';
    }

    function toggleFavorite() {
        // Implement logic to mark song as favorite
        console.log('Toggle favorite logic goes here');
    }

    function adjustVolume() {
        // Implement volume adjustment logic
        console.log('Volume adjustment logic goes here');
    }

    // Admin Functions

    // Function to view all users
    function viewAllUsers() {
        // Fetch users from the server (example using AJAX)
        fetch('admin_view_users.php')
            .then(response => response.json())
            .then(data => {
                const userList = document.getElementById('userList');
                userList.innerHTML = '';

                data.forEach(user => {
                    userList.innerHTML += `<p>${user.name} - ${user.email}</p>`;
                    // Add listening history button, etc.
                });
            });
    }

    // Function to view all queries
    function viewAllQueries() {
        // Fetch queries from the server (example using AJAX)
        fetch('admin_view_queries.php')
            .then(response => response.json())
            .then(data => {
                const queryList = document.getElementById('queryList');
                queryList.innerHTML = '';

                data.forEach(query => {
                    queryList.innerHTML += `<p>${query.subject}: ${query.message}</p>`;
                });
            });
    }

    // Expose functions to the global scope
    window.togglePlayPause = togglePlayPause;
    window.playPreviousSong = playPreviousSong;
    window.playNextSong = playNextSong;
    window.toggleLoop = toggleLoop;
    window.toggleFavorite = toggleFavorite;
    window.adjustVolume = adjustVolume;

    window.viewAllUsers = viewAllUsers;
    window.viewAllQueries = viewAllQueries;
});
