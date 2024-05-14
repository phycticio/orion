<?php

namespace orion\actions\admin;

class Orion_Dashboard {
	public static function start(): void {
		add_action( 'wp_dashboard_setup', self::wp_dashboard_setup( ... ) );
	}

	public static function wp_dashboard_setup(): void {
		global $wp_meta_boxes;

//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );
//		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
//		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
//		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	}
}