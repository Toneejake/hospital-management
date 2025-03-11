<?php
session_start();
include '../includes/db.php';

// Page specific variables
$page_title = 'Patients';
$current_page = 'patients';

// Add Patient
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO patients (name, age, gender, contact_number, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $name, $age, $gender, $contact_number, $address);
    $stmt->execute();
    $stmt->close();
}

// Fetch Patients
$result = $conn->query("SELECT * FROM patients");
$patients = $result->fetch_all(MYSQLI_ASSOC);

// Include header
include '../includes/header.php';
?>

<div class="content">
    <div class="content-header">
        <h1 class="mb-4"><?php echo $page_title; ?></h1>
    </div>

    <!-- Add Patient Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Add New Patient</h5>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="age" class="form-control" placeholder="Age" required>
                    </div>
                    <div class="col-md-2">
                        <select name="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" required>
                    </div>
                    <div class="col-12">
                        <textarea name="address" class="form-control" placeholder="Address" required></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Add Patient
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Patient List -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Patient List</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo $patient['id']; ?></td>
                            <td><?php echo $patient['name']; ?></td>
                            <td><?php echo $patient['age']; ?></td>
                            <td><?php echo $patient['gender']; ?></td>
                            <td><?php echo $patient['contact_number']; ?></td>
                            <td><?php echo $patient['address']; ?></td>
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
