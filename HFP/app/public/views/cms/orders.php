<?php
require_once(__DIR__ . '/header.php');
?>

<div class="container mt-5">
  <h2 class="mb-4">Order Management</h2>

  <div class="mb-3">
    <button class="btn btn-success" id="export-csv">Export Selected to CSV</button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered" id="orders-table">
      <thead class="table-dark">
        <tr>
          <th><input type="checkbox" id="select-all"></th>
          <th>Order ID</th>
          <th>User ID</th>
          <th>Total Price</th>
          <th>Payment Method</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody id="orders-body">
        <!-- Populated via JS -->
      </tbody>
    </table>
  </div>
</div>

<script src="../../assets/js/orders.js"></script>
