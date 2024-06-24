document.addEventListener('DOMContentLoaded', function(){
    var categorySelect = document.getElementById('categorySelect');
    
    function loadShows(category) {
        var request = new XMLHttpRequest();
        request.open('POST', '../NetflixShows/filterNetflix.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        request.onload = function(){
            if(request.status >= 200 && request.status < 400){
                document.getElementById('showList').innerHTML = request.responseText;
            } else {
                console.error('Server error: ' + request.status);
            }
        };

        request.onerror = function(){
            console.error('Request failed');
        };

        request.send('category=' + encodeURIComponent(category));
    }

    loadShows('none');

    categorySelect.addEventListener('change', function(){
        var selectedCategory = categorySelect.value;
        loadShows(selectedCategory);
    });
});