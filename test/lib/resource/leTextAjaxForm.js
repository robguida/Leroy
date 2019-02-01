/**
 * Created by robert on 1/30/2019.
 */
var leTextAjaxForm = {
    divReadMode: null,
    divEditMode: null,
    divReadModeValue: null,
    edit: function () {
        this.divReadMode.removeClass('mode_open_read')
            .addClass('mode_close');
        this.divEditMode.removeClass('mode_close')
            .addClass('mode_open_edit');
    },
    callbackDelete: null,
    callbackSave: null,
    callbackCancel: function () {
        this.divReadMode.removeClass('mode_close')
            .addClass('mode_open_read');
        this.divEditMode.removeClass('mode_open_edit')
            .addClass('mode_close');
    }
}
