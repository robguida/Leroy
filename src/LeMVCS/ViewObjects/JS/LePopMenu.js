function LePopMenuModel (menuClass, menuItems) {
    this.menuClass = menuClass;
    this.menuItems = menuItems;
}

function LePopMenuItemModel (text, callBack, attrs) {
    this.text = text;
    this.callBack = callBack;
    this.attr = attrs;
}

/**
 * @param options
 * @constructor
 */
$.fn.LePopMenu = function (options) {
    /** @var LePopMenuModel options */
    let off = false;

    function build() {
        let pos = elemObj.position();
        let menu = $('<ul></ul>')
            .addClass(options.menuClass)
            .css('margin-left', pos.left)
            .mouseenter(function () {
                off = false;
            })
            .mouseleave(function () {
                off = true;
                remove();
            });
        ;
        /** @var LePopMenuItemModel mi */
        $.each(options.menuItems, function (i, mi) {
            menu.append(
                $('<li></li>')
                    .html(mi.text)
                    .click(mi.callBack)
            );
        });
        elemObj.append(menu);
    }

    function remove() {
        /* When the mouse leaves the elemMenu, we want to make sure it did not re-enter the action button. */
        setTimeout(function () {
            console.log('LePopMenu.remove.off = ' + off);
            if (off) {
                elemObj.find('ul').remove();
            }
        }, 50);
    }

    let elemObj = $(this);
    elemObj
        .mouseenter(function () {
            console.log('LePopMenu.elemObj.mouseenter');
            off = false;
            build();
        })
        .mouseleave(function () {
            console.log('LePopMenu.elemObj.mouseleave');
            off = true;
            remove();
        })
    ;
    return elemObj;
}