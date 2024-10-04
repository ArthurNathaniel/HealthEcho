<?php
// analytics.php or viewsuggestions.php
include('db.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Fetch suggestions from the database
$sql = "SELECT id, name, role, suggestion, created_at FROM suggestions ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Suggestions - HealthEcho</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Submitted Suggestions</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Suggestion</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($suggestions) > 0): ?>
                <?php foreach ($suggestions as $suggestion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($suggestion['id']); ?></td>
                        <td><?php echo htmlspecialchars($suggestion['name']); ?></td>
                        <td><?php echo htmlspecialchars($suggestion['role']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($suggestion['suggestion'])); ?></td>
                        <td><?php echo date('Y-m-d h:i A', strtotime($suggestion['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No suggestions have been submitted yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
