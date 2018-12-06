define([
    'jquery',
    'TYPO3/CMS/Backend/Icons',
    'TYPO3/CMS/Backend/Notification',
    'TYPO3/CMS/Backend/Storage'
], function ($, Icons, Notification, Storage) {
    'use strict';

    var selector = {
        toolbarContainer: '#cuyz-notiz-backend-toolbaritems-notificationstoolbaritem',
        menuContainer: '.dropdown-menu',
        toolbarIcon: '.toolbar-item-icon .t3js-icon',
        /**
         * @deprecated Must be removed when TYPO3 v7 is not supported anymore.
         */
        legacyToolbarIcon: '.dropdown-toggle span.icon',
        dataContainer: '.t3js-notiz-data-container',
        iconContainer: '.t3js-notiz-icon'
    };

    var menu = (function () {
        var toolbarContainer = $(selector.toolbarContainer);
        var menuContainer = toolbarContainer.find(selector.menuContainer);

        return {
            container: menuContainer,

            content: function (content) {
                menuContainer.html(content);
            },

            show: function () {
                toolbarContainer.addClass('open');
            },

            /**
             * Updates the content of the toolbar menu: it is fetched with an
             * Ajax request.
             */
            update: function (callback) {
                timer.reset();

                loading.run(function () {
                    $.ajax({
                        url: TYPO3.settings.ajaxUrls['notiz_render_toolbar'],
                        data: {
                            skipSessionUpdate: 1
                        },
                        type: 'post',
                        cache: false
                    })
                    .done(function (result) {
                        // Display the new content of the toolbar.
                        menu.content(result);

                        // Update the icon (can have an error overlay).
                        icon.update(menu.container.find(selector.iconContainer).html());

                        // Send a flash message to the user.
                        var data = menu.data();
                        message.new(data.type).send(data.message.title, data.message.body);

                        if (data.error) {
                            timer.fastTick();
                        } else {
                            timer.defaultTick();
                        }

                        timer.launch();
                    })
                    .fail(menu.error)
                    .always(function () {
                        if (typeof callback !== 'undefined') {
                            callback();
                        }
                    });
                });
            },

            /**
             * Fetches data from a hidden element in the menu container. These
             * data are updated every time the toolbar is refreshed.
             */
            data: function () {
                var container = menuContainer.find(selector.dataContainer);

                return {
                    error: !!container.data('error'),
                    type: container.data('error') ? 'error' : 'success',
                    message: {
                        title: container.data('message-title'),
                        body: container.data('message-body')
                    }
                }
            },

            /**
             * If something went wrong when refreshing the toolbar, an error
             * message is displayed.
             */
            error: function () {
                // Reset the icon with its initial value.
                icon.update();

                // Display some error messages and a refresh button.
                var refreshLabel = TYPO3.lang['notiz.toolbar.error.refresh_label'];

                menu.content(
                    '<p class="dropdown-text text-danger">' + TYPO3.lang['notiz.toolbar.error.body'] + '</p>' +
                    '<hr />' +
                    '<p class="dropdown-text">' +
                    '<a href="javascript:void(0);" onclick="TYPO3.NotificationToolbar.menu.refresh();" title="' + refreshLabel + '">' +
                    '<span class="refresh-icon"></span>' + '&nbsp;' + refreshLabel +
                    '</a>' +
                    '</p>'
                );

                // Urgh.
                Icons.getIcon('actions-refresh', Icons.sizes.small, '', '', 'inline')
                    .done(function (refreshIcon) {
                        menu.container.find('.refresh-icon').replaceWith(refreshIcon);
                    });
            }
        };
    })();

    var loading = {
        run: function (callback) {
            Icons.getIcon('spinner-circle-light', Icons.sizes.small).done(function (spinner) {
                menu.content('<p class="text-center">' + spinner + '</p>');
                icon.update(spinner);

                callback();
            });
        }
    };

    var icon = (function () {
        var container = function () {
            var element = $(selector.toolbarIcon, selector.toolbarContainer);

            if (element.length === 0) {
                element = $(selector.legacyToolbarIcon, selector.toolbarContainer);
            }

            return element;
        };

        /**
         * Initial icon of the toolbar. We keep it in memory in case something
         * goes wrong, in which case it will be re-used.
         */
        var backupIcon = container().html();

        return {
            update: function (newIcon) {
                container().html(newIcon || backupIcon);
            }
        }
    })();

    /**
     * Timer used for refreshing the toolbar.
     */
    var timer = (function () {
        var instance = null;
        var defaultTick = 1000 * 60 * 5; // 5 minutes
        var tick = defaultTick;

        return {
            reset: function () {
                if (instance !== null) {
                    clearTimeout(instance);
                    instance = null;
                }
            },
            launch: function () {
                instance = setTimeout(menu.update, tick);
            },
            tick: function (newTick) {
                tick = 1000 * newTick
            },
            defaultTick: function () {
                tick = defaultTick;
            },
            /**
             * Speeds up the tick of the timer to increase chance to get a valid
             * toolbar faster.
             */
            fastTick: function () {
                tick = 1000 * 30; // 30 seconds
            }
        }
    })();

    var message = (function () {
        var typeKey = 'notiz.toolbar.message_type';

        return {
            new: function (type) {
                return {
                    /**
                     * Displays a flash message for the user, telling him/her if
                     * notifications are enabled or disabled.
                     */
                    send: function (title, body) {
                        if (!title && !body) {
                            return;
                        }

                        var lastType = Storage.Persistent.isset(typeKey)
                            ? Storage.Persistent.get(typeKey)
                            : null;

                        /*
                         * We display the message only if it was not displayed
                         * previously.
                         */
                        if (lastType === type) {
                            return;
                        }

                        if (type === 'error') {
                            Notification.error(title, body);
                        } else {
                            Notification.success(title, body, 10);
                        }

                        Storage.Persistent.set(typeKey, type);
                    }
                }
            }
        }
    })();

    try {
        /**
         * Registers the menu update as an event for the whole TYPO3 toolbar.
         */
        TYPO3.Backend.Topbar.Toolbar.registerEvent(menu.update);
    } catch (e) {
        /**
         * @deprecated Must be removed when TYPO3 v7 is not supported anymore.
         *
         * Steps to follow:
         * - Add `TYPO3/CMS/Backend/Viewport` as dependency in the RequireJS
         *   section of this file.
         * - Use the following statement instead of this try/catch block:
         *   `Viewport.Topbar.Toolbar.registerEvent(menu.update);`
         */
        $(menu.update);
    }

    /**
     * Public API of this module.
     */
    return TYPO3.NotificationToolbar = {
        menu: {
            update: menu.update,

            /**
             * Same as update, but at the end of the process the toolbar menu is
             * displayed.
             */
            refresh: function () {
                menu.update(function () {
                    menu.show();
                });
            }
        }
    };
});
