<?php
require_once(__DIR__ . "/header.php");
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Content</h2>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="pageSelector" class="form-label">Page:</label>
            <select class="form-control" id="pageSelector">
                <option value="homepage">Homepage</option>
                <option value="yummy">Yummy</option>
                <option value="dance">Dance</option>
                <option value="history">History</option>
                <option value="jazz">Jazz</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="contentTypeSelector" class="form-label">Content Type:</label>
            <!-- Dynamically loaded by JavaScript -->
            <select class="form-control" id="contentTypeSelector"></select>
        </div>
    </div>

    <a href="/cms/content/add" class="btn btn-success mb-3">Add New Content</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Tag</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="contentTable">
            <!-- Content dynamically loaded here -->
        </tbody>
    </table>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>

<script src="./../../assets/js/cmsContent.js"></script>
