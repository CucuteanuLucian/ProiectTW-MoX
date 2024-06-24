let slideIndex1 = 0;
let slideIndex2 = 0;
let slideIndex3 = 0;

function moveSlider1(direction) {
    const slides = document.querySelector('.ForYouBar');
    const slideWidth = slides.clientWidth;

    // Determine number of items per page based on viewport width
    let itemsPerPage = 9;

    var width = window.innerWidth;
    // Use width to adjust elements on the page
    if (width < 768) {
        itemsPerPage=5;
    } else if (width >= 768 && width < 1024) {
        itemsPerPage=7;
    } else {
        itemsPerPage=9;
    }


    // Calculate total number of pages (slides)
    const totalSlides = Math.ceil(slides.childElementCount / itemsPerPage);

    // Calculate the maximum index
    const maxIndex = totalSlides - 1;

    // Calculate the new slide index
    let newIndex = slideIndex1 + direction;

    // Ensure newIndex stays within bounds
    if (newIndex < 0) {
        newIndex = 0;  // If newIndex is less than 0, set it to 0
    } else if (newIndex > maxIndex) {
        newIndex = maxIndex;  // Limit newIndex to maxIndex to prevent going beyond the last slide
    }

    // Update slideIndex
    slideIndex1 = newIndex;

    // Move the slider
    slides.style.transform = `translateX(-${slideIndex1 * slideWidth}px)`;
}

function moveSlider2(direction) {
    const slides = document.querySelector('.TVShowsBar');
    const slideWidth = slides.clientWidth;

    // Determine number of items per page based on viewport width
    let itemsPerPage = 9;

    var width = window.innerWidth;
    // Use width to adjust elements on the page
    if (width < 768) {
        itemsPerPage=5;
    } else if (width >= 768 && width < 1024) {
        itemsPerPage=7;
    } else {
        itemsPerPage=9;
    }


    // Calculate total number of pages (slides)
    const totalSlides = Math.ceil(slides.childElementCount / itemsPerPage);

    // Calculate the maximum index
    const maxIndex = totalSlides - 1;

    // Calculate the new slide index
    let newIndex = slideIndex2 + direction;

    // Ensure newIndex stays within bounds
    if (newIndex < 0) {
        newIndex = 0;  // If newIndex is less than 0, set it to 0
    } else if (newIndex > maxIndex) {
        newIndex = maxIndex;  // Limit newIndex to maxIndex to prevent going beyond the last slide
    }

    // Update slideIndex
    slideIndex2 = newIndex;

    // Move the slider
    slides.style.transform = `translateX(-${slideIndex2 * slideWidth}px)`;
}

function moveSlider3(direction) {
    const slides = document.querySelector('.MoviesBar');
    const slideWidth = slides.clientWidth;

    // Determine number of items per page based on viewport width
    let itemsPerPage = 9;

    var width = window.innerWidth;
    // Use width to adjust elements on the page
    if (width < 768) {
        itemsPerPage=5;
    } else if (width >= 768 && width < 1024) {
        itemsPerPage=7;
    } else {
        itemsPerPage=9;
    }


    // Calculate total number of pages (slides)
    const totalSlides = Math.ceil(slides.childElementCount / itemsPerPage);

    // Calculate the maximum index
    const maxIndex = totalSlides - 1;

    // Calculate the new slide index
    let newIndex = slideIndex3 + direction;

    // Ensure newIndex stays within bounds
    if (newIndex < 0) {
        newIndex = 0;  // If newIndex is less than 0, set it to 0
    } else if (newIndex > maxIndex) {
        newIndex = maxIndex;  // Limit newIndex to maxIndex to prevent going beyond the last slide
    }

    // Update slideIndex
    slideIndex3 = newIndex;

    // Move the slider
    slides.style.transform = `translateX(-${slideIndex3 * slideWidth}px)`;
}


//window.addEventListener('resize', handleResize);


var button = document.getElementById("dropdownButton");
var dropdown = document.getElementById("dropdownMenu");

// Toggle the dropdown menu when the button is clicked
button.onclick = function() {
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
};

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('#dropdownButton')) {
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    var showNameInput = document.getElementById('show_name');
    var suggestionsBox = document.getElementById('suggestions');

    showNameInput.addEventListener('input', function() {
        var query = showNameInput.value;
        if (query.length > 2) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../HomePage/search.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    suggestionsBox.innerHTML = xhr.responseText;
                    suggestionsBox.style.display = 'block';
                }
            };
            xhr.send('query=' + encodeURIComponent(query));
        } else {
            suggestionsBox.style.display = 'none';
        }
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('suggestion-item')) {
            showNameInput.value = event.target.textContent;
            suggestionsBox.style.display = 'none';
        }
    });
});