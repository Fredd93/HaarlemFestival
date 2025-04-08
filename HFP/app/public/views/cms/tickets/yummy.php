<?php
require_once(__DIR__ . '/../header.php');
?>


<div class="container my-5">
    <h1 class="mb-4 text-center">Manage Yummy Session Seats</h1>

    <!-- Restaurant Selector -->
    <div class="mb-4">
        <label for="restaurantDropdown" class="form-label">Select Restaurant:</label>
        <select id="restaurantDropdown" class="form-select">
            <option value="">-- Select a restaurant --</option>
        </select>
    </div>

    <!-- Sessions Table -->
    <div class="table-responsive">
        <table id="sessionTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Max Seats</th>
                    <th>Available Seats</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filled by JS -->
            </tbody>
        </table>
    </div>

    <!-- Message Display -->
    <div id="cms-message" class="mt-3"></div>
</div>



<script src="../../../assets/js/cmsyummyTicket.js"></script>
