$(document).ready(function () {
    loadNotifs();
    userNotifs();
    setInterval(function () {
        userNotifs();
        loadNotifs();
        // updateNotifications(data);
    }, 5000);
// });
function loadNotifs() {
    $.ajax({
        url: '../config/user-notif-fetch.php',
        method: 'GET',
        // data:data,
        dataType: 'json',
        success: function (data) {
            // var data = response;
            console.log('Received data:', data);
            
            updateNotifications(data);
            // setInterval(function () {
            //     updateNotifications(data);
            // }, 5000);
            // countNotifs();
            
        },
        error: function (xhr, status, error) {
            console.log('Error fetching notifications:', error);
            console.log('XHR:', xhr);
            console.log('Status:', status);
            console.log('Error:', error);
        }
    });
}

// $(document).ready(function () {
    function userNotifs() {
        var notifCounter = $('#notif-counter');
        $.ajax({
            url: '../config/user-notif-count.php',
            method: 'GET',
            dataType: 'json',
            success: function (count) {
                console.log('Received notif count:', count);
                // updateNotifications(data);
                notifCounter.empty();
                if (count != 0){
                // var counts = `${count}`;
                var counts = `<span id="notif-count" class="rounded-circle">${count}</span> `;
                notifCounter.append(counts);
                } else if (count===0){
                    var count0 = `<span></span> `;
                    notifCounter.append(count0);
                    console.log(count);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error fetching notifications:', error);
                console.log('XHR:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
            }
        });
        // userNotifs();
        // setInterval(function () {
        //     userNotifs();
        // }, 5000);
    }
    // countNotifs();
// });
    

function updateNotifications(data) {
    var notificationsContainer = $('#notifications');
    notificationsContainer.empty();
    if (data.length > 0) {
        $.each(data, function (index, notification) {
            if (notification.type == "Job Request") {
                notification.link = '../user/user-jobrequest.php?id=' + notification.typeID;
            } else if (notification.type == "Maintenance"){
                notification.link = '../user/equipment-record.php?id='+ notification.typeID;
            } else if (notification.type == "User Job Request") {
                notification.link = '../admin/admin-jobrequest.php?id=' + notification.typeID;
            } else if (notification.type == "User Feedback") {
                notification.link = '../admin/admin-feedback-result.php?id=' + notification.typeID;
            } else if (notification.type == "Reschedule" || notification.type == "User Schedule Request" || notification.type=="Cancelled Schedule") {
                notification.link = '../admin/admin-notice.php?id=' + notification.typeID;
            } else if (notification.type == "Schedule Request" || notification.type == "Preventive Maintenance Schedule" || notification.type=="Declined Schedule") {
                notification.link = '../user/user-notice.php?id=' + notification.typeID;
            }
            viewed(notification.notifID);

            // var viewed = notification.viewed == 0;
            notification.viewed = parseInt(notification.viewed, 10);
            console.log("notification.viewed:",notification.viewed);
            var notificationHTML = `
                    <a href="${notification.link}" id="${notification.notifID}" class="rounded-0 shadow-sms text-decoration-none p-2 mb-1 border border-end-0 border-start-0 notification d-flex justify-content-between notifID ${notification.viewed === 0 ? "bg-success bg-opacity-10 text-dark" : 'bg-transparent text-muted'}">
                        <span class="d-flex align-items-center">${notification.type}</span>
                        <span id="notif-message" class="m-0 d-flex flex-column text-end">${notification.message}<br>
                            <p class="text-end text-muted pt-2" id="notif-date">${notification.date} | ${notification.time}</p>
                        </span>
                    </a>
                `;
            notificationsContainer.append(notificationHTML);
        });
    
    } else {
        notificationsContainer.html('<p>No notifications found.</p>');
    }
}

    function highlightRow(rowId) {
        $('#jobrequest-tr' + rowId).addClass('bg-danger');
        setTimeout(function () {
            $('#jobrequest-tr' + rowId).removeClass('bg-danger');
        }, 10000);
    }

 
    $('#read-all').click(function () {
        $.ajax({
            type: 'POST',
            url: '../config/view-all.php',
            data: { 'read-all': true },
            success: function (response) {
                console.log(response);
                window.location.reload();
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    function viewed(notifViewed) {
        // e.preventDefault();
    $('.notifID').on('click', function () {
        var notifViewed = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: "../config/viewed.php",
            data: {
                notifViewed: notifViewed
            },
            success: function (response) {
                console.log(response);
                // $(this).removeClass('text-dark bg-success bg-opacity-10').addClass('bg-transparent text-muted');
                console.log(notifViewed);
                console.log('Notification marked as viewed');
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
}

});