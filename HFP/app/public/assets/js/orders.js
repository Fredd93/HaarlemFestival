document.addEventListener("DOMContentLoaded", () => {
    fetchOrders();
  
    document.getElementById("export-csv").addEventListener("click", exportSelectedToCSV);
    document.getElementById("select-all").addEventListener("change", (e) => {
      const checked = e.target.checked;
      document.querySelectorAll(".order-checkbox").forEach(cb => cb.checked = checked);
    });
  });
  
  function fetchOrders() {
    fetch("/api/orders")
      .then(res => res.json())
      .then(data => renderOrders(data))
      .catch(err => console.error("Failed to fetch orders", err));
  }
  
  function renderOrders(orders) {
    const tbody = document.getElementById("orders-body");
    tbody.innerHTML = "";
  
    orders.forEach(order => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td><input type="checkbox" class="order-checkbox" value="${order.order_id}"></td>
        <td>${order.order_id}</td>
        <td>${order.user_id}</td>
        <td>&euro;${parseFloat(order.total_price).toFixed(2)}</td>
        <td>${order.payment_method}</td>
        <td>${order.created_at ?? '-'}</td>
      `;
      tbody.appendChild(row);
    });
  }
  
  function exportSelectedToCSV() {
    const selectedIds = Array.from(document.querySelectorAll(".order-checkbox:checked")).map(cb => cb.value);
  
    if (selectedIds.length === 0) {
      alert("Please select at least one order to export.");
      return;
    }
  
    fetch("/api/orders")
      .then(res => res.json())
      .then(orders => {
        const selectedOrders = orders.filter(o => selectedIds.includes(o.order_id.toString()));
        const csv = convertToCSV(selectedOrders);
        downloadCSV(csv, "orders_export.csv");
      });
  }
  
  function convertToCSV(data) {
    const headers = Object.keys(data[0]);
    const rows = data.map(obj => headers.map(h => `"${obj[h]}"`).join(","));
    return [headers.join(","), ...rows].join("\n");
  }
  
  function downloadCSV(csv, filename) {
    const blob = new Blob([csv], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }
  