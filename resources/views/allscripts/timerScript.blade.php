<script>
    let timeLeft = 0; // Initial: 00:00
    let initialTime = 0;
    let timerId;
    let isRunning = false;
    let isPaused = false;

    function setDuration() {
        const select = document.getElementById('sessionType');
        if (!select) {
            console.warn('Session type select not found; using default duration.');
            return;
        }
        initialTime = parseInt(select.value);
        if (!isRunning && !isPaused) {
            timeLeft = initialTime;
            updateTimer();
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
                <button class="btn btn-success btn-lg ml-2" onclick="resumeTimer()"><i class="fas fa-play"></i> Resume</button>
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
        if (!timerId && initialTime > 0) { // Prevent start if no duration selected
            isRunning = true;
            isPaused = false;
            timerId = setInterval(() => {
                timeLeft--;
                updateTimer();
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    timerId = null;
                    isRunning = false;
                    isPaused = false;
                    alert('Session complete!');
                    updateControls();
                }
            }, 1000);
            updateControls();
        } else if (initialTime === 0) {
            alert('Please select a session duration first!');
        }
    }

    function pauseTimer() {
        if (timerId) {
            clearInterval(timerId);
            timerId = null;
            isRunning = false;
            isPaused = true;
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
        }
    }

    // Initial setup: Use DOMContentLoaded to ensure elements exist
    document.addEventListener('DOMContentLoaded', function() {
        setDuration(); // Sets to 0 initially since no default value
        updateTimer();
        updateControls();
    });
</script>