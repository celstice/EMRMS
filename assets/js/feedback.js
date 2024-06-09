var links = document.querySelectorAll('.feedbackLink');// feedback button in the user side

// add link to each feedback button 
links.forEach(function(link) {
    link.addEventListener('click', function() {
        var targetPage = this.dataset.targetPage;
        window.location.href = targetPage;
    });
});
