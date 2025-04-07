<?php
require_once(__DIR__ . '/../header.php');
?>

<div class="container mt-5">
  <h2 class="mb-4">Dance Ticket Management</h2>
  <div class="table-responsive">
    <table class="table table-bordered" id="dance-events-table">
      <thead class="table-dark">
        <tr>
          <th>Artist</th>
          <th>Venue</th>
          <th>Session Type</th>
          <th>Time</th>
          <th>Duration</th>
          <th>Price</th>
          <th>Date</th>
          <th>Tickets Available</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="dance-events-body">
        <!-- Populated via JS -->
      </tbody>
    </table>
  </div>
</div>

<script src="../../../assets/js/danceTicket.js"></script>
