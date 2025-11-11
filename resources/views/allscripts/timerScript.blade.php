<script>
    let timeLeft = 0; // Initial: 00:00
    let initialTime = 0;
    let breakDuration = 300; // 5 minutes in seconds
    let timerId;
    let isRunning = false;
    let isPaused = false;
    let isBreak = false;

    function playBeep() {
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            oscillator.frequency.value = 800; // Hz
            oscillator.type = 'sine';
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 1);
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 1);
        } catch (e) {
            // Fallback: console beep or ignore if AudioContext not supported
            console.log('\u{1f514}'); // Bell emoji in console
        }
    }

    function saveState() {
        localStorage.setItem('initialTime', initialTime.toString());
        localStorage.setItem('timeLeft', timeLeft.toString());
        localStorage.setItem('isRunning', isRunning.toString());
        localStorage.setItem('isPaused', isPaused.toString());
        localStorage.setItem('isBreak', isBreak.toString());
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
        const savedIsBreak = localStorage.getItem('isBreak') === 'true';
        const endTimeStr = localStorage.getItem('endTime');
        const endTime = endTimeStr ? parseInt(endTimeStr) : null;

        isRunning = savedIsRunning;
        isPaused = savedIsPaused;
        isBreak = savedIsBreak;

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
                if (isBreak) {
                    startBreakTimer();
                } else {
                    startTimer();
                }
                return;
            } else {
                // Session completed during offline time
                if (isBreak) {
                    Swal.fire({
                        title: '⏰ Break Complete!',
                        text: 'Time to start your next session!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 4000,
                        timerProgressBar: true,
                    });
                    localStorage.removeItem('isRunning');
                    localStorage.removeItem('endTime');
                    localStorage.removeItem('isBreak');
                    isRunning = false;
                    isBreak = false;
                } else {
                    playBeep();
                    Swal.fire({
                        title: '⏰ Session Complete!',
                        text: `Your timer has finished! Total time: ${initialTime / 60} minutes.`,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 4000,
                        timerProgressBar: true,
                    });
                    localStorage.removeItem('isRunning');
                    localStorage.removeItem('endTime');
                    isRunning = false;
                }
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

        if (isBreak) {
            headerElement.textContent = 'Break Time';
        } else if (isRunning) {
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
                if (isBreak) {
                    focusLabel.textContent = 'Break Time Left:';
                } else {
                    focusLabel.textContent = 'Focus Time Left:';
                }
            } else {
                focusLabel.style.display = 'none';
            }
        }
    }

    function startTimer() {
        if (timeLeft <= 0) {
            Swal.fire({
                title: 'Note!',
                text: `Please select a session duration first!`,
                icon: 'warning',
                confirmButtonText: 'OK',
                timer: 6000,
                timerProgressBar: true,
            });
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
                    playBeep();
                    Swal.fire({
                        title: '⏰ Session Complete!',
                        text: `Great job! Total time: ${initialTime / 60} minutes. Taking a 5-minute break now.`,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 4000,
                        timerProgressBar: true,
                    });
                    // Start break after work session
                    isBreak = true;
                    timeLeft = breakDuration;
                    updateTimer();
                    startBreakTimer();
                    saveState();
                }
            }, 1000);
            saveState();
            updateControls();
        }
    }

    function startBreakTimer() {
        if (!timerId && timeLeft > 0) {
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
                    isBreak = false;
                    Swal.fire({
                        title: '⏰ Break Complete!',
                        text: 'Time to start your next session!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 4000,
                        timerProgressBar: true,
                    });
                    timeLeft = initialTime;
                    updateTimer();
                    localStorage.removeItem('endTime');
                    localStorage.removeItem('isRunning');
                    localStorage.removeItem('isPaused');
                    localStorage.removeItem('isBreak');
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
        if (isBreak) {
            startBreakTimer();
        } else {
            startTimer();
        }
    }

    function stopTimer() {
        if (timerId) {
            clearInterval(timerId);
            timerId = null;
        }
        isRunning = false;
        isPaused = false;
        isBreak = false;
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