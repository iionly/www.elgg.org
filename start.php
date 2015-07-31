<?php
namespace Elgg\Www;

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\init');

function init() {
	elgg_register_plugin_hook_handler('container_permissions_check', 'object', __NAMESPACE__ . '\only_admins_can_post_blogs');

	elgg_register_plugin_hook_handler('register', 'menu:title', __NAMESPACE__ . '\remove_discussion_add_button');
}

function only_admins_can_post_blogs($hook, $type, $return, $params) {
	if ($params['subtype'] == 'blog') {
		return $params['user']->isAdmin();
	}
}

/**
 * Remove the group add button for non-admins
 *
 * @param string $hook Hook name
 * @param string $type Hook type
 * @param array  $menu Array of ElggMenuItem objects
 * 
 * @return array
 */
function remove_discussion_add_button($hook, $type, $menu) {
	if (elgg_get_context() == 'discussion') {
		foreach ($menu as $index => $item) {
			if ($item->getName() == 'add') {
				unset($menu[$index]);
			}
		}
	}
	return $menu;
}

