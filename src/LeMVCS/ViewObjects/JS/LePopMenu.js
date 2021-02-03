/**
 * @note This method is passed into LePopMenu See HOW-TO EXAMPLE at bottom of the page
 *
 * @param menuClass - string for css class
 * @param menuItems - array LePopMenuItemModel's
 * @param menuOffset - integer to offset the menu from the parent element or the clicked element
 *              so the button would be the clicked element and the parent would be the containing TD
 * @constructor
 */
function LePopMenuModel (menuClass, menuItems, menuOffset) {
    if (!menuOffset) {
        menuOffset = 0;
    }
    this.menuClass = menuClass;
    this.menuItems = menuItems;
    this.menuOffset = menuOffset
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

/**
 HOW-TO EXAMPLE

 let LePopMenuItem = new LePopMenuItemModel(
    'Menu Item 1',
     function () { // call back logic here; }
 )
 ;
 let LePopMenuItem2 = new LePopMenuItemModel(
     'Menu Item 2',
     function () { // call back logic here; }
 )
 ;
 let LePopMenu = new LePopMenuModel('Menu Name Here', [LePopMenuItem, LePopMenuItem2], 25);
*/