<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}


include 'includes/db.php';

// Fetch the number of doctors
$sql_doctors = "SELECT COUNT(*) as doctor_count FROM doctors";
$result_doctors = $conn->query($sql_doctors);
$doctor_count = $result_doctors->fetch_assoc()['doctor_count'];

// Fetch the number of patients
$sql_patients = "SELECT COUNT(*) as patient_count FROM patients";
$result_patients = $conn->query($sql_patients);
$patient_count = $result_patients->fetch_assoc()['patient_count'];

// Fetch the most recent doctors (limit to 5)
$sql_recent_doctors = "SELECT * FROM doctors ORDER BY created_at DESC LIMIT 5";
$result_recent_doctors = $conn->query($sql_recent_doctors);
$recent_doctors = $result_recent_doctors->fetch_all(MYSQLI_ASSOC);

// Fetch the most recent patients (limit to 5)
$sql_recent_patients = "SELECT * FROM patients ORDER BY created_at DESC LIMIT 5";
$result_recent_patients = $conn->query($sql_recent_patients);
$recent_patients = $result_recent_patients->fetch_all(MYSQLI_ASSOC);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Main Menu</h2>
        <nav class="mt-4">
            <a href="pages/patients.php" class="d-flex align-items-center">
                <i class="fas fa-users mx-2"></i>
                Patients
            </a>
            <a href="pages/doctors.php" class="d-flex align-items-center">
                <i class="fas fa-user-md mx-2"></i>
                Doctors
            </a>
            <a href="pages/appointments.php" class="d-flex align-items-center">
                <i class="fas fa-calendar-alt mx-2"></i>
                Appointments
            </a>
            <a href="pages/bills.php" class="d-flex align-items-center">
                <i class="fas fa-file-invoice-dollar mx-2"></i>
                Bills
            </a>
            <a href="pages/drug_recommendations.php" class="d-flex align-items-center">
                <i class="fas fa-pills mx-2"></i>
                Drug Recommendations
            </a>
        </nav>
        <a href="auth/logout.php" class="d-flex align-items-center">
            <i class="fas fa-sign-out-alt mr-2"></i>
            Logout
        </a>
    </div>

    <div class="navbar">
        <h2>Hospital Management System</h2>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <a href="pages/doctors.php" class="card text-decoration-none">
                    <div class="card-body shadow-lg rounded">
                        <h3>Doctors</h3>
                        <p>Total Doctors: <?php echo $doctor_count; ?></p>
                        <p>View and manage doctors</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="pages/patients.php" class="card text-decoration-none">
                    <div class="card-body shadow-lg rounded">
                        <h3>Patients</h3>
                        <p>Total Patients: <?php echo $patient_count; ?></p>
                        <p>View and manage patients</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-4">
                <a href="pages/drug_recommendations.php" class="card text-decoration-none">
                    <div class="card-body shadow-lg rounded">
                        <h3>Drug Recommendations</h3>
                        <p>Find suitable medications</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Doctors and Patients -->
        <div class="row mt-5">
            <!-- Recent Doctors -->
            <div class="col-md-6">
                <div class="card shadow-lg rounded">
                    <div class="card-body">
                        <h3>Recently Registered Doctors</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Specialization</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_doctors as $doctor): ?>
                                    <tr>
                                        <td><?php echo $doctor['name']; ?></td>
                                        <td><?php echo $doctor['specialization']; ?></td>
                                        <td><?php echo $doctor['created_at']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Patients -->
            <div class="col-md-6">
                <div class="card shadow-lg rounded">
                    <div class="card-body">
                        <h3>Recently Registered Patients</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_patients as $patient): ?>
                                    <tr>
                                        <td><?php echo $patient['name']; ?></td>
                                        <td><?php echo $patient['gender']; ?></td>
                                        <td><?php echo $patient['created_at']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>