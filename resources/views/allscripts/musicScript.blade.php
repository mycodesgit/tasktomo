<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let player;
    let isPlaying = false;
    let currentStationIndex = 0; // Start with first station (Chillhop)

    const stations = [
        //'5yx6BWlEVcY',   // Chillhop Radio - Jazzy & Lofi Hip Hop Beats
        'gFbs586qdbc',   // Lofi beats chill hip hop/ Lofi Hip Hop Beats to Relax & Study to (Chill Beats) Study Music Lofi
        //'jfKfPfyJRdk',   // Lofi Girl Radio
        //'4xDzrJKXOOY',   // synthwave radio 🌌 beats to chill/game to
        '0w80F8FffQ4',   // Zero Distraction - Coding Music
        'tXB7odE1HuA',   // Cosmic Hippo | Coding Session
        'oM_OFNmkt5A',   // Vibe Coding Music – Stay Focused, No Distractions Mix
        'UDN1pg3cuYc',   // The Ultimate Retro Lofi Jazz Hip Hop Beat
        'hbPoX4vjB5o',   // Zero Distractions - Chillstep Mix for Full Focus
    ];

    // No auto-creation: Player loads on first button click
    function onYouTubeIframeAPIReady() {
        // API is ready, but we create player lazily on button press
    }

    function createPlayer(startId, shouldAutoPlay = false) {
        if (player) return; // Already created

        player = new YT.Player('musicyoutube', {
            height: '200', // Compact height for card
            width: '100%',
            videoId: startId,
            playerVars: {
                'autoplay': shouldAutoPlay ? 1 : 0, // Auto-play if requested
                'loop': 1,
                'playlist': startId, // Loop the stream
                'controls': 1, // Show YouTube controls
                'modestbranding': 1, // Minimal branding
                'rel': 0 // No related videos
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        // Player is ready; update controls if needed
        updateMusicControls();
    }

    function onPlayerStateChange(event) {
        const playPauseBtn = document.getElementById('musicPlayPause');
        const nextBtn = document.getElementById('musicNext');

        if (event.data === YT.PlayerState.PLAYING) {
            isPlaying = true;
            if (playPauseBtn) {
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
            }
            if (nextBtn) {
                nextBtn.style.display = 'inline-block'; // Show Next when playing
            }
        } else {
            isPlaying = false;
            if (playPauseBtn) {
                playPauseBtn.innerHTML = '<i class="fas fa-play"></i> Play';
            }
            if (nextBtn) {
                nextBtn.style.display = 'none'; // Hide Next when not playing
            }
        }
    }

    function updateMusicControls() {
        const playPauseBtn = document.getElementById('musicPlayPause');
        const nextBtn = document.getElementById('musicNext');

        if (playPauseBtn) {
            playPauseBtn.onclick = togglePlayPause;
        }
        if (nextBtn) {
            nextBtn.onclick = nextTrack;
            nextBtn.style.display = 'none'; // Initially hide Next
        }
    }

    function togglePlayPause() {
        if (!player) {
            // First click: Create and auto-play the first station
            createPlayer(stations[0], true);
            return;
        }

        const currentState = player.getPlayerState();
        if (currentState === YT.PlayerState.PLAYING) {
            player.pauseVideo();
        } else {
            player.playVideo();
        }
    }

    function nextTrack() {
        if (!player) {
            // First click: Create and auto-play the next station (skip to index 1)
            currentStationIndex = (currentStationIndex + 1) % stations.length;
            createPlayer(stations[currentStationIndex], true);
            return;
        }

        // Cycle to the next station and load/auto-play
        currentStationIndex = (currentStationIndex + 1) % stations.length;
        const nextId = stations[currentStationIndex];
        player.loadVideoById(nextId);
    }

    // Initialize controls on load (handlers attach early; creation is lazy)
    document.addEventListener('DOMContentLoaded', function() {
        updateMusicControls();
    });
</script>