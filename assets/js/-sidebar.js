// sidebar active

$(document).ready(function (){
    var page= window.location.href;

        $("#header .top .sidebar a").each(function (){
            if (page.indexOf($(this).attr("href")) !== -1) {
                // Add the 'active-link' class to the matching link
                $(this).addClass(".active");
            }
        })
});