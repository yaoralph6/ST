<?php
include 'db.php';

// Handle raffle
$raffleWinner = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['raffle'])) {
    $campus = $_POST['campus'];
    $stmt = $conn->prepare("SELECT * FROM Registration WHERE campus = ? ORDER BY RAND() LIMIT 1");
    $stmt->execute([$campus]);
    $raffleWinner = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UC ICT Congress Registration System - Raffle</title>
</head>
<body>
    <h1>UC ICT Congress Registration System - Raffle</h1>
    
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="report.php">Report</a></li>
        </ul>
    </nav>

    <h2>Raffle Draw</h2>
    <form action="raffle.php" method="post">
        Campus: <input type="text" name="campus" required><br>
        <input type="submit" name="raffle" value="Draw Winner">
    </form>

    <?php if ($raffleWinner) : ?>
        <h3>Winner</h3>
        <p>
            ID Number: <?php echo htmlspecialchars($raffleWinner['IdNum']); ?><br>
            Campus: <?php echo htmlspecialchars($raffleWinner['campus']); ?><br>
            First Name: <?php echo htmlspecialchars($raffleWinner['studFName']); ?><br>
            Last Name: <?php echo htmlspecialchars($raffleWinner['studLName']); ?><br>
        </p>
    <?php endif; ?>
</body>
</html>
