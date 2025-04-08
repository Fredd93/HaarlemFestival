document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get("page") || "danceAfrojack";
  const apiUrl = `/api/dancecontent/page?page=${encodeURIComponent(page)}`;

  fetch(apiUrl)
    .then(res => res.json())
    .then(data => {
      const sections = {};
      data.forEach(item => {
        if (!sections[item.content_type]) sections[item.content_type] = [];
        sections[item.content_type].push(item);
      });

      // Set artist title
      document.getElementById("artist-title").textContent = sections["header1"]?.[0]?.title || "Dance Artist";

      // Career Highlights
      document.getElementById("career-highlights").innerHTML = `
        <h2>Career Highlights</h2>
        <p>${sections["header1"]?.[0]?.description || ""}</p>
      `;

      // Tracks
      document.getElementById("tracks").innerHTML = `
        <h2>Tracks</h2>
        <p>${sections["header2"]?.[0]?.description || ""}</p>
      `;

      // Albums
      document.getElementById("albums").innerHTML = `
        <h2>Albums</h2>
        <p>${sections["header3"]?.[0]?.description || ""}</p>
      `;

      // Legacy
      document.getElementById("legacy").innerHTML = `
        <h2>Legacy and Influence</h2>
        <p>${sections["header4"]?.[0]?.description || ""}</p>
      `;

      // Videos
      const videos = sections["video"] || [];
      const video1Container = document.getElementById("video1");
      const video2Container = document.getElementById("video2");

      if (videos[0] && video1Container) {
        const video1 = document.createElement("video");
        video1.controls = true;
        video1.src = `assets/videos/${videos[0].image_url}`;
        video1Container.appendChild(video1);
      }

      if (videos[1] && video2Container) {
        const video2 = document.createElement("video");
        video2.controls = true;
        video2.src = `assets/videos/${videos[1].image_url}`;
        video2Container.appendChild(video2);
      }

      // Slideshow
      const slideshowImages = (sections["slideshow-image"] || []).map(img => `assets/images/${img.image_url}`);
      let currentSlide = 0;

      if (slideshowImages.length > 0) {
        const slideImage = document.getElementById("slide-image");
        const dotContainer = document.getElementById("slide-dots");

        function showSlide(index) {
          currentSlide = index;
          slideImage.src = slideshowImages[currentSlide];
          Array.from(dotContainer.children).forEach((dot, i) => {
            dot.classList.toggle("active", i === index);
          });
        }

        // Generate dots
        slideshowImages.forEach((_, index) => {
          const dot = document.createElement("span");
          dot.className = "dot" + (index === 0 ? " active" : "");
          dot.onclick = () => showSlide(index);
          dotContainer.appendChild(dot);
        });

        // Initial image
        slideImage.src = slideshowImages[0];
      }

    })
    .catch(err => {
      console.error("Error loading artist content:", err);
    });
});
