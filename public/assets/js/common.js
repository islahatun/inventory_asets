function initSelectRowDataTables(target, table) {

    return $(target + ' tbody').off().on('click', 'tr', function () {
        if ($(this).hasClass('info')) {
            $(this).removeClass('info');
        } else {

            table.$('tr.info').removeClass('info');
            $(this).addClass('info');
        }
    });

}

function getSelectedRowDataTables(table) {
    return table.cell('.info', 0).index();
}
