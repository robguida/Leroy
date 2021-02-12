/**
 * @note This method is passed into LePopMenu
 *
 *      See HOW-TO EXAMPLE at bottom of the page
 *
 * @param menuClass - string for css class
 * @param menuItems - array LePopMenuItemModel's
 * @param menuOffset - integer to offset the menu from the parent element or the clicked element
 *              so the button would be the clicked element and the parent would be the containing TD
 * @constructor
 */
function LePopMenuModel (menuClass, menuItems, menuOffset) {
    if (!menuOffset) {
        menuOffset = 30;
    }
    this.menuClass = menuClass;
    this.menuItems = menuItems;
    this.menuOffset = menuOffset;
    this.clear = false;
}

/**
 * @note For each menu item in the Pop Menu, there is one LePopMenuItemModel. These are created and
 *      injected into the LePopMenuModel that is then injected into LePopMenu.
 *
 *       See HOW-TO EXAMPLE at bottom of the page
 *
 * @param text
 * @param callBack
 * @param attrs
 * @constructor
 */
function LePopMenuItemModel (text, callBack, attrs) {
    this.text = text;
    this.callBack = callBack;
    this.attr = attrs;
}

/**
 * @param options {LePopMenuModel}
 * @constructor
 */
$.fn.LePopMenu = function (options) {
    /** @var LePopMenuModel options */
    let elemObj = $(this);
    let off = false;

    function build() {
        console.log('LePopMenu.build()');
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
                hide();
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
        elemObj
            .css('cursor', 'pointer')
            .parent()
            .append(menu)
        ;
    }

    function hide() {
        /* When the mouse leaves the elemMenu, we want to make sure it did not re-enter the action button. */
        setTimeout(function () {
            if (off) {
                elemObj.parent().find('ul').hide();
            }
        }, 50);
    }
    console.log('LePopMenu.options.clear = ' + options.clear);
    if (options.hasOwnProperty('clear') && true === options.clear) {
        elemObj.parent().find('ul').remove();
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
            hide();
        })
    ;
    return elemObj;
}

/**
 HOW-TO EXAMPLE

 let menuItemModel1 = new LePopMenuItemModel(
    'Menu Item 1',
     function () { // call back logic here; }
 )
 ;
 let menuItemModel2 = new LePopMenuItemModel(
     'Menu Item 2',
     function () { // call back logic here; }
 )
 ;
 let menuModel = new LePopMenuModel('Menu Name Here', [menuItemModel1, menuItemModel2], 25);
 $(DOMObj).LePopMenu(menuModel)
*/