// Map hash to HTML file
let routes;
let defaultContent;
function setContent(contentRoutes, defaultContentPage) {
    routes = contentRoutes;
    defaultContent = defaultContentPage;

    // Visualization
    // routes = {
    //     home: "landing/home.php",
    //     about: "landing/about.php",
    // }

    // Usage
    // setContent({
    //     contacts: "contacts.html",
    //     main: "index.php"
    // }, 'main')
}

// Load page content based on current hash
function loadPageFromHash() {
    const hash = window.location.hash.substring(1) || defaultContent; // default to home
    const page = routes[hash];

    if (page) {
        fetch(page)
            .then(res => res.text())
            .then(html => {
                document.getElementById("content").innerHTML = html;
            })
            .catch(() => {
                document.getElementById("content").innerHTML = "<p>Page not found.</p>";
            });
    } else {
        document.getElementById("content").innerHTML = "<p>Page not found.</p>";
    }
}

// Load page on initial load and when hash changes
window.addEventListener("DOMContentLoaded", loadPageFromHash);
window.addEventListener("hashchange", loadPageFromHash);