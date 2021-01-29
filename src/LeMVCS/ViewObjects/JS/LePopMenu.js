function LePopMenuModel (menuClass, menuItems, menuOffset) {
    if (!menuOffset) {
        menuOffset = 0;
    }
    this.menuClass = menuClass;
    this.menuItems = menuItems;
    this.menuOffset = menuOffset
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

    let elemObj = $(this);
    let off = false;

    function build() {
        let pos = elemObj.position();
        let menu = $('<ul></ul>')
            .attr('id', 'btn_add_budget')
            .addClass(options.menuClass)
            .css('margin-left', pos.left + options.menuOffset)
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
        elemObj.parent().append(menu);
    }

    function remove() {
        /* When the mouse leaves the elemMenu, we want to make sure it did not re-enter the action button. */
        setTimeout(function () {
            if (off) {
                elemObj.parent().find('ul').hide();
            }
        }, 50);
    }
    elemObj
        .mouseenter(function () {
            off = false;
            let menu = elemObj.parent().find('ul');
            if (menu.length) {
                menu.show();
            } else {
                build();
            }
        })
        .mouseleave(function () {
            off = true;
            remove();
        })
    ;
    // return elemObj;
}