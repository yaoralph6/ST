<?php
include 'db.php';

// Fetch all registrations
$stmt = $conn->prepare("SELECT * FROM Registration");
$stmt->execute();
$registrations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UC ICT Congress Registration System</title>
</head>
<body>
    <h1>UC ICT Congress Registration System</h1>
    
    <nav>
        <ul>
            <li><a href="register.php">Register</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="raffle.php">Raffle</a></li>
        </ul>
    </nav>

    <h2>Registered Students</h2>
    <table border="1">
        <tr>
            <th>ID Number</th>
            <th>Campus</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Amount Paid</th>
            <th>Attended</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($registrations as $registration) : ?>
            <tr>
                <td><?php echo htmlspecialchars($registration['IdNum']); ?></td>
                <td><?php echo htmlspecialchars($registration['campus']); ?></td>
                <td><?php echo htmlspecialchars($registration['studFName']); ?></td>
                <td><?php echo htmlspecialchars($registration['studLName']); ?></td>
                <td><?php echo htmlspecialchars($registration['amountPaid']); ?></td>
                <td><?php echo htmlspecialchars($registration['attended']); ?></td>
                <td>
                    <a href="register.php?action=edit&id=<?php echo htmlspecialchars($registration['IdNum']); ?>">Edit</a> |
                    <a href="register.php?action=delete&id=<?php echo htmlspecialchars($registration['IdNum']); ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
