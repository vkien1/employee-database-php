<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Employee Form</title>
</head>

<body>
    <h2>Add New Employee</h2>
    <form action="viewemployees.php" method="POST">
        <label for="emp_name">Employee Name:</label><br>
        <input type="text" id="emp_name" name="emp_name" required><br><br>

        <label for="job_title">Job Title:</label><br>
        <input type="text" id="job_title" name="job_title" required><br><br>

        <label for="hire_date">Hire Date:</label><br>
        <input type="date" id="hire_date" name="hire_date" required><br><br>

        <label for="salary">Salary:</label><br>
        <input type="number" step="0.01" id="salary" name="salary" required><br><br>

        <label for="dept_id">Department:</label><br>
        <select id="dept_id" name="dept_id" required>
            <?php
            session_start();

            if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
                header("Location: login.php"); // Redirect to login page if not authenticated
                exit();
            }
            // Connect to database
            $conn = new mysqli('localhost', 'root', '', 'employee_department');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch departments
            $result = $conn->query("SELECT * FROM Department");

            // Populate dropdown with department options
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['dept_id'] . "'>" . $row['name'] . "</option>";
            }

            $conn->close();
            ?>
        </select><br><br>

        <input type="submit" value="Add Employee">
    </form>
</body>

</html>