/**
 * Created by robert on 5/2/2019.
 */
var LeFormElement = {
    button: function (name, value, attr, style, id) {
        return LeFormElement.Input('button', name, value, attr, style, id);
    },
    checkbox: function (name, value, attr, style, id) {
        return LeFormElement.Input('checkbox', name, value, attr, style, id);
    },
    color: function (name, value, attr, style, id) {
        return LeFormElement.Input('color', name, value, attr, style, id);
    },
    date: function (name, value, attr, style, id) {
        return LeFormElement.Input('date', name, value, attr, style, id);
    },
    dateTime: function (name, value, attr, style, id) {
        return LeFormElement.Input('dateTime', name, value, attr, style, id);
    },
    dateTimeLocal: function (name, value, attr, style, id) {
        return LeFormElement.Input('dateTimeLocal', name, value, attr, style, id);
    },
    email: function (name, value, attr, style, id) {
        return LeFormElement.Input('email', name, value, attr, style, id);
    },
    file: function (name, value, attr, style, id) {
        return LeFormElement.Input('file', name, value, attr, style, id);
    },
    hidden: function (name, value, attr, style, id) {
        return LeFormElement.Input('hidden', name, value, attr, style, id);
    },
    image: function (name, value, attr, style, id) {
        return LeFormElement.Input('image', name, value, attr, style, id);
    },
    label: function (for_, display, id, attr, style) {
        var elemObj = $('<label />').attr('for', for_).text(display);
        if (id){ elemObj.attr('id', id); }
        this.addAttributes(elemObj, attr);
        this.addStyles(elemObj, style);
        return elemObj;
    },
    month: function (name, value, attr, style, id) {
        return LeFormElement.Input('month', name, value, attr, style, id);
    },
    number: function (name, value, attr, style, id) {
        return LeFormElement.Input('number', name, value, attr, style, id);
    },
    password: function (name, value, attr, style, id) {
        return LeFormElement.Input('password', name, value, attr, style, id);
    },
    radio: function (name, value, attr, style, id) {
        return LeFormElement.Input('radio', name, value, attr, style, id);
    },
    range: function (name, value, attr, style, id) {
        return LeFormElement.Input('range', name, value, attr, style, id);
    },
    reset: function (name, value, attr, style, id) {
        return LeFormElement.Input('reset', name, value, attr, style, id);
    },
    search: function (name, value, attr, style, id) {
        return LeFormElement.Input('search', name, value, attr, style, id);
    },
    select: function (name, selected, options, attr, style, id) {
        if (!id) { id = name.toLowerCase(); }
        var elemObj = $('<select />').attr('name', name).attr('id', id);
        this.addAttributes(elemObj, attr);
        this.addStyles(elemObj, style);
        $.each(options, function(v, t) {
            elemObj.append($('<option>').val(v).text(t) );
        });
        if (selected) {
            elemObj.val(selected);
        }
        return elemObj;
    },
    submit: function (name, value, attr, style, id) {
        return LeFormElement.Input('submit', name, value, attr, style, id);
    },
    tel: function (name, value, attr, style, id) {
        return LeFormElement.Input('tel', name, value, attr, style, id);
    },
    text: function (name, value, attr, style, id) {
        return LeFormElement.Input('text', name, value, attr, style, id);
    },
    textArea: function (name, value, attr, style, id) {
        if (!id) { id = name.toLowerCase(); }
        var elemObj = $('<textarea></textarea>').attr('name', name).attr('id', id);
        if (value) { elemObj.text(value); }
        this.addAttributes(elemObj, attr);
        this.addStyles(elemObj, style);
        return elemObj;
    },
    time: function (name, value, attr, style, id) {
        return LeFormElement.Input('time', name, value, attr, style, id);
    },
    url: function (name, value, attr, style, id) {
        return LeFormElement.Input('url', name, value, attr, style, id);
    },
    week: function (name, value, attr, style, id) {
        return LeFormElement.Input('week', name, value, attr, style, id);
    },
    Input: function (type, name, value, attr, style, id) {
        if (!id) { id = name.toLowerCase(); }
        var elemObj = $('<input />').attr('type', type).attr('name', name).attr('id', id);
        if ('file' !== type) { elemObj.val(value); }
        this.addAttributes(elemObj, attr);
        this.addStyles(elemObj, style);
        return elemObj;
    },
    addAttributes: function (elemObj, attr) {
        if ('object' === typeof(attr)) {
            $.each(attr, function (a, v) {
                elemObj.attr(a, v);
            });
        }
    },
    addStyles: function (elemObj, style) {
        if ('object' === typeof(style)) {
            $.each(style, function (c, v) {
                elemObj.css(c, v);
            });
        }
    }
 };
