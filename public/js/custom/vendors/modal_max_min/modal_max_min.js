$(document).ready(function(e) {

    minimizedModalDockReset();

    var $content, $modal, $apnData, $modalCon, $editorContent, $id;

    $content = $(".min");

    $(".modal-minimize").on("click", function(e) {

        var modalType = $(this).attr('data-modal-type');

        if (modalType != undefined && modalType != '') {

            // $apnData = $(this).closest('.' + modalType);

            $modal = "." + modalType;

            $(".modal-backdrop").addClass("display-none");

            $('.minimized-modal-dock-btn').attr('data-modal-type', modalType);

            // $('.minimized-modal-dock-close').addClass($modal + '-close');

            var modalTitle = $($modal + ' .modal-title').text();
            var emailModalType = $($modal + ' .modal-title').attr('data-email-modal-type');

            if (modalTitle != undefined && modalTitle != '') {

                $('.minimized-modal-dock-title').html(modalTitle);

                if (emailModalType != undefined && emailModalType != '') {

                    $('.minimized-modal-dock-title').attr('data-email-modal-type', emailModalType);

                }

            }

            $($modal).modal('hide');

            /* if (modalType == 'email-compose-modal') {

                $('.email-compose-btn').addClass('disabled-block');

            } */

            $('.minimized-modal-dock').show();

            /* $($modal).toggleClass("min");

            if ($($modal).hasClass("min")) {

                $id = tinyMCE.activeEditor.id;

                if ($id != undefined && $id != '' && $id != null && tinymce.get($id) != undefined && tinymce.get($id) != '' && tinymce.get($id) != null) {

                    $editorContent = tinymce.get($id).getContent({ format: 'html' });

                }

                $(".minmaxCon").append($apnData);

                $(this).find("i").toggleClass('fa-minus').toggleClass('fa-clone');

            } else {

                if ($id != undefined && $id != '' && $id != null && tinymce.get($id) != undefined && tinymce.get($id) != '' && tinymce.get($id) != null) {

                    //tinymce.get($id).remove();

                    emailEditorInitialize('#' + $id);

                    tinymce.get($id).setContent($editorContent);

                }

                $(".container").append($apnData);

                $(this).find("i").toggleClass('fa-clone').toggleClass('fa-minus');

            }; */

        }

    });

    $('.minimized-modal-dock-max').on('click', function(e) {

        var modalType = $(this).attr('data-modal-type');

        if (modalType != undefined && modalType != '') {

            $modal = "." + modalType;

            $('.minimized-modal-dock').hide();

            $('.modal-backdrop').addClass('display-none');

            $($modal).modal('show');

        }

    });

    $('.minimized-modal-dock-close').on('click', function(e) {

        var modalType = $(this).attr('data-modal-type');

        if (modalType != undefined && modalType != '') {

            $modal = "." + modalType;

            $('.minimized-modal-dock').hide();

            $($modal + '-close').trigger('click');

            // $($modal).modal('hide');

        }

    });

    /* $('.modal-close').click(function(e) {

        var modalType = $(this).attr('data-modal-type');

        if (modalType != undefined && modalType != '') {

            $(this).closest('.' + modalType).removeClass("min");

            $(".container").removeClass($apnData);

            $(this).next('.modal-minimize').find("i").removeClass('fa fa-clone').addClass('fa fa-minus');

            $(this).closest('.' + modalType).modal('hide');

        }

    }); */

});

function minimizedModalDockReset() {

    $('.minimized-modal-dock-title').html('');

    $('.minimized-modal-dock-title').attr('data-email-modal-type', '');

    $('.minimized-modal-dock-btn').attr('data-modal-type', '');

}

function minimizedModalDockMax(type) {

    var returnData = 'no';

    // var modalType = $('.minimized-modal-dock-max').attr('data-modal-type');
    // var modalType = $('.minimized-modal-dock-title').html();

    var modalType = $('.minimized-modal-dock-title').attr('data-email-modal-type');

    if (modalType != undefined && modalType != '') {

        if (modalType.toLowerCase() == type.toLowerCase()) {

            $('.minimized-modal-dock-max').trigger('click');

            returnData = 'yes';

        } else {

            returnData = 'confirm';

        }

    }

    return returnData;

}

function minimizedModalDockClose(type) {

    var modalType = $('.minimized-modal-dock-close').attr('data-modal-type');

    if (modalType != undefined && modalType != '') {

        if (modalType == type) {

            minimizedModalDockReset();

            $('.minimized-modal-dock').hide();

        }

    }

}
