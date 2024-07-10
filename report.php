<?php
include 'db.php';

// Fetch report data
$stmt = $conn->prepare("SELECT campus, COUNT(*) as registered, SUM(amountPaid) as totalCollection, SUM(CASE WHEN attended = 'Yes' THEN 1 ELSE 0 END) as attended FROM Registration GROUP BY campus");
$stmt->execute();
$reportData = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UC ICT Congress Registration System - Report</title>
</head>
<body>
    <h1>UC ICT Congress Registration System - Report</h1>
    
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="raffle.php">Raffle</a></li>
        </ul>
    </nav>

    <h2>Registration Report</h2>
    <table border="1">
        <tr>
            <th>Campus</th>
            <th>Registered</th>
            <th>Total Collection</th>
            <th>Attended</th>
        </tr>
        <?php foreach ($reportData as $data) : ?>
            <tr>
                <td><?php echo htmlspecialchars($data['campus']); ?></td>
                <td><?php echo htmlspecialchars($data['registered']); ?></td>
                <td><?php echo htmlspecialchars($data['totalCollection']); ?></td>
                <td><?php echo htmlspecialchars($data['attended']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

