let slideIndex1 = 0;
let slideIndex2 = 0;
let slideIndex3 = 0;

function moveSlider1(direction) {
    const slides = document.querySelector('.ForYouBar');
    const slideWidth = slides.clientWidth;
    let itemsPerPage = 9;

    var width = window.innerWidth;
    if (width < 768) {
        itemsPerPage=5;
    } else if (width >= 768 && width < 1024) {
        itemsPerPage=7;
    } else {
        itemsPerPage=9;
    }


    const totalSlides = Math.ceil(slides.childElementCount / itemsPerPage);
    const maxIndex = totalSlides - 1;

    let newIndex = slideIndex1 + direction;

    if (newIndex < 0) {
        newIndex = 0;
    } else if (newIndex > maxIndex) {
        newIndex = maxIndex;
    }

    slideIndex1 = newIndex;

    slides.style.transform = `translateX(-${slideIndex1 * slideWidth}px)`;
}

function moveSlider2(direction) {
    const slides = document.querySelector('.TVShowsBar');
    const slideWidth = slides.clientWidth;

    let itemsPerPage = 9;

    var width = window.innerWidth;
    if (width < 768) {
        itemsPerPage=5;
    } else if (width >= 768 && width < 1024) {
        itemsPerPage=7;
    } else {
        itemsPerPage=9;
    }


    const totalSlides = Math.ceil(slides.childElementCount / itemsPerPage);
    const maxIndex = totalSlides - 1;

    let newIndex = slideIndex2 + direction;

    if (newIndex < 0) {
        newIndex = 0;  
    } else if (newIndex > maxIndex) {
        newIndex = maxIndex;
    }

    slideIndex2 = newIndex;

    slides.style.transform = `translateX(-${slideIndex2 * slideWidth}px)`;
}

function moveSlider3(direction) {
    const slides = document.querySelector('.MoviesBar');
    const slideWidth = slides.clientWidth;

    let itemsPerPage = 9;

    var width = window.innerWidth;
    if (width < 768) {
        itemsPerPage=5;
    } else if (width >= 768 && width < 1024) {
        itemsPerPage=7;
    } else {
        itemsPerPage=9;
    }

    const totalSlides = Math.ceil(slides.childElementCount / itemsPerPage);

    const maxIndex = totalSlides - 1;

    let newIndex = slideIndex3 + direction;

    if (newIndex < 0) {
        newIndex = 0;
    } else if (newIndex > maxIndex) {
        newIndex = maxIndex;
    }

    slideIndex3 = newIndex;

    slides.style.transform = `translateX(-${slideIndex3 * slideWidth}px)`;
}

var button = document.getElementById("dropdownButton");
var dropdown = document.getElementById("dropdownMenu");

button.onclick = function() {
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
};

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