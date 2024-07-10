<?php
include 'db.php';

// Handle attendance marking form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idNum'])) {
    $idNum = $_POST['idNum'];

    try {
        // Update the Registration table to mark the student as attended
        $stmt = $conn->prepare("UPDATE Registration SET attended = 'Yes' WHERE IdNum = ?");
        $stmt->execute([$idNum]);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Fetch registration records
$stmt = $conn->prepare("SELECT * FROM Registration WHERE attended = 'Yes'");
$stmt->execute();
$attendanceRecords = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UC ICT Congress Registration System - Attendance</title>
</head>
<body>
    <h1>UC ICT Congress Registration System - Attendance</h1>
    
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="raffle.php">Raffle</a></li>
        </ul>
    </nav>

    <h2>Mark Attendance</h2>
    <form action="attendance.php" method="post">
        ID Number: <input type="text" name="idNum" required><br>
        <input type="submit" value="Mark Attendance">
    </form>

    <h2>Attendance Records</h2>
    <table border="1">
        <tr>
            <th>ID Number</th>
            <th>Campus</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Amount Paid</th>
        </tr>
        <?php foreach ($attendanceRecords as $record) : ?>
            <tr>
                <td><?php echo htmlspecialchars($record['IdNum']); ?></td>
                <td><?php echo htmlspecialchars($record['campus']); ?></td>
                <td><?php echo htmlspecialchars($record['studFName']); ?></td>
                <td><?php echo htmlspecialchars($record['studLName']); ?></td>
                <td><?php echo htmlspecialchars($record['amountPaid']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
