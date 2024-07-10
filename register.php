<?php
include 'db.php';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $idNum = $_POST['idNum'];
    $campus = $_POST['campus'];
    $studFName = $_POST['studFName'];
    $studLName = $_POST['studLName'];
    $amountPaid = $_POST['amountPaid'];
    $attended = $_POST['attended'];

    try {
        $stmt = $conn->prepare("INSERT INTO Registration (IdNum, campus, studFName, studLName, amountPaid, attended) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$idNum, $campus, $studFName, $studLName, $amountPaid, $attended]);

        // Redirect to avoid form resubmission
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $idNum = $_POST['idNum'];
    $campus = $_POST['campus'];
    $studFName = $_POST['studFName'];
    $studLName = $_POST['studLName'];
    $amountPaid = $_POST['amountPaid'];
    $attended = $_POST['attended'];

    try {
        $stmt = $conn->prepare("UPDATE Registration SET campus = ?, studFName = ?, studLName = ?, amountPaid = ?, attended = ? WHERE IdNum = ?");
        $stmt->execute([$campus, $studFName, $studLName, $amountPaid, $attended, $idNum]);

        // Redirect to avoid form resubmission
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $idNum = $_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM Registration WHERE IdNum = ?");
        $stmt->execute([$idNum]);

        // Redirect to avoid repeated deletion on refresh
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Handle edit action
$registration = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $idNum = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM Registration WHERE IdNum = ?");
    $stmt->execute([$idNum]);
    $registration = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UC ICT Congress Registration System - Register</title>
</head>
<body>
    <h1>UC ICT Congress Registration System - Register</h1>
    
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="report.php">Report</a></li>
            <li><a href="raffle.php">Raffle</a></li>
        </ul>
    </nav>

    <h2><?php echo $registration ? 'Edit' : 'Register'; ?> Student</h2>
    <form action="register.php" method="post">
        <?php if ($registration) : ?>
            <input type="hidden" name="edit" value="1">
            <input type="hidden" name="idNum" value="<?php echo htmlspecialchars($registration['IdNum']); ?>">
        <?php else : ?>
            <input type="hidden" name="register" value="1">
            ID Number: <input type="text" name="idNum" required><br>
        <?php endif; ?>
        Campus: <input type="text" name="campus" value="<?php echo $registration ? htmlspecialchars($registration['campus']) : ''; ?>" required><br>
        First Name: <input type="text" name="studFName" value="<?php echo $registration ? htmlspecialchars($registration['studFName']) : ''; ?>" required><br>
        Last Name: <input type="text" name="studLName" value="<?php echo $registration ? htmlspecialchars($registration['studLName']) : ''; ?>" required><br>
        Amount Paid: <input type="number" name="amountPaid" value="<?php echo $registration ? htmlspecialchars($registration['amountPaid']) : ''; ?>" required step="0.01"><br>
        Attended: 
        <select name="attended" required>
            <option value="Yes" <?php if ($registration && $registration['attended'] == 'Yes') echo 'selected'; ?>>Yes</option>
            <option value="No" <?php if ($registration && $registration['attended'] == 'No') echo 'selected'; ?>>No</option>
        </select><br>
        <input type="submit" value="<?php echo $registration ? 'Save Changes' : 'Register'; ?>">
    </form>
</body>
</html>
