<?php

add_action('template_redirect', function () {
    if (!is_admin() && !is_404()) {
        wp_die(__('404 not found', 'orion'), 'Error 404');
    }
});
