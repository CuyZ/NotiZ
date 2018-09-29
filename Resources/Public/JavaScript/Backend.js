define([
    'jquery',
    'TYPO3/CMS/Backend/Popover',
    'bootstrap'
], function ($) {
    'use strict';

    /**
     * Keep Bootstrap popover open when the popover itself is being hovered.
     *
     * @see https://gist.github.com/timneutkens/115d96b97187a6cf6d1f4bce9c0d6e74
     */
    $('[data-toggle="popover-hover"]').popover({
        trigger: 'manual',
        html: true,
        animation:false,
        viewport: '.container'
    }).on('mouseenter', function () {
        var self = this;
        $(this).popover('show');
        $('.popover').on('mouseleave', function () {
            $(self).popover('hide');
        });
    }).on('mouseleave', function () {
        var self = this;
        setTimeout(function () {
            if (!$('.popover:hover').length) {
                $(self).popover('hide');
            }
        }, 600);
    });

    /**
     * When a click occurs on a link to create a new notification for a given
     * event, we need to change the parameters of all the links inside the modal
     * that will be shown.
     */
    (function () {
        $('.link-create-notification').on('click', function () {
            var eventIdentifier = $(this).data('event-identifier');

            $('.link-create-notification-event').each(function () {
                var href = $(this).data('href').replace('#EVENT#', eventIdentifier);

                $(this).attr('href', href);
            });
        });
    })();
});
