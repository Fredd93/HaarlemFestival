document.addEventListener('DOMContentLoaded', function () {
    // Get all tab links and content sections
    const tabs = document.querySelectorAll('ul li a');
    const contents = document.querySelectorAll('.tab-content');

    // Function to hide all tab content and remove the active class from all tabs
    function hideAllTabs() {
        contents.forEach(function(content) {
            content.style.display = 'none';
        });
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });
    }

    // Add click event listener to each tab link
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            hideAllTabs();
            // Extract the target content ID (removing the '#' from href)
            const targetId = tab.getAttribute('href').substring(1);
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.style.display = 'block';
            }
            tab.classList.add('active');
        });
    });

    // Initially, hide all tabs then show the first one
    if (tabs.length > 0 && contents.length > 0) {
        hideAllTabs();
        tabs[0].classList.add('active');
        contents[0].style.display = 'block';
    }
});
