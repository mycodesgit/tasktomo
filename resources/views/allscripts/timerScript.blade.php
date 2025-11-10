<script>
    let timeLeft = 0; // Initial: 00:00
    let initialTime = 0;
    let timerId;
    let isRunning = false;
    let isPaused = false;

    function saveState() {
        localStorage.setItem('initialTime', initialTime.toString());
        localStorage.setItem('timeLeft', timeLeft.toString());
        localStorage.setItem('isRunning', isRunning.toString());
        localStorage.setItem('isPaused', isPaused.toString());
        if (isRunning) {
            const endTime = Date.now() + timeLeft * 1000;
            localStorage.setItem('endTime', endTime.toString());
        } else {
            localStorage.removeItem('endTime');
        }
    }

    function loadState() {
        const savedInitialTime = localStorage.getItem('initialTime');
        if (savedInitialTime) {
            initialTime = parseInt(savedInitialTime);
        }

        const savedIsRunning = localStorage.getItem('isRunning') === 'true';
        const savedIsPaused = localStorage.getItem('isPaused') === 'true';
        const endTimeStr = localStorage.getItem('endTime');
        const endTime = endTimeStr ? parseInt(endTimeStr) : null;

        isRunning = savedIsRunning;
        isPaused = savedIsPaused;

        // Set the radio button based on saved initialTime
        const radios = document.querySelectorAll('input[name="sessionType"]');
        radios.forEach(r => {
            if (parseInt(r.value) === initialTime) {
                r.checked = true;
            }
        });

        // Set timeLeft based on state
        if (isRunning && endTime) {
            const now = Date.now();
            timeLeft = Math.max(0, Math.floor((endTime - now) / 1000));
            updateTimer();
            if (timeLeft > 0) {
                // Resume the running timer
                startTimer();
                return;
            } else {
                // Session completed during offline time
                alert('Session complete!');
                localStorage.removeItem('isRunning');
                localStorage.removeItem('endTime');
                isRunning = false;
                timeLeft = initialTime;
                updateTimer();
            }
        } else if (isPaused) {
            const savedTimeLeft = localStorage.getItem('timeLeft');
            timeLeft = savedTimeLeft ? parseInt(savedTimeLeft) : initialTime;
            updateTimer();
        } else {
            timeLeft = initialTime;
            updateTimer();
        }
    }

    function setDuration() {
        const radios = document.querySelectorAll('input[name="sessionType"]');
        const selected = Array.from(radios).find(r => r.checked);
        if (selected) {
            initialTime = parseInt(selected.value);
            if (!isRunning && !isPaused) {
                timeLeft = initialTime;
                updateTimer();
            }
            saveState();
        }
    }

    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        const timerElement = document.getElementById('timer');
        if (timerElement) {
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }
    }

    function updateHeader() {
        const headerElement = document.getElementById('timeHeader');
        if (!headerElement) return;

        if (isRunning) {
            headerElement.textContent = 'Working Time';
        } else if (isPaused)  {
            headerElement.textContent = 'Paused Time';
        } else {
            headerElement.textContent = 'Start Time';
        }
    }

    function updateControls() {
        const controlsDiv = document.getElementById('timerControls');
        if (!controlsDiv) return;

        controlsDiv.innerHTML = '';

        if (!isRunning && !isPaused) {
            // Initial/Stopped state: Show Start, and reset time
            timeLeft = initialTime;
            updateTimer();
            controlsDiv.innerHTML = `<button class="btn btn-success btn-lg" id="startBtn" onclick="startTimer()"><i class="fas fa-play"></i> Start</button>`;
        } else if (isRunning) {
            // Running state: Show Pause and Stop
            controlsDiv.innerHTML = `
                <button class="btn btn-warning btn-lg" onclick="pauseTimer()"><i class="fas fa-pause"></i> Pause</button>
                <button class="btn btn-danger btn-lg ml-2" onclick="stopTimer()"><i class="fas fa-stop"></i> Stop</button>
            `;
        } else if (isPaused) {
            // Paused state: Show Resume and Stop
            controlsDiv.innerHTML = `
                <button class="btn btn-success btn-lg" onclick="resumeTimer()"><i class="fas fa-play"></i> Resume</button>
                <button class="btn btn-danger btn-lg ml-2" onclick="stopTimer()"><i class="fas fa-stop"></i> Stop</button>
            `;
        }

        // Update header based on state
        updateHeader();

        const focusLabel = document.getElementById('focusLabel');
        if (focusLabel) {
            if (isRunning || isPaused) {
                focusLabel.style.display = 'block';
            } else {
                focusLabel.style.display = 'none';
            }
        }
    }

    function startTimer() {
        if (timeLeft <= 0) {
            alert('Please select a session duration first!');
            return;
        }
        if (!timerId) {
            isRunning = true;
            isPaused = false;
            const endTime = Date.now() + timeLeft * 1000;
            localStorage.setItem('endTime', endTime.toString());
            timerId = setInterval(() => {
                timeLeft--;
                updateTimer();
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    timerId = null;
                    isRunning = false;
                    isPaused = false;
                    alert('Session complete!');
                    localStorage.removeItem('endTime');
                    localStorage.removeItem('isRunning');
                    localStorage.removeItem('isPaused');
                    updateControls();
                }
            }, 1000);
            saveState();
            updateControls();
        }
    }

    function pauseTimer() {
        if (timerId) {
            clearInterval(timerId);
            timerId = null;
            isRunning = false;
            isPaused = true;
            saveState();
            updateControls();
        }
    }

    function resumeTimer() {
        startTimer(); // Reuse start logic to resume from paused time
    }

    function stopTimer() {
        if (timerId) {
            clearInterval(timerId);
            timerId = null;
        }
        isRunning = false;
        isPaused = false;
        updateControls(); // This will reset timeLeft to initial
        saveState();
    }

    // Initial setup: Use DOMContentLoaded to ensure elements exist
    document.addEventListener('DOMContentLoaded', function() {
        loadState();
        updateControls();

        // Add event listener for duration change
        const radios = document.querySelectorAll('input[name="sessionType"]');
        radios.forEach(radio => {
            radio.addEventListener('change', setDuration);
        });
    });
</script>