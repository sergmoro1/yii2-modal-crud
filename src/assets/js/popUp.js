/*
 * @author - Sergey Morozov <sergmoro1@ya.ru>
 * @license - MIT
 * 
 * Service table with pop-up form.
 */
popUp = popUp || {};
popUp.default = {
    "id": "modal",
    "content": ".modal-dialog .modal-content",
    "body": ".modal-body",
    "footer": ".modal-footer",
    "actions": ["view", "update"]
};
(function() {
    popUp.area = popUp.area || function() {
        popUp.id = popUp.id || popUp.default.id;
        popUp.win = popUp.win || (popUp.id + '-win');
        popUp.add = popUp.add || (popUp.id + '-add');
        popUp.content = popUp.content || popUp.default.content;
        popUp.body = popUp.body || popUp.default.body;
        popUp.footer = popUp.footer || popUp.default.footer;
        popUp.actions = popUp.actions || popUp.default.actions;
        return '#' + popUp.win + ' ' + popUp.content;
    };
    // table line actions
    for(var i = 0; i < popUp.actions.length; i++) {
        var action = popUp.actions[i];
        $('.table td .' + action).on('click', function() {
	        $(popUp.area() + ' ' + popUp.body).load($(this).attr('href'));
        });
    }
    // button save of popup window
    $(popUp.area() + ' ' + popUp.footer + ' .btn.btn-primary').on('click', function() {
        $('.' + popUp.id + '-form #submit-btn').click();
    });
    // button add
    $('#' + popUp.add).on('click', function() {
        $(popUp.area() + ' ' + popUp.body).load($(this).attr('href'))
    });
}());
