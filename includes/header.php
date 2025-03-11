<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="navbar">
        <h2><a href="../index.php" class="text-decoration-none">Hospital Management System</a></h2>
        <div class="user-info">
            <span class="me-3">Welcome, <?php echo $_SESSION['username'] ?? 'User'; ?></span>
            <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
    
    <div class="sidebar">
        <h2>Main Menu</h2>
        <nav class="mt-4">
            <a href="../pages/patients.php" class="d-flex align-items-center <?php echo ($current_page === 'patients') ? 'active' : ''; ?>">
                <i class="fas fa-users mx-2"></i>
                Patients
            </a>
            <a href="../pages/doctors.php" class="d-flex align-items-center <?php echo ($current_page === 'doctors') ? 'active' : ''; ?>">
                <i class="fas fa-user-md mx-2"></i>
                Doctors
            </a>
            <a href="../pages/appointments.php" class="d-flex align-items-center <?php echo ($current_page === 'appointments') ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt mx-2"></i>
                Appointments
            </a>
            <a href="../pages/bills.php" class="d-flex align-items-center <?php echo ($current_page === 'bills') ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice-dollar mx-2"></i>
                Bills
            </a>
            <a href="../pages/drug_recommendations.php" class="d-flex align-items-center <?php echo ($current_page === 'drugs') ? 'active' : ''; ?>">
                <i class="fas fa-pills mx-2"></i>
                Drug Recommendations
            </a>
        </nav>
    </div>
