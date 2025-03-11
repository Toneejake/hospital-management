<?php
session_start();
include '../includes/db.php';

// Page specific variables
$page_title = 'Doctors';
$current_page = 'doctors';

// Define common medical specializations
$specializations = [
    'Anesthesiology' => 'Anesthesiology',
    'Cardiology' => 'Cardiology',
    'Dermatology' => 'Dermatology',
    'Emergency Medicine' => 'Emergency Medicine',
    'Endocrinology' => 'Endocrinology',
    'Family Medicine' => 'Family Medicine',
    'Gastroenterology' => 'Gastroenterology',
    'General Surgery' => 'General Surgery',
    'Gynecology' => 'Gynecology',
    'Hematology' => 'Hematology',
    'Internal Medicine' => 'Internal Medicine',
    'Nephrology' => 'Nephrology',
    'Neurology' => 'Neurology',
    'Obstetrics' => 'Obstetrics',
    'Oncology' => 'Oncology',
    'Ophthalmology' => 'Ophthalmology',
    'Orthopedics' => 'Orthopedics',
    'Otolaryngology' => 'Otolaryngology (ENT)',
    'Pediatrics' => 'Pediatrics',
    'Psychiatry' => 'Psychiatry',
    'Pulmonology' => 'Pulmonology',
    'Radiology' => 'Radiology',
    'Rheumatology' => 'Rheumatology',
    'Urology' => 'Urology'
];

// Add Doctor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $contact_number = $_POST['contact_number'];

    $stmt = $conn->prepare("INSERT INTO doctors (name, specialization, contact_number) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $specialization, $contact_number);
    $stmt->execute();
    $stmt->close();
}

// Fetch Doctors
$result = $conn->query("SELECT * FROM doctors");
$doctors = $result->fetch_all(MYSQLI_ASSOC);

// Include header
include '../includes/header.php';
?>

<div class="content">
    <div class="content-header">
        <h1 class="mb-4"><?php echo $page_title; ?></h1>
    </div>

    <!-- Add Doctor Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Add New Doctor</h5>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-md-4">
                        <select name="specialization" class="form-control" required>
                            <option value="">Select Specialization</option>
                            <?php foreach ($specializations as $key => $value): ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Add Doctor
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Doctor List -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Doctor List</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($doctors as $doctor): ?>
                        <tr>
                            <td><?php echo $doctor['id']; ?></td>
                            <td><?php echo $doctor['name']; ?></td>
                            <td><?php echo $doctor['specialization']; ?></td>
                            <td><?php echo $doctor['contact_number']; ?></td>
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