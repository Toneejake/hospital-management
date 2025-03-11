<?php
session_start();
include '../includes/db.php';

// Page specific variables
$page_title = 'Bills';
$current_page = 'bills';

// Add Bill
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("INSERT INTO bills (patient_id, amount) VALUES (?, ?)");
    $stmt->bind_param("id", $patient_id, $amount);
    $stmt->execute();
    $stmt->close();
}

// Fetch Bills
$result = $conn->query("SELECT b.id, p.name AS patient_name, b.amount, b.status FROM bills b JOIN patients p ON b.patient_id = p.id");
$bills = $result->fetch_all(MYSQLI_ASSOC);

// Fetch Patients for dropdown
$patients = $conn->query("SELECT id, name FROM patients")->fetch_all(MYSQLI_ASSOC);

// Include header
include '../includes/header.php';
?>

<div class="content">
    <div class="content-header">
        <h1 class="mb-4"><?php echo $page_title; ?></h1>
    </div>

    <!-- Add Bill Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Add New Bill</h5>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <select name="patient_id" class="form-control" required>
                            <option value="">Select Patient</option>
                            <?php foreach ($patients as $patient): ?>
                            <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="Amount" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Add Bill
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bills List -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Bill List</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bills as $bill): ?>
                        <tr>
                            <td><?php echo $bill['id']; ?></td>
                            <td><?php echo $bill['patient_name']; ?></td>
                            <td>$<?php echo number_format($bill['amount'], 2); ?></td>
                            <td><?php echo $bill['status']; ?></td>
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