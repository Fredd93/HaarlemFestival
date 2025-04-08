document.addEventListener("DOMContentLoaded", () => {
  const userId = 1;
  fetch(`/api/programsById?userId=${userId}`)
    .then(res => res.json())
    .then(programs => {
      const container = document.querySelector(".personal-program");
      if (!programs.length) {
        container.innerHTML += "<p>No items in your program yet.</p>";
        return;
      }

      const ul = document.createElement("ul");
      ul.classList.add("program-list");

      programs.forEach(item => {
        const li = document.createElement("li");
        li.classList.add("program-item");
        li.textContent = `Event ID: ${item.eventId} | Status: ${item.status}`;
        ul.appendChild(li);
      });

      container.appendChild(ul);
    })
    .catch(err => console.error("Program fetch error:", err));
});