/*Mousetrap Init*/

$(document).ready(function() {

    Mousetrap.bind({  
        'ctrl+alt+n': newEmail,
        'ctrl+alt+r': replyEmail,
        'ctrl+alt+a': replyAllEmail,
        'ctrl+alt+f': forwardEmail,
        'ctrl+alt+enter': emailEnter,
        // ['command+f', 'ctrl+f'], search
        //   '?': function modal() { $('#help').modal('show'); },
    });

    /* Mousetrap.bind('enter', function() {
        console.log('konami code');
    }); */

    function newEmail() {

        var newEmailBtn = $('.email-compose-btn').attr('class');

        if (newEmailBtn != undefined && newEmailBtn != '') {

            $('.email-compose-btn').trigger('click');

        }

    }

    function replyEmail() {

        var replyEmailBtn = $('.email-reply-btn').attr('class');

        if (replyEmailBtn != undefined && replyEmailBtn != '') {

            $('.email-reply-btn').trigger('click');

        }

    }

    function replyAllEmail() {

        var replyAllEmailBtn = $('.email-reply-btn').attr('class');

        if (replyAllEmailBtn != undefined && replyAllEmailBtn != '') {

            $('.email-reply-all-btn').trigger('click');

        }

    }

    function forwardEmail() {

        var forwardEmailBtn = $('.email-compose-btn').attr('class');

        if (forwardEmailBtn != undefined && forwardEmailBtn != '') {

            $('.email-forward-btn').trigger('click');

        }

    }

    function emailEnter() {

        var emailEnterBtnElement = $('.email-enter-btn');

        var emailEnterBtn = '';

        if (emailEnterBtnElement != undefined && emailEnterBtnElement != '') {

            if (emailEnterBtnElement.length == 1) {

                emailEnterBtn = $('.email-enter-btn').attr('data-email-enter');

            }

            if (emailEnterBtnElement.length > 1) {

                emailEnterBtn = $('.modal.in, .modal.show').find('.email-enter-btn').attr('data-email-enter');

            }

            if (emailEnterBtn != undefined && emailEnterBtn != '') {

                $('.' + emailEnterBtn).trigger('click');

            }

        }

    }

});