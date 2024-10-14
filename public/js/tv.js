(function tvCallback() {


    const targetSelector = ".doneButton-F15FKlrH";
    alert("testjs");
// Function to check if the element has disappeared
    function checkElementDisappearance() {
        const element = document.querySelector(targetSelector);
        if (!element) {
            alert("Element has disappeared!");
            // You can also trigger other actions here if needed
        }
    }

// Set up the mutation observer to monitor the DOM
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            // Check for element disappearance on every mutation
            checkElementDisappearance();
        });
    });

// Configuration of the observer
    const config = {
        childList: true,    // Monitor direct children
        subtree: true       // Monitor entire subtree of the target
    };

// Start observing the body (or another root node)
    observer.observe(document.body, config);

// Optional: Check initially in case the element isn't present when the page loads
    checkElementDisappearance();


})();
