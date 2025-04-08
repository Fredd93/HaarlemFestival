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
  
        document.getElementById("artist-title").textContent = sections["header1"]?.[0]?.title || "Dance Artist";
  
        document.getElementById("career-highlights").innerHTML = `
          <h2>Career Highlights</h2>
          <p>${sections["header1"]?.[0]?.description || ""}</p>
        `;
  
        document.getElementById("tracks").innerHTML = `
          <h2>Tracks</h2>
          <p>${sections["header2"]?.[0]?.description || ""}</p>
        `;
  
        document.getElementById("albums").innerHTML = `
          <h2>Albums</h2>
          <p>${sections["header3"]?.[0]?.description || ""}</p>
        `;
  
        document.getElementById("legacy").innerHTML = `
          <h2>Legacy and Influence</h2>
          <p>${sections["header4"]?.[0]?.description || ""}</p>
        `;
  
        const slideshow = document.getElementById("slideshow");
        (sections["slideshow-image"] || []).forEach(img => {
          const image = document.createElement("img");
          image.src = `assets/images/${img.image_url}`;
          image.alt = "Slideshow Image";
          slideshow.appendChild(image);
        });
  
        const videos = document.getElementById("videos");
        (sections["video"] || []).forEach(video => {
          const vid = document.createElement("video");
          vid.controls = true;
          vid.src = `assets/videos/${video.image_url}`;
          videos.appendChild(vid);
        });
      })
      .catch(err => {
        console.error("Error loading artist content:", err);
      });
  });
  