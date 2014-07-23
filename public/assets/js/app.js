scrollToTop = function() {
    verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $('body');
    offset = element.offset();
    offsetTop = offset.top;
    $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}

addCheckboxTrigger = function(selector) {
    // select corresponding checkbox when clicking on table row
    $(selector).click(function(event) {
        if (event.target.type !== 'checkbox') {
            var cbox = $(this).find(':checkbox')
            cbox.prop('checked', !cbox.prop('checked'));
        }
    });
}

addSelectAllTrigger = function(target, selector) {
    // select all checkboxes at once
    $(target).click(function() {
        $(selector + ' :checkbox').prop('checked', $(this).prop('checked'));
    });
}

$(function() {
    $(document).on('scroll', function() {
        if ($(window).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
        } else {
            $('.scroll-top-wrapper').removeClass('show');
        }
    });

    $('.scroll-top-wrapper').on('click', scrollToTop);
});
