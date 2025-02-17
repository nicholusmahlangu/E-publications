<?php
session_start();
date_default_timezone_set('UTC');

// Store predefined holidays
$holidays = [
    "2025-01-01" => "New Year’s Day",
    "2025-03-21" => "Human Rights Day",
    "2025-04-18" => "Good Friday",
    "2025-04-21" => "Family Day",
    "2025-04-27" => "Freedom Day",
    "2025-05-01" => "Workers' Day",
    "2025-06-16" => "Youth Day",
    "2025-08-09" => "National Women’s Day",
    "2025-09-24" => "Heritage Day",
    "2025-12-16" => "Day of Reconciliation",
    "2025-12-25" => "Christmas Day",
    "2025-12-26" => "Day of Goodwill"
];

// Handle Event Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_date']) && isset($_POST['event_name'])) {
    $_SESSION['events'][$_POST['event_date']] = $_POST['event_name'];
}

// Generate Calendar Function
function generateCalendar($year, $month = null) {
    global $holidays;
    
    $months = [
        1 => "January", 2 => "February", 3 => "March", 4 => "April",
        5 => "May", 6 => "June", 7 => "July", 8 => "August",
        9 => "September", 10 => "October", 11 => "November", 12 => "December"
    ];
    
    echo '<div class="row">';
    
    $monthsToShow = $month ? [$month => $months[$month]] : $months;
    
    foreach ($monthsToShow as $monthNum => $monthName) {
        echo '<div class="col-md-4">';
        echo '<div class="card mb-3">';
        echo '<div class="card-header text-center"><strong>' . $monthName . ' ' . $year . '</strong></div>';
        echo '<div class="card-body"><table class="table table-bordered">';
        
        // Days of the Week
        echo '<tr class="bg-light"><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>';
        
        // Get first day of the month
        $firstDay = date('w', strtotime("$year-$monthNum-01"));
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNum, $year);
        
        // Print empty cells before first day
        for ($i = 0; $i < $firstDay; $i++) echo '<td></td>';
        
        // Print actual days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $fullDate = "$year-$monthNum-$day";
            $isHoliday = isset($holidays[$fullDate]);
            $isWeekend = (date('N', strtotime($fullDate)) >= 6);
            $isToday = ($fullDate == date('Y-m-d'));
            $hasEvent = isset($_SESSION['events'][$fullDate]);

            $cellClass = $isToday ? 'bg-warning' : ($isHoliday ? 'bg-danger text-white' : ($isWeekend ? 'bg-light' : ''));
            $eventText = $hasEvent ? "<br><small><em>{$_SESSION['events'][$fullDate]}</em></small>" : "";

            echo "<td class='day $cellClass' data-date='$fullDate'>$day $eventText</td>";

            if (($day + $firstDay) % 7 == 0) echo '</tr><tr>'; // New row on Sunday
        }

        // Print empty cells at the end
        while (($day + $firstDay) <= 35) {
            echo '<td></td>';
            $day++;
        }

        echo '</tr></table></div></div></div>';
    }
    
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2025 Calendar with Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .day { text-align: center; cursor: pointer; }
        .day:hover { background-color: #e3f2fd; }
    </style>
</head>
<body>

<div class="container mt-4">
    <a href="adminDashboard.php" class="btn btn-secondary mb-3">&larr; Back to Dashboard</a>
    <h2 class="text-center">2025 Calendar with Events</h2>
    
    <!-- Month Filter -->
    <div class="text-center mb-3">
        <label for="monthFilter">Select Month:</label>
        <select id="monthFilter" class="form-select d-inline w-auto">
            <option value="">All Year</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 1, 2025)) ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Calendar Display -->
    <div id="calendarContainer">
        <?php generateCalendar(2025); ?>
    </div>

    <!-- Event Form -->
    <div class="card mt-4">
        <div class="card-header">Add an Event</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="event_date" class="form-label">Select Date:</label>
                    <input type="date" id="event_date" name="event_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="event_name" class="form-label">Event Name:</label>
                    <input type="text" id="event_name" name="event_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Event</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Highlight today
    $(".day").each(function () {
        let today = new Date().toISOString().split('T')[0];
        if ($(this).data("date") === today) {
            $(this).css("background-color", "#ffeb3b");
        }
    });

    // Click event on dates
    $(".day").click(function () {
        alert("You clicked on " + $(this).data("date"));
    });

    // Month filter using AJAX
    $("#monthFilter").change(function () {
        let selectedMonth = $(this).val();
        $.post("calendar.php", { month: selectedMonth }, function (data) {
            $("#calendarContainer").html($(data).find("#calendarContainer").html());
        });
    });
});
</script>

</body>
</html>
