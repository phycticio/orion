<?php

add_action('admin_menu', function(){
    remove_menu_page('tools.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('plugins.php');
    remove_submenu_page('edit.php', 'acf-settings-updates');
    remove_submenu_page('themes.php', 'themes.php');
    remove_submenu_page('themes.php', 'widgets.php');
    remove_submenu_page('themes.php', 'customize.php');
    remove_submenu_page('options-general.php', 'options-general.php');
    remove_submenu_page('options-general.php', 'options-permalink.php');
    remove_submenu_page('options-general.php', 'options-privacy.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');

    global $submenu;
    unset($submenu['themes.php'][6]);
}, 10, 0);
