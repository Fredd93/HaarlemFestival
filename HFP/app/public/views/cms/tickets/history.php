<?php
require_once(__DIR__ . '/../header.php');
?>

<div class="container mt-5">
  <h2 class="mb-4">History Ticket Management</h2>
  <div class="table-responsive">
    <table class="table table-bordered" id="dance-events-table">
      <thead class="table-dark">
        <tr>
          <th>Language</th>
          <th>Date</th>
          <th>Time</th>
          <th>Max Tickets</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="history-events-body">
        <!-- Populated via JS -->
      </tbody>
    </table>
  </div>
</div>

<script src="../../../assets/js/cmsHistoryTicket.js"></script>
