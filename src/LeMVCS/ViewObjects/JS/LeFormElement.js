/**
 * Created by robert on 5/2/2019.
 */
class LeFormElement {
    //<editor-fold desc="Wrapper Functions">
    static button(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('button', name, value, attr, style, id);
    }

    static checkbox(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('checkbox', name, value, attr, style, id);
    }

    static color(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('color', name, value, attr, style, id);
    }

    static date(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('date', name, value, attr, style, id);
    }

    static dateTime(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('dateTime', name, value, attr, style, id);
    }

    static dateTimeLocal(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('dateTimeLocal', name, value, attr, style, id);
    }

    static email(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('email', name, value, attr, style, id);
    }

    static file(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('file', name, value, attr, style, id);
    }

    static hidden(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('hidden', name, value, attr, style, id);
    }

    static image(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('image', name, value, attr, style, id);
    }

    static month(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('month', name, value, attr, style, id);
    }

    static number(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('number', name, value, attr, style, id);
    }

    static password(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('password', name, value, attr, style, id);
    }

    static radio(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('radio', name, value, attr, style, id);
    }

    static range(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('range', name, value, attr, style, id);
    }

    static reset(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('reset', name, value, attr, style, id);
    }

    static search(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('search', name, value, attr, style, id);
    }

    static submit(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('submit', name, value, attr, style, id);
    }

    static tel(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('tel', name, value, attr, style, id);
    }

    static text(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('text', name, value, attr, style, id);
    }

    static time(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('time', name, value, attr, style, id);
    }

    static url(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('url', name, value, attr, style, id);
    }

    static week(name, value = '', attr = {}, style = {}, id = '') {
        return LeFormElement.Input('week', name, value, attr, style, id);
    }
    //</editor-fold>

    //<editor-fold desc="Primary Element Functions & Private Functions">
    /**
     * @param type {string}
     * @param name {string}
     * @param value {string}
     * @param attr {{}}
     * @param style {{}}
     * @param id {string}
     * @returns {*|Window.jQuery}
     * @constructor
     */
    static Input(type, name, value = '', attr = {}, style = {}, id = '') {
        const fe = new LeFormElement();
        if (!id) {
            id = name.toLowerCase();
        }
        const elemObj = $('<input />').attr('type', type).attr('name', name).attr('id', id);
        if ('file' !== type) {
            elemObj.val(value);
        }
        fe.#addAttributes(elemObj, attr);
        fe.#addStyles(elemObj, style);
        return elemObj;
    }

    /**
     * @param for_ {string}
     * @param display {string}
     * @param id {string}
     * @param attr {{}}
     * @param style {{}}
     * @returns {*|Window.jQuery}
     */
    static Label(for_, display, id, attr, style) {
        const fe = new LeFormElement();
        const elemObj = $('<label />').attr('for', for_).text(display);
        if (id) {
            elemObj.attr('id', id);
        }
        fe.#addAttributes(elemObj, attr);
        fe.#addStyles(elemObj, style);
        return elemObj;
    }

    /**
     * @param name {string}
     * @param selected {string}
     * @param options {{}}
     * @param attr {{}}
     * @param style {{}}
     * @param id {string}
     * @param has_groups {boolean}
     * @returns {*|Window.jQuery}
     */
    static Select(name, selected, options, attr = {}, style = {}, id = '', has_groups = false) {
        const fe = new LeFormElement();
        if (!id) {
            id = name.toLowerCase();
        }
        const elemObj = $('<select />').attr('name', name).attr('id', id);
        fe.#addAttributes(elemObj, attr);
        fe.#addStyles(elemObj, style);
        if (has_groups) {
            $.each(options, function (group, group_options) {
                const elemOptGrp = $('<optgroup>').attr('label', group);
                $.each(group_options, function (t, v) {
                    elemOptGrp.append($('<option>').val(v).text(t));
                });
                elemObj.append(elemOptGrp);
            });
        } else {
            $.each(options, function (t, v) {
                elemObj.append($('<option>').val(v).text(t));
            });
        }
        if (selected) {
            elemObj.val(selected);
        }
        return elemObj;
    }

    /**
     * @param name
     * @param value
     * @param attr
     * @param style
     * @param id
     * @returns {*|Window.jQuery}
     */
    static TextArea(name, value = '', attr = {}, style = {}, id = '') {
        const fe = new LeFormElement();
        if (!id) {
            id = name.toLowerCase();
        }
        const elemObj = $('<textarea></textarea>').attr('name', name).attr('id', id);
        if (value) {
            elemObj.text(value);
        }
        fe.#addAttributes(elemObj, attr);
        fe.#addStyles(elemObj, style);
        return elemObj;
    }

    /**
     * @param elemObj {*|Window.jQuery}
     * @param attr {{}}
     */
    #addAttributes(elemObj, attr) {
        if ('object' === typeof (attr)) {
            $.each(attr, function (a, v) {
                elemObj.attr(a, v);
            });
        }
    }

    /**
     * @param elemObj {*|Window.jQuery}
     * @param style {{}}
     */
    #addStyles(elemObj, style) {
        if ('object' === typeof (style)) {
            $.each(style, function (c, v) {
                elemObj.css(c, v);
            });
        }
    }
    //</editor-fold>
}
