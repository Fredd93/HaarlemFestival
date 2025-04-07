<?php
require_once(__DIR__ . '/../header.php');
?>

<div class="container mt-5">
  <h2 class="mb-4">Jazz Ticket Management</h2>
  <div class="table-responsive">
    <table class="table table-bordered" id="jazz-events-table">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Venue</th>
          <th>Price</th>
          <th>Duration</th>
          <th>Date</th>
          <th>Seats</th>
          <th>Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="jazz-events-body">
        <!-- Rows will be populated via JS -->
      </tbody>
    </table>
  </div>
</div>

<script src="../../../assets/js/jazzTicket.js"></script>
