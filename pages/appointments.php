<?php
session_start();
include '../includes/db.php';

// Page specific variables
$page_title = 'Appointments';
$current_page = 'appointments';

// Add Appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $patient_id, $doctor_id, $appointment_date);
    $stmt->execute();
    $stmt->close();
}

// Fetch Appointments
$result = $conn->query("SELECT a.id, p.name AS patient_name, d.name AS doctor_name, a.appointment_date, a.status FROM appointments a JOIN patients p ON a.patient_id = p.id JOIN doctors d ON a.doctor_id = d.id");
$appointments = $result->fetch_all(MYSQLI_ASSOC);

// Fetch Patients and Doctors for dropdowns
$patients = $conn->query("SELECT id, name FROM patients")->fetch_all(MYSQLI_ASSOC);
$doctors = $conn->query("SELECT id, name FROM doctors")->fetch_all(MYSQLI_ASSOC);

// Include header
include '../includes/header.php';
?>

<div class="content">
    <div class="content-header">
        <h1 class="mb-4"><?php echo $page_title; ?></h1>
    </div>

    <!-- Add Appointment Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Schedule New Appointment</h5>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <select name="patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="doctor_id" class="form-control" required>
                            <option value="">Select Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                            <option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="datetime-local" name="appointment_date" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-2"></i>Schedule Appointment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointments List -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Appointment List</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Appointment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $appointment['patient_name']; ?></td>
                            <td><?php echo $appointment['doctor_name']; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['status']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>