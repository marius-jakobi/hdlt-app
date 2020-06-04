const url = document.location.toString();

// Redirect to tab if URL contains one
// e.g. "/profile/#change-password"
if (url.match("#")) {
    // Find element
    const element = $('.nav-tabs a[href="#' + url.split("#")[1] + '"]');

    // Warn on console if element not found
    if (element.length == 0) {
        console.warn("pre-selected tab not found");
    }

    // Open tab
    element.tab("show");
}

// change location when tab changes
$(".nav-tabs a").on("shown.bs.tab", function(e) {
    window.location.hash = e.target.hash;
});
