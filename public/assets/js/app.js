scrollToTop = function () {
    verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $('body');
    offset = element.offset();
    offsetTop = offset.top;
    $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}

addCheckboxTrigger = function (selector) {
    // select corresponding checkbox when clicking on table row
    $(selector).on('click', function (event) {
        if (event.target.type !== 'checkbox') {
            var cbox = $(this).find(':checkbox')
            cbox.prop('checked', !cbox.prop('checked'));
        }
    });
}

addSelectAllTrigger = function (target, selector) {
    // select all checkboxes at once
    $(target).click(function () {
        $(selector + ' :checkbox').prop('checked', $(this).prop('checked'));
    });
}

pollGreylist = function (target, timestamp) {
    // @TODO: enable again, with working CSRF token
    return;
    $.post(target, {timestamp: timestamp}, function (responseText, textStatus, jqXHR) {

        //var response = $.parseJSON(responseText);
        var response = responseText;

        if (response.payload) {
            // get table
            var table = $('#greylist-table').DataTable();

            for (var key in response.payload) {
                var item = response.payload[key];

                var table_row = table.row.add([
                    item.checkbox ? item.checkbox : '',
                    item.sender_name ? item.sender_name : '',
                    item.sender_domain ? item.sender_domain : '',
                    item.src ? item.src : '',
                    item.rcpt ? item.rcpt : '',
                    item.first_seen ? item.first_seen : '',
                ]).draw().node();

                // animate seems not to work, although finished-callback is fired
                // https://datatables.net/reference/api/row.add()
                //$(table_row).css('color', 'red').animate({color: 'black'});
                $(table_row).css('color', 'red');
            }
        }

        setTimeout(pollGreylist, 7000, target, response.timestamp);
    });
}

$(function () {
    $(document).on('scroll', function () {
        if ($(window).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
        } else {
            $('.scroll-top-wrapper').removeClass('show');
        }
    });

    $('.scroll-top-wrapper').on('click', scrollToTop);

    // some dataTable defaults
    $.extend($.fn.dataTable.defaults, {
        'iDisplayLength': 50,
    });
});