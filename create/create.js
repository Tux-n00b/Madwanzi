document.addEventListener('DOMContentLoaded', function() {
    // ... existing editor setup code ...

    // Update the publish button event handler
    publishBtn.addEventListener('click', async function(e) {
        e.preventDefault();
        
        if (!validatePost()) {
            return;
        }

        // Update hidden fields before submission
        document.getElementById('post-content').value = editor.innerHTML;
        document.getElementById('is-published').value = '1';
        
        // Show loading state
        publishBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publishing...';
        publishBtn.disabled = true;

        // Submit the form
        document.getElementById('post-form').submit();
    });

    // Save draft button
    saveDraftBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (!validatePost()) {
            return;
        }

        // Update hidden fields before submission
        document.getElementById('post-content').value = editor.innerHTML;
        document.getElementById('is-published').value = '0';
        
        // Show loading state
        saveDraftBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        saveDraftBtn.disabled = true;

        // Submit the form
        document.getElementById('post-form').submit();
    });

    // ... rest of your existing JavaScript ...
});