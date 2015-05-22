<? defined('C5_EXECUTE') or die("Access Denied.");

$navItems = $controller->getNavItems();

/**
 * The $navItems variable is an array of objects, each representing a nav menu item.
 * It is a "flattened" one-dimensional list of all nav items -- it is not hierarchical.
 * However, a nested nav menu can be constructed from this "flat" array by
 * looking at various properties of each item to determine its place in the hierarchy
 * (see below, for example $navItem->level, $navItem->subDepth, $navItem->hasSubmenu, etc.)
 *
 * Items in the array are ordered with the first top-level item first, followed by its sub-items, etc.
 *
 * Each nav item object contains the following information:
 *	$navItem->url        : URL to the page
 *	$navItem->name       : page title (already escaped for html output)
 *	$navItem->target     : link target (e.g. "_self" or "_blank")
 *	$navItem->level      : number of levels deep the current menu item is from the top (top-level nav items are 1, their sub-items are 2, etc.)
 *	$navItem->subDepth   : number of levels deep the current menu item is *compared to the next item in the list* (useful for determining how many <ul>'s to close in a nested list)
 *	$navItem->hasSubmenu : true/false -- if this item has one or more sub-items (sometimes useful for CSS styling)
 *	$navItem->isFirst    : true/false -- if this is the first nav item *in its level* (for example, the first sub-item of a top-level item is TRUE)
 *	$navItem->isLast     : true/false -- if this is the last nav item *in its level* (for example, the last sub-item of a top-level item is TRUE)
 *	$navItem->isCurrent  : true/false -- if this nav item represents the page currently being viewed
 *	$navItem->inPath     : true/false -- if this nav item represents a parent page of the page currently being viewed (also true for the page currently being viewed)
 *	$navItem->attrClass  : Value of the 'nav_item_class' custom page attribute (if it exists and is set)
 *	$navItem->isHome     : true/false -- if this nav item represents the home page
 *	$navItem->cID        : collection id of the page this nav item represents
 *	$navItem->cObj       : collection object of the page this nav item represents (use this if you need to access page properties and attributes that aren't already available in the $navItem object)
 */


/** For extra functionality, you can add the following page attributes to your site (via Dashboard > Pages & Themes > Attributes):
 *
 * 1) Handle: exclude_nav
 *    (This is the "Exclude From Nav" attribute that comes pre-installed with concrete5, so you do not need to add it yourself.)
 *    Functionality: If a page has this checked, it will not be included in the nav menu (and neither will its children / sub-pages).
 *
 * 2) Handle: exclude_subpages_from_nav
 *    Type: Checkbox
 *    Functionality: If a page has this checked, all of that pages children (sub-pages) will be excluded from the nav menu (but the page itself will be included).
 *
 * 3) Handle: replace_link_with_first_in_nav
 *    Type: Checkbox
 *    Functionality: If a page has this checked, clicking on it in the nav menu will go to its first child (sub-page) instead.
 *
 * 4) Handle: nav_item_class
 *    Type: Text
 *    Functionality: Whatever is entered into this textbox will be outputted as an additional CSS class for that page's nav item (NOTE: you must un-comment the "$ni->attrClass" code block in the CSS section below for this to work).
 */


/*** STEP 1 of 2: Determine all CSS classes (only 2 are enabled by default, but you can un-comment other ones or add your own) ***/
foreach ($navItems as $ni) {
    $classes = array();

    if ($ni->isCurrent) {
        //class for the page currently being viewed
        $classes[] = 'nav-selected';
    }

    if ($ni->inPath) {
        //class for parent items of the page currently being viewed
        $classes[] = 'nav-path-selected';
    }

    /*
    if ($ni->isFirst) {
        //class for the first item in each menu section (first top-level item, and first item of each dropdown sub-menu)
        $classes[] = 'nav-first';
    }
    */

    /*
    if ($ni->isLast) {
        //class for the last item in each menu section (last top-level item, and last item of each dropdown sub-menu)
        $classes[] = 'nav-last';
    }
    */

    if ($ni->hasSubmenu) {
        //class for items that have dropdown sub-menus
        $classes[] = 'has-subs';
    }

    /*
    if (!empty($ni->attrClass)) {
        //class that can be set by end-user via the 'nav_item_class' custom page attribute
        $classes[] = $ni->attrClass;
    }
    */

    /*
    if ($ni->isHome) {
        //home page
        $classes[] = 'nav-home';
    }
    */

    /*
    //unique class for every single menu item
    $classes[] = 'nav-item-' . $ni->cID;
    */

    //Put all classes together into one space-separated string
    $ni->classes = implode(" ", $classes);
}


//*** Step 2 of 2: Output menu HTML ***/

$topLevelCnt = 0;

echo '<ul class="majority">'; //opens the top-level menu

