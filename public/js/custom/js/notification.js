// $(function() {

if ($('#notificationRead').attr('data-notification-read-url') != undefined && $('#notificationRead').attr('data-notification-read-url') != '') {

    var read_url = $('#notificationRead').attr('data-notification-read-url');

    notificationRead(read_url);

}

$('.dropdown-menu').click(function(e) {

    // e.stopPropagation();

});

function notificationCount() {

    var count_url = $('.notification-count-button').attr('data-notification-count-url');

    $.ajax({

        url: count_url,
        dataType: "json"

    }).done(function(response) {

        if (response.success == "true") {

            if (response.data != undefined && response.data != '' && parseInt(response.data) > 0) {

                // $(this).removeClass('notification-unread-color');

                $('.notification-count').html(response.data);
                $('.notification-count').addClass('top-nav-icon-badge');
                $('.notification-count-button').attr('data-notification-count', response.data);

                var notificationButton = $('.notification-count-button');

                if (notificationButton != undefined && notificationButton.length > 0) {

                    var notificationBlockIsOpen = false;

                    notificationBlockIsOpen = $('.notification-block').hasClass('open');

                    if (!notificationBlockIsOpen) {

                        $('.notification-count-button').trigger('click');

                    } else {

                        notificationItems();

                    }

                }

            } else {

                $('.notification-count-button').removeAttr('data-toggle');

            }

        }

    });

}

notificationCount();

setInterval(function() { notificationCount() }, 3000);

function notificationRead(read_url) {

    if (read_url != undefined && read_url != '') {

        /* AJAX call to get list */
        $.ajax({

            url: read_url,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                $('.notification-item').removeClass('notification-unread-color');

                if (response.data != undefined && response.data != '') {

                    if (response.data.count != undefined && response.data.count != '' && parseInt(response.data.count) > 0) {

                        $('.notification-count').html(response.data.count);
                        $('.notification-count').addClass('top-nav-icon-badge');
                        $('.notification-count-button').attr('data-notification-count', response.data.count);

                        if (response.data.items != undefined && response.data.items != '') {

                            $('.notification-list-block').html(response.data.items);

                        }

                    } else {

                        $('.notification-count').html('');
                        $('.notification-count').removeClass('top-nav-icon-badge');
                        $('.notification-count-button').attr('data-notification-count', '0');
                        $('.notification-list-block').html('no data');
                        $('.notification-count-button').removeAttr('data-toggle');
                        $('.dropdown-menu').hide();

                    }

                }

            }

        });

    }

}

$(document).on('click', '.notification-item', function(e) {

    e.stopPropagation();

    var item = $(this);

    var read_url = item.attr('data-notification-read-link');

    notificationRead(read_url);

    // if (read_url != undefined && read_url != '') {

    //     /* AJAX call to get list */
    //     $.ajax({

    //         url: read_url,
    //         dataType: "json"

    //     }).done(function(response) {

    //         if (response.success == "true") {

    //             item.removeClass('notification-unread-color');

    //             if (response.data != undefined && response.data != '') {

    //                 if (response.data.count != undefined && response.data.count != '' && parseInt(response.data.count) > 0) {

    //                     $('.notification-count').html(response.data.count);
    //                     $('.notification-count').addClass('top-nav-icon-badge');
    //                     $('.notification-count-button').attr('data-notification-count', response.data.count);

    //                     if (response.data.items != undefined && response.data.items != '') {

    //                         $('.notification-list-block').html(response.data.items);

    //                     }

    //                 } else {

    //                     $('.notification-count').html('');
    //                     $('.notification-count').removeClass('top-nav-icon-badge');
    //                     $('.notification-count-button').attr('data-notification-count', '0');
    //                     $('.notification-list-block').html('no data');
    //                     $('.notification-count-button').removeAttr('data-toggle');
    //                     $('.dropdown-menu').hide();

    //                 }

    //             }

    //         }

    //     });

    // }

});

$(document).on('click', '.notification-read-all', function(e) {

    e.stopPropagation();

    var read_all_url = $(this).attr('data-notification-read-all-url');

    if (read_all_url != undefined && read_all_url != '') {

        /* AJAX call to get list */
        $.ajax({

            url: read_all_url,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != undefined && response.data != '') {

                    if (response.data.count != undefined && response.data.count != '' && parseInt(response.data.count) > 0) {

                        $('.notification-count').html(response.data.count);
                        $('.notification-count').addClass('top-nav-icon-badge');
                        $('.notification-count-button').attr('data-notification-count', response.data.count);

                        if (response.data.items != undefined && response.data.items != '') {

                            $('.notification-list-block').html(response.data.items);

                        }

                    } else {

                        $('.notification-count').html('');
                        $('.notification-count').removeClass('top-nav-icon-badge');
                        $('.notification-count-button').attr('data-notification-count', '0');
                        $('.notification-list-block').html('no data');
                        $('.notification-count-button').removeAttr('data-toggle');
                        $('.dropdown-menu').hide();

                    }

                }

            }

        });

    }

});

$(document).on('click', '.notification-count-button', function(e) {

    // e.stopPropagation();

    var notificationCount = $('.notification-count-button').attr('data-notification-count');

    if (notificationCount != undefined && notificationCount != '' && parseInt(notificationCount) > 0) {

        var list_url = $('.notification-count-button').attr('data-notification-list-url');

        if (list_url != undefined && list_url != '') {

            /* AJAX call to get list */
            $.ajax({

                url: list_url,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    if (response.data.length > 0) {

                        $('.notification-list-block').html(response.data);

                    }

                }

            });

        }

    }

});

function notificationItems() {

    // e.stopPropagation();

    var notificationCount = $('.notification-count-button').attr('data-notification-count');

    if (notificationCount != undefined && notificationCount != '' && parseInt(notificationCount) > 0) {

        var list_url = $('.notification-count-button').attr('data-notification-list-url');

        if (list_url != undefined && list_url != '') {

            /* AJAX call to get list */
            $.ajax({

                url: list_url,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    if (response.data.length > 0) {

                        $('.notification-list-block').html(response.data);

                    }

                }

            });

        }

    }

}

// });

// if (!!window.performance && window.performance.navigation.type === 2) {
//     // value 2 means "The page was accessed by navigating into the history"
//     console.log('Reloading');
//     window.location.reload(); // reload whole page

// }

// window.onpageshow = function (event) {
//     if (event.persisted) {
//         window.location.reload();
//     }
// };

// $(document).ready(function () {
//     window.history.pushState(null, "", window.location.href);
//     window.onpopstate = function () {
//         window.history.pushState(null, "", window.location.href);
//     };
// });
