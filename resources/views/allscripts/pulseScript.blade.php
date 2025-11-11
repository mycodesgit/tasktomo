{{-- allscripts/pulseScript.blade.php --}}
<script>
    var activityDataRoute = "{{ route('fetch.activity.dates') }}"; // Define route below
</script>
<script>
    const chart = document.getElementById("activityChart");

    const now = new Date();
    const startOfYear = new Date(now.getFullYear(), 0, 1);
    const totalDays = Math.floor((now - startOfYear) / (1000 * 60 * 60 * 24)) + 1;
    const weeks = Math.ceil(totalDays / 7);

    // Month labels row
    const labelRow = document.createElement("div");
    labelRow.className = "month-labels";
    chart.appendChild(labelRow);

    // Main weeks wrapper
    const weeksWrapper = document.createElement("div");
    weeksWrapper.className = "weeks-wrapper";
    chart.appendChild(weeksWrapper);

    let lastMonth = -1;
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    // Make allDots global for access from refresh
    window.allDots = [];

    for (let week = 0; week < weeks; week++) {
        const weekCol = document.createElement("div");
        weekCol.className = "week-column";

        const dateForLabel = new Date(startOfYear);
        dateForLabel.setDate(dateForLabel.getDate() + week * 7);
        const monthIndex = dateForLabel.getMonth();

        // Add month label only once per month
        const monthLabel = document.createElement("div");
        monthLabel.style.width = "17px";
        monthLabel.style.textAlign = "center";
        monthLabel.textContent = monthIndex !== lastMonth ? months[monthIndex] : "";
        labelRow.appendChild(monthLabel);
        lastMonth = monthIndex;

        for (let d = 0; d < 7; d++) { // Renamed loop variable to 'd' to avoid conflict
            const dayIndex = week * 7 + d;
            const currentDate = new Date(startOfYear);
            currentDate.setDate(currentDate.getDate() + dayIndex);

            if (currentDate > now) break;

            const dot = document.createElement("div");
            dot.className = "day-dot";

            // Store date key for easy lookup (YYYY-MM-DD) - Use local date to match DB likely local
            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0');
            const dayNum = String(currentDate.getDate()).padStart(2, '0'); // Renamed to dayNum
            const dateKey = `${year}-${month}-${dayNum}`;
            dot.setAttribute('data-date', dateKey);

            // Format tooltip text dynamically (default to Rest)
            const weekday = currentDate.toLocaleDateString("en-US", { weekday: "long" });
            const monthFull = currentDate.toLocaleDateString("en-US", { month: "short" });
            const dayOfMonth = currentDate.getDate(); // Renamed to avoid 'day' conflict
            const yearFull = currentDate.getFullYear();

            const tooltip = document.createElement("div");
            tooltip.className = "tooltip";
            tooltip.innerHTML = `<strong>Rest</strong><br>${weekday}, ${monthFull} ${dayOfMonth}, ${yearFull}`;

            dot.appendChild(tooltip);
            weekCol.appendChild(dot);
            window.allDots.push({ dot, dateKey }); // Store for later update
        }

        weeksWrapper.appendChild(weekCol);
    }

    // Scroll to the end (last week/current month) after rendering the chart
    const chartContainer = document.querySelector('#activityChart');
    if (chartContainer) {
        // Small delay to ensure layout is complete
        setTimeout(() => {
            chartContainer.scrollLeft = chartContainer.scrollWidth;
        }, 100);
    }

    // Function to update dots based on fetched data (script-only color change) - Make global
    window.updateChartWithData = function(activitySummary) {
        //console.log('Activity summary from server:', activitySummary); // Debug: Check fetched data
        let updatedCount = 0;
        window.allDots.forEach(({ dot, dateKey }) => {
            const dayData = activitySummary.find(item => item.date === dateKey);
            if (dayData) {
                const { count } = dayData;
                let status, color, tooltipText;
                if (count < 4) {
                    status = 'Less Productive';
                    color = '#57ad86'; // Light green for Less Productive
                } else {
                    status = 'More Productive';
                    color = '#28a745'; // Dark green for More Productive
                }
                // Mark with color - force inline style to override CSS
                dot.style.backgroundColor = color;
                dot.style.border = 'none'; // Ensure no border interference

                // Update tooltip text with count
                const tooltip = dot.querySelector('.tooltip');
                const dateInfo = tooltip.innerHTML.split('<br>')[1] || '';
                tooltip.innerHTML = `<strong>${status} (${count} task${count !== 1 ? 's' : ''})</strong><br>${dateInfo}`;
                updatedCount++;
            }
        });
        //console.log(`Updated ${updatedCount} dots with activity data.`); // Debug: Check if matches occurred
    };

    // Function to refresh chart data - Make global
    window.refreshActivityChart = function() {
        $.ajax({
            url: activityDataRoute,
            type: "GET",
            dataType: "json",
            success: function(response) {
                //console.log('Full AJAX response:', response); // Debug: Full response
                if (response.success) {
                    const activitySummary = response.summary || []; // Array of {date: 'YYYY-MM-DD', count: N}
                    window.updateChartWithData(activitySummary);
                } else {
                    console.error('Failed to fetch activity data:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText); // Debug: Network errors
            }
        });
    };

    // Listen for 'dailyAdded' event to refresh chart
    $(document).on('dailyAdded', function() {
        window.refreshActivityChart();
    });

    // Initial fetch on DOM ready
    $(document).ready(function() {
        window.refreshActivityChart();
    });
</script>