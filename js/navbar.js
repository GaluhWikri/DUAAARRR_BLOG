
    function toggleSearchBox() {
        const logoTitle = document.getElementById('logo-title');
        
        // Check if the current element is h1 (DUAAARRR text)
        if (logoTitle.tagName === 'H1') {
            // Hide the text and show an input box in its place
            logoTitle.style.display = 'none';
            
            // Create input element
            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.id = 'search-input';
            searchInput.style.border = 'none';  // No border
            searchInput.style.background = 'transparent'; // Transparent background
            searchInput.style.outline = 'none'; // No outline
            searchInput.style.fontSize = '32px'; // Same size as the h1 text
            searchInput.style.fontWeight = 'bold'; // Same weight as the h1 text
            searchInput.style.color = 'currentColor'; // Match the text color
            searchInput.style.textAlign = 'center'; // Center align text
            searchInput.style.fontFamily = 'Arial, sans-serif'; // Set font to Arial
            
            searchInput.onblur = function() {
                // If the input loses focus, revert back to the text
                logoTitle.innerHTML = searchInput.value || 'DUAAARRR';
                logoTitle.style.display = 'block';
                searchInput.style.display = 'none';
            };
            
            // Append the input element where the h1 was
            logoTitle.parentNode.appendChild(searchInput);
            searchInput.focus(); // Focus on the input field
        }
    }
