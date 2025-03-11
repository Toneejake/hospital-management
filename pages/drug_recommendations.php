<?php
session_start();
include '../includes/db.php';

// Page specific variables
$page_title = 'Drug Recommendations';
$current_page = 'drugs';

// Function to call OpenFDA API
function getDrugRecommendations($condition) {
    $api_url = "https://api.fda.gov/drug/label.json?search=indications_and_usage:\"$condition\"&limit=5";
    $response = file_get_contents($api_url);
    return json_decode($response, true);
}

// Handle Form Submission
$drugs = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $condition = $_POST['condition'] ?? '';
    if (!empty($condition)) {
        $drugs = getDrugRecommendations($condition);
    }
}

// Include header
include '../includes/header.php';
?>

<div class="content">
    <div class="content-header">
        <h1 class="mb-4"><?php echo $page_title; ?></h1>
    </div>

    <!-- Drug Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Search Medications</h5>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="condition" class="form-control" 
                               placeholder="Enter a condition (e.g., headache)" 
                               value="<?php echo $_POST['condition'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Search Medications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($drugs)): ?>
    <!-- Drug Recommendations List -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Recommended Medications</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Active Ingredient</th>
                            <th>Indications and Usage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drugs['results'] as $drug): ?>
                        <tr>
                            <td><?php echo $drug['openfda']['brand_name'][0] ?? 'N/A'; ?></td>
                            <td><?php echo $drug['openfda']['generic_name'][0] ?? 'N/A'; ?></td>
                            <td><?php echo $drug['indications_and_usage'][0] ?? 'N/A'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        No medications found for the given condition.
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>