foreach ($navItems as $ni) {
    if ( $ni->level == 1 ) {
        $topLevelCnt += 1;
    }
    echo '<li class="' . $ni->classes . '" data-sub="' . $topLevelCnt . '" >'; //opens a nav item
    echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">';

    if ( $ni->level == 2 ) {
        if ( $ni->cObj->getAttribute('page_image') ) {
            $imageSrc = $ni->cObj->getAttribute('page_image')->getRelativePath();
        } else {
            switch (true) {
                case (strpos($ni->url, "area_page=jackson")) :
                    $imageSrc = REALTOR_IMAGE_PATH . 'nav_jackson.jpg';
                    break;
                case (strpos($ni->url, "area_page=teton_valley")) :
                    $imageSrc = REALTOR_IMAGE_PATH . 'nav_tetonvalley.jpg';
                    break;
                case (strpos($ni->url, "area_page=lincoln_county")) :
                    $imageSrc = REALTOR_IMAGE_PATH . 'nav_lincolncounty.jpg';
                    break;
                case (strpos($ni->url, "area_page=other")) :
                    $imageSrc = REALTOR_IMAGE_PATH . 'nav_other.jpg';
                    break;
                default:
                    $imageSrc = REALTOR_IMAGE_PATH . 'nav_placeholder.jpg';
                    break;
            }
        }
        echo '<div class="pg-icon" style="background-image: url(' . $imageSrc . ')"></div>';
    }

    echo  $ni->name . '</a>';

    echo '</li>'; //closes a nav item

    // open independent sub nav element
    if ($ni->hasSubmenu) {
        echo '<li class="sub" id="sub-'. $topLevelCnt .'"><ul>'; //opens a dropdown sub-menu
    } else {
        echo '</li>'; //closes a nav item
        echo str_repeat('</ul></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
    }
}

    echo '<li class="has-subs contact" data-sub="contact"><a href="/contact">Contact</a> </li>'; // contact
    echo '<li class="sub" id="sub-contact"><ul>'; // opens contact sub

    echo '<li><img src="' . REALTOR_IMAGE_PATH . 'logo_white.png"></li>';
    echo '<li><div class="address">' . $controller->pkgConfig->get('theme.address_physical') .'<br>' . $controller->pkgConfig->get('theme.address_state') . '<br>' . $controller->pkgConfig->get('theme.phone_number_office') . '</div></li>';
    echo '<li class="contact"><br><a class="email" href="mailto:LintonBingle@gmail.com">LintonBingle@gmail.com</a></li>';
    echo '<li><ul class="social">';

    if ( $controller->pkgConfig->get('theme.social_link_facebook') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_facebook'). '"><span class="icon-facebook"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_twitter') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_twitter'). '"><span class="icon-twitter"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_pinterest') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_pinterest'). '"><span class="icon-pinterest"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_googleplus') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_googleplus'). '"><span class="icon-google-plus"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_linkedin') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_linkedin'). '"><span class="icon-linkedin"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.email_address') ) {
        echo '<li class="to-mail"><a href="mailto:' . $controller->pkgConfig->get('theme.email_address'). '"><span class="icon-envelope"></span></a></li>';
    }

    echo '<li class="to-form"><a href="#" class="modalize" data-width="600" data-title="Email Us" data-load="/email"><span class="icon-envelope"></span></a></li>';

//    echo '</ul></li>';

    echo '</ul><li>'; // closes contact sub
echo '</ul>'; //closes the top-level menu






// make the sidebar menu
echo '<div id="mobileNav"><ul class="sidebar">'; //opens the top-level menu

$passedFirst = false;
foreach ($navItems as $ni) {
    if ( !$ni->hasSubmenu ) {
        if ( $ni->level == 1 ) {
            $ni->classes .= " top-level";
            // this is a little dicey, but I know it works with our current IA
            echo "</ul>"; // close previous
//            if ( $passedFirst ) {
//                echo "</ul>"; // close previous
//            } else {
//                $passedFirst = true;
//            }
        }
        echo '<li class="' . $ni->classes . '">'; //opens a nav item
        echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">';
        echo  $ni->name . '</a>';
        echo '</li>'; //closes a nav item

    } else {
        if ( $passedFirst ) {
            echo "</ul>"; // close previous
        } else {
            $passedFirst = true;
        }
        echo '<li class="' . $ni->classes . ' show-plus"><div class="plus">+</div><div class="minus">-</div>'; //opens a nav item
        echo  $ni->name;
        echo '</li>'; //closes a nav item
        echo '<ul class="sub">'; //opens a dropdown sub-menu
    }
}

    echo '<li class="contact"><a href="/"><img src="' . REALTOR_IMAGE_PATH . 'logo_white.png"></a></li>';
    echo '<li class="contact"><div class="address">' . $controller->pkgConfig->get('theme.address_physical') .'<br>' . $controller->pkgConfig->get('theme.address_state') . '<br>' . $controller->pkgConfig->get('theme.phone_number_office') . '</div></li>';
    echo '<li class="contact"><br><a class="email" href="mailto:LintonBingle@gmail.com">LintonBingle@gmail.com</a></li>';
    echo '<li class="contact"><ul class="social">';

    if ( $controller->pkgConfig->get('theme.social_link_facebook') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_facebook'). '"><span class="icon-facebook"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_twitter') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_twitter'). '"><span class="icon-twitter"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_pinterest') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_pinterest'). '"><span class="icon-pinterest"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_googleplus') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_googleplus'). '"><span class="icon-google-plus"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.social_link_linkedin') ) {
        echo '<li><a href="' . $controller->pkgConfig->get('theme.social_link_linkedin'). '"><span class="icon-linkedin"></span></a></li>';
    }
    if ( $controller->pkgConfig->get('theme.email_address') ) {
        echo '<li class="to-mail"><a href="mailto:' . $controller->pkgConfig->get('theme.email_address'). '"><span class="icon-envelope"></span></a></li>';
    }

    echo '<li class="to-form"><a href="#" class="modalize" data-width="600" data-title="Email Us" data-load="/email"><span class="icon-envelope"></span></a></li>';

    echo '</ul></li>';

echo '</ul></div>'; //closes the top-level menu
