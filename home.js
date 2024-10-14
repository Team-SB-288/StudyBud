// Disable zooming using keyboard shortcuts (Ctrl + +, Ctrl + -, Ctrl + MouseWheel)
document.addEventListener('keydown', function(event) {
    if ((event.ctrlKey || event.metaKey) && (event.key === '+' || event.key === '-' || event.key === '=')) {
        event.preventDefault();
    }
});

// Disable zooming using mouse wheel with Ctrl key
document.addEventListener('wheel', function(event) {
    if (event.ctrlKey) {
        event.preventDefault();
    }
}, { passive: false });
