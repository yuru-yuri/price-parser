import 'admin-lte';
import './backend.statistic'

$(function () {

    'use strict';

    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        placeholder         : 'sort-highlight',
        connectWith         : '.connectedSortable',
        handle              : '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex              : 999999
    });
    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

    // jQuery UI sortable for the todo list
    $('.todo-list').sortable({
        placeholder         : 'sort-highlight',
        handle              : '.handle',
        forcePlaceholderSize: true,
        zIndex              : 999999
    });

    // $('#');labels

    // Fix for charts under tabs
    $('.box ul.nav a').on('shown.bs.tab', function () {
        area.redraw();
        donut.redraw();
        line.redraw();
    });

    /* The todo list plugin */
    $('.todo-list').todoList({
        onCheck  : function () {
            window.console.log($(this), 'The element has been checked');
        },
        onUnCheck: function () {
            window.console.log($(this), 'The element has been unchecked');
        }
    });

    $('body').on('click', 'a.warning', function (e) {
        if(!confirm($(e).attr('msg')))
        {
            e.preventDefault();
        }
    });
});
