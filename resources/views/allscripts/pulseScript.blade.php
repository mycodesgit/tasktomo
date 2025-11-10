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

        for (let day = 0; day < 7; day++) {
        const dayIndex = week * 7 + day;
        const currentDate = new Date(startOfYear);
        currentDate.setDate(currentDate.getDate() + dayIndex);

        if (currentDate > now) break;

        const dot = document.createElement("div");
        dot.className = "day-dot";

        // Format tooltip text dynamically
        const weekday = currentDate.toLocaleDateString("en-US", { weekday: "long" });
        const month = currentDate.toLocaleDateString("en-US", { month: "long" });
        const dayNum = currentDate.getDate();
        const year = currentDate.getFullYear();

        const tooltip = document.createElement("div");
        tooltip.className = "tooltip";
        tooltip.innerHTML = `<strong>Rest</strong><br>${weekday}, ${month} ${dayNum}, ${year}`;

        dot.appendChild(tooltip);
        weekCol.appendChild(dot);
        }

        weeksWrapper.appendChild(weekCol);
    }
</script>