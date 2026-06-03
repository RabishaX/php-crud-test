// add or update product image preview functionality
document.getElementById('addprod-img-input').addEventListener('change', function(e) {
    const file = e.target.files[0]; // Get the selected file
    if (!file) return; // If no file is selected, exit the function
    const reader = new FileReader(); // Create a FileReader to read the file
    reader.onload = function(ev) {
        const preview = document.getElementById('addprod-img-preview'); // Get the image preview element
        preview.src = ev.target.result; // Set the preview image source to the loaded file data
        preview.style.display = 'block'; // Show the preview image
        document.getElementById('addprod-upload-box').style.display =
            'none'; // Hide the upload box when an image is selected
    };
    reader.readAsDataURL(file); // Read the file as a data URL to trigger the onload event
});

// Automatically submit the import form when a file is selected 
document.querySelector('input[name="file"]').addEventListener('change', function() {
    document.getElementById('importSubmit').click();
});