<?php
require_once(__DIR__ . "/header.php"); 


?>

<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>Manage Events</h3>
                    <a href="cms/events" class="btn btn-primary">Go to Events</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>Manage Content</h3>
                    <a href="cms/content" class="btn btn-primary">Go to Content</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>Manage Users</h3>
                    <a href="cms/users" class="btn btn-primary">Go to Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3>Manage Tickets</h3>
                    <a href="cms/tickets" class="btn btn-primary">Go to Tickets</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>
