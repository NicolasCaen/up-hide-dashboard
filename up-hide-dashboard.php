<?php
/*
Plugin Name: Masquer le Dashboard
Description: Cache le tableau de bord WordPress dans le menu
Version: 1.0
Author: GEHIN Nicolas
*/

// Masque le menu Dashboard et redirige vers un autre menu
function masquer_dashboard() {
    global $menu;
    
    // Retire le menu Dashboard
    remove_menu_page('index.php');
    
    // Redirige depuis le dashboard vers un autre menu (par exemple: les médias)
    if (is_admin() && $GLOBALS['pagenow'] == 'index.php') {
        wp_redirect(admin_url('upload.php'));
        exit;
    }
}
add_action('admin_menu', 'masquer_dashboard');

// Retire le lien "Tableau de bord" de la barre d'admin
function masquer_dashboard_admin_bar() {
    global $wp_admin_bar;
    if ($wp_admin_bar) {
        $wp_admin_bar->remove_node('dashboard');
        $wp_admin_bar->remove_node('site-name');
    }
}
add_action('admin_bar_menu', 'masquer_dashboard_admin_bar', 999);

// Modifie la redirection après connexion
function modifier_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        // Redirige vers la bibliothèque de médias après connexion
        return admin_url('upload.php');
    }
    return $redirect_to;
}
add_filter('login_redirect', 'modifier_login_redirect', 10, 3); 