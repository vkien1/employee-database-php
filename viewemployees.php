<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Redirect to login page if not authenticated
    exit();
}
// Database connection
$conn = new mysqli('localhost', 'root', '', 'employee_department');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $emp_name = $_POST['emp_name'];
    $job_title = $_POST['job_title'];
    $hire_date = $_POST['hire_date'];
    $salary = $_POST['salary'];
    $dept_id = $_POST['dept_id'];

    // Prepare and execute the SQL statement to insert data into Employee table
    $stmt = $conn->prepare("INSERT INTO Employee (emp_name, job_title, hire_date, salary, dept_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdi", $emp_name, $job_title, $hire_date, $salary, $dept_id);

    if ($stmt->execute()) {
        echo "New employee added successfully.<br><br>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Fetch and display employee data
$sql = "SELECT Employee.emp_id, Employee.emp_name, Employee.job_title, Employee.hire_date, Employee.salary, Department.name AS department
        FROM Employee
        JOIN Department ON Employee.dept_id = Department.dept_id";
$result = $conn->query($sql);

// Display the result if there are any employees
if ($result->num_rows > 0) {
    echo "<h2>Employee List</h2>";
    echo "<table border='1'>
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Job Title</th>
                <th>Hire Date</th>
                <th>Salary</th>
                <th>Department</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['emp_id'] . "</td>
                <td>" . $row['emp_name'] . "</td>
                <td>" . $row['job_title'] . "</td>
                <td>" . $row['hire_date'] . "</td>
                <td>" . $row['salary'] . "</td>
                <td>" . $row['department'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No employees found.";
}

// Close the database connection
$conn->close();
?>

<br>
<button onclick="window.location.href='newemployee.php';">Back to Add Employee</button>
<a href="logout.php">Logout</a> <!-- Add a logout link -->