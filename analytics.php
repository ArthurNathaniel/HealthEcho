<?php
// analytics.php or viewsuggestions.php
include('db.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// The rest of your code for the analytics or view suggestions page goes here.

// Function to fetch suggestions count based on the date range
function getSuggestionsCount($pdo, $startDate, $endDate) {
    $sql = "SELECT COUNT(*) FROM suggestions WHERE created_at BETWEEN :startDate AND :endDate";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Get total suggestions
$totalSuggestions = getSuggestionsCount($pdo, '1970-01-01', date('Y-m-d H:i:s'));

// Get suggestions for this week
$weekStart = date('Y-m-d H:i:s', strtotime('monday this week'));
$weekEnd = date('Y-m-d H:i:s', strtotime('sunday this week'));
$weeklySuggestions = getSuggestionsCount($pdo, $weekStart, $weekEnd);

// Get suggestions for this month
$monthStart = date('Y-m-01 00:00:00');
$monthEnd = date('Y-m-t 23:59:59');
$monthlySuggestions = getSuggestionsCount($pdo, $monthStart, $monthEnd);

// Get suggestions for this year
$yearStart = date('Y-01-01 00:00:00');
$yearEnd = date('Y-12-31 23:59:59');
$yearlySuggestions = getSuggestionsCount($pdo, $yearStart, $yearEnd);

// Get suggestions count by role
$roleCounts = [];
$sql = "SELECT role, COUNT(*) as count FROM suggestions GROUP BY role";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $roleCounts[$row['role']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - HealthEcho</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Suggestion Analytics</h1>
    
    <h2>Total Suggestions: <?php echo $totalSuggestions; ?></h2>
    
    <h3>This Week: <?php echo $weeklySuggestions; ?></h3>
    <h3>This Month: <?php echo $monthlySuggestions; ?></h3>
    <h3>This Year: <?php echo $yearlySuggestions; ?></h3>

    <h2>Suggestions by Role</h2>
    <ul>
        <li>Staff: <?php echo isset($roleCounts['staff']) ? $roleCounts['staff'] : 0; ?></li>
        <li>Patient: <?php echo isset($roleCounts['patient']) ? $roleCounts['patient'] : 0; ?></li>
        <li>Anonymous: <?php echo isset($roleCounts['anonymous']) ? $roleCounts['anonymous'] : 0; ?></li>
    </ul>

    <!-- Chart for Total Suggestions -->
    <canvas id="suggestionsChart" style="width:100%;max-width:600px"></canvas>

    <!-- Chart for Suggestions by Role -->
    <canvas id="roleChart" style="width:100%;max-width:600px"></canvas>

    <script>
        // Data for total suggestions chart
        const totalSuggestionsData = {
            labels: ['Total', 'This Week', 'This Month', 'This Year'],
            datasets: [{
                label: 'Number of Suggestions',
                data: [<?php echo $totalSuggestions; ?>, <?php echo $weeklySuggestions; ?>, <?php echo $monthlySuggestions; ?>, <?php echo $yearlySuggestions; ?>],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        };

        const suggestionsChartConfig = {
            type: 'bar',
            data: totalSuggestionsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Create total suggestions chart
        const suggestionsChart = new Chart(
            document.getElementById('suggestionsChart'),
            suggestionsChartConfig
        );

        // Data for suggestions by role chart
        const roleChartData = {
            labels: ['Staff', 'Patient', 'Anonymous'],
            datasets: [{
                label: 'Number of Suggestions by Role',
                data: [
                    <?php echo isset($roleCounts['staff']) ? $roleCounts['staff'] : 0; ?>,
                    <?php echo isset($roleCounts['patient']) ? $roleCounts['patient'] : 0; ?>,
                    <?php echo isset($roleCounts['anonymous']) ? $roleCounts['anonymous'] : 0; ?>
                ],
                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        };

        const roleChartConfig = {
            type: 'bar',
            data: roleChartData,
            options: {
                responsive: true,
            }
        };

        // Create role chart
        const roleChart = new Chart(
            document.getElementById('roleChart'),
            roleChartConfig
        );
    </script>
</body>
</html>
