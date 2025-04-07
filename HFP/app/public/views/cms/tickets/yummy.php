<?php
require_once(__DIR__ . '/../header.php');
?>

<div class="container mt-5">
  <h2 class="mb-4">Yummy Ticket Management</h2>
  <div class="table-responsive">
    <table class="table table-bordered" id="yummy-events-table">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Type</th>
          <th>Price</th>
          <th>Child Price</th>
          <th>Seats</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="yummy-events-body">
        <!-- Rows injected via JavaScript -->
      </tbody>
    </table>
  </div>
</div>

<script src="../../../assets/js/yummyTicket.js"></script>
