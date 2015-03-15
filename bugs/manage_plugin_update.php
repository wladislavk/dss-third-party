<?php namespace Ds3\Legacy; ?><?php
# MantisBT - a php based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package MantisBT
 * @version $Id$
 * @copyright Copyright (C) 2002 - 2010  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */

 /** @ignore */
define( 'PLUGINS_DISABLED', true );

/**
 * MantisBT Core API's
 */
require_once( 'core.php' );

form_security_validate( 'manage_plugin_update' );

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$t_plugin_table	= db_get_table( 'mantis_plugin_table' );

$t_query = "SELECT basename FROM $t_plugin_table";
$t_result = db_query_bound( $t_query );

while ( $t_row = db_fetch_array( $t_result ) ) {
	$t_basename = $t_row['basename'];

	$f_change = gpc_get_bool( 'change_'.$t_basename, 0 );

	if ( !$f_change ) { continue; }

	$f_priority = gpc_get_int( 'priority_'.$t_basename, 3 );
	$f_protected = gpc_get_bool( 'protected_'.$t_basename, 0 );

	$t_query = "UPDATE $t_plugin_table SET priority=" . db_param() . ', protected=' . db_param() .
		' WHERE basename=' . db_param();

	db_query_bound( $t_query, array( $f_priority, $f_protected, $t_basename ) );
}

form_security_purge( 'manage_plugin_update' );

print_successful_redirect( 'manage_plugin_page.php' );
