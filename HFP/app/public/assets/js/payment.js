const buttons = document.querySelectorAll('.payment-method');
buttons.forEach(btn => {
  btn.addEventListener('click', () => {
    buttons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const userId = 1; // Static for now
  fetch(`/api/programsById?userId=${userId}`)
    .then((res) => {
      if (!res.ok) throw new Error("Failed to fetch program items.");
      return res.json();
    })
    .then((programs) => {
      const programContainer = document.querySelector(".personal-program");
      if (!programs.length) {
        programContainer.innerHTML += "<p>No items in your program yet.</p>";
        return;
      }

      const ul = document.createElement("ul");
      ul.classList.add("program-list");

      programs.forEach((item) => {
        const li = document.createElement("li");
        li.classList.add("program-item");
        li.textContent = `Event ID: ${item.event_id} | Status: ${item.status}`;
        ul.appendChild(li);
      });

      programContainer.appendChild(ul);
    })
    .catch((err) => {
      console.error(err);
    });
});

document.addEventListener("DOMContentLoaded", () => {
  const countrySelect = document.querySelector("select");

  const countries = window.countryList().getNames();

  countries.forEach(country => {
    const option = document.createElement("option");
    option.value = country;
    option.textContent = country;
    countrySelect.appendChild(option);
  });

  countrySelect.value = "Netherlands";
});
