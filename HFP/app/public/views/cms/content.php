<?php require_once(__DIR__ . "/header.php"); ?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Content</h2>

    <!-- Page Selector -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="pageSelector" class="form-label">Select Page or Event</label>
            <select class="form-control" id="pageSelector">
                <option value="homepage">Homepage</option>
                <option value="yummy">Yummy</option>
                <option value="jazz">Jazz</option>
                <option value="dance">Dance</option>
                <option value="history">History</option>
            </select>
        </div>
    </div>

    <!-- Detail Page Table (only for event pages) -->
    <div id="detailPageTableWrapper" class="mb-4" style="display:none;">
        <h5>Choose an Event Detail Page:</h5>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="detailPageTableBody">
                <!-- Injected by JS -->
            </tbody>
        </table>
    </div>

    <!-- Content Blocks Table -->
    <a href="#" id="addContentBtn" class="btn btn-success mb-3">Add New Content</a>

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
            <!-- Injected by JS -->
        </tbody>
    </table>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>
<script src="/assets/js/cmsContent.js"></script>


