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
 * Relationship API
 *
 * RELATIONSHIP DEFINITIONS
 * * Child/parent relationship:
 *    the child bug is generated by the parent bug or is directly linked with the parent with the following meaning
 *    the child bug has to be resolved before resolving the parent bug (the child bug "blocks" the parent bug)
 *    example: bug A is child bug of bug B. It means: A blocks B and B is blocked by A
 * * General relationship:
 *    two bugs related each other without any hierarchy dependance
 *    bugs A and B are related
 * * Duplicates:
 *    it's used to mark a bug as duplicate of an other bug already stored in the database
 *    bug A is marked as duplicate of B. It means: A duplicates B, B has duplicates
 *
 * Relations are always visible in the email body
 * --------------------------------------------------------------------
 * ADD NEW RELATIONSHIP
 * - Permission: user can update the source bug and at least view the destination bug
 * - Action recorded in the history of both the bugs
 * - Email notification sent to the users of both the bugs based based on the 'updated' bug notify type.
 * --------------------------------------------------------
 * DELETE RELATIONSHIP
 * - Permission: user can update the source bug and at least view the destination bug
 * - Action recorded in the history of both the bugs
 * - Email notification sent to the users of both the bugs based based on the 'updated' bug notify type.
 * --------------------------------------------------------
 * RESOLVE/CLOSE BUGS WITH BLOCKING CHILD BUGS STILL OPEN
 * Just a warning is print out on the form when an user attempts to resolve or close a bug with
 * related bugs in relation BUG_DEPENDANT still not resolved.
 * Anyway the user can force the resolving/closing action.
 * --------------------------------------------------------
 * EMAIL NOTIFICATION TO PARENT BUGS WHEN CHILDREN BUGS ARE RESOLVED/CLOSED
 * Every time a child bug is resolved or closed, an email notification is sent directly to all the handlers
 * of the parent bugs. The notification is sent to bugs not already marked as resolved or closed.
 * --------------------------------------------------------
 * ADD CHILD
 * This function gives the opportunity to generate a child bug. In details the function:
 * - create a new bug with the same basic information of the parent bug (plus the custom fields)
 * - copy all the attachment of the parent bug to the child
 * - not copy history, bugnotes, monitoring users
 * - set a relationship between parent and child
 *
 * @package CoreAPI
 * @subpackage RelationshipAPI
 * @author Marcello Scata' <marcelloscata at users.sourceforge.net> ITALY
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2010  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */

/**
 * requires collapse_api
 */
require_once( 'collapse_api.php' );

/**
 * RelationshipData Structure Definition
 * @package MantisBT
 * @subpackage classes
 */
class BugRelationshipData {
	var $id;
	var $src_bug_id;
	var $src_project_id;
	var $dest_bug_id;
	var $dest_project_id;
	var $type;
}

$g_relationships = array();
$g_relationships[BUG_DEPENDANT] = array(
	'#forward' => TRUE,
	'#complementary' => BUG_BLOCKS,
	'#description' => 'dependant_on',
	'#notify_added' => 'email_notification_title_for_action_dependant_on_relationship_added',
	'#notify_deleted' => 'email_notification_title_for_action_dependant_on_relationship_deleted',
	'#edge_style' => array(
		'color' => '#C00000',
		'dir' => 'back',
	),
);
$g_relationships[BUG_BLOCKS] = array(
	'#forward' => FALSE,
	'#complementary' => BUG_DEPENDANT,
	'#description' => 'blocks',
	'#notify_added' => 'email_notification_title_for_action_blocks_relationship_added',
	'#notify_deleted' => 'email_notification_title_for_action_blocks_relationship_deleted',
	'#edge_style' => array(
		'color' => '#C00000',
		'dir' => 'forward',
	),
);
$g_relationships[BUG_DUPLICATE] = array(
	'#forward' => TRUE,
	'#complementary' => BUG_HAS_DUPLICATE,
	'#description' => 'duplicate_of',
	'#notify_added' => 'email_notification_title_for_action_duplicate_of_relationship_added',
	'#notify_deleted' => 'email_notification_title_for_action_duplicate_of_relationship_deleted',
	'#edge_style' => array(
		'style' => 'dashed',
		'color' => '#808080',
	),
);
$g_relationships[BUG_HAS_DUPLICATE] = array(
	'#forward' => FALSE,
	'#complementary' => BUG_DUPLICATE,
	'#description' => 'has_duplicate',
	'#notify_added' => 'email_notification_title_for_action_has_duplicate_relationship_added',
	'#notify_deleted' => 'email_notification_title_for_action_has_duplicate_relationship_deleted',
);
$g_relationships[BUG_RELATED] = array(
	'#forward' => TRUE,
	'#complementary' => BUG_RELATED,
	'#description' => 'related_to',
	'#notify_added' => 'email_notification_title_for_action_related_to_relationship_added',
	'#notify_deleted' => 'email_notification_title_for_action_related_to_relationship_deleted',
);

if( file_exists( dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'custom_relationships_inc.php' ) ) {
	require_once( dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'custom_relationships_inc.php' );
}

/**
 * Return the complementary type of the provided relationship
 * @param int $p_relationship_type Relationship type
 * @return int Complementary type
 */
function relationship_get_complementary_type( $p_relationship_type ) {
	global $g_relationships;
	if( !isset( $g_relationships[$p_relationship_type] ) ) {
		trigger_error( ERROR_GENERIC, ERROR );
	}
	return $g_relationships[$p_relationship_type]['#complementary'];
}

/**
 * Add a new relationship
 * @param int $p_src_bug_id Source Bug Id
 * @param int $p_dest_bug_id Destination Bug Id
 * @param int $p_relationship_type Relationship type
 * @return BugRelationshipData Bug Relationship
 */
function relationship_add( $p_src_bug_id, $p_dest_bug_id, $p_relationship_type ) {
	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	global $g_relationships;
	if( $g_relationships[$p_relationship_type]['#forward'] === FALSE ) {
		$c_src_bug_id = db_prepare_int( $p_dest_bug_id );
		$c_dest_bug_id = db_prepare_int( $p_src_bug_id );
		$c_relationship_type = db_prepare_int( relationship_get_complementary_type( $p_relationship_type ) );
	} else {
		$c_src_bug_id = db_prepare_int( $p_src_bug_id );
		$c_dest_bug_id = db_prepare_int( $p_dest_bug_id );
		$c_relationship_type = db_prepare_int( $p_relationship_type );
	}

	$query = "INSERT INTO $t_mantis_bug_relationship_table
				( source_bug_id, destination_bug_id, relationship_type )
				VALUES
				( " . db_param() . ',' . db_param() . ',' . db_param() . ')';
	$result = db_query_bound( $query, Array( $c_src_bug_id, $c_dest_bug_id, $c_relationship_type ) );
	$t_relationship = db_fetch_array( $result );

	$t_bug_relationship_data = new BugRelationshipData;
	$t_bug_relationship_data->id = $t_relationship['id'];
	$t_bug_relationship_data->src_bug_id = $t_relationship['source_bug_id'];
	$t_bug_relationship_data->dest_bug_id = $t_relationship['destination_bug_id'];
	$t_bug_relationship_data->type = $t_relationship['relationship_type'];

	return $t_bug_relationship_data;
}

/**
 * Update a relationship
 * @param int $p_relationship_id Relationship Id to update
 * @param int $p_src_bug_id Source Bug Id
 * @param int $p_dest_bug_id Destination Bug Id
 * @param int $p_relationship_type Relationship type
 * @return BugRelationshipData Bug Relationship
 */
function relationship_update( $p_relationship_id, $p_src_bug_id, $p_dest_bug_id, $p_relationship_type ) {
	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	global $g_relationships;
	if( $g_relationships[$p_relationship_type]['#forward'] === FALSE ) {
		$c_src_bug_id = db_prepare_int( $p_dest_bug_id );
		$c_dest_bug_id = db_prepare_int( $p_src_bug_id );
		$c_relationship_type = db_prepare_int( relationship_get_complementary_type( $p_relationship_type ) );
	} else {
		$c_src_bug_id = db_prepare_int( $p_src_bug_id );
		$c_dest_bug_id = db_prepare_int( $p_dest_bug_id );
		$c_relationship_type = db_prepare_int( $p_relationship_type );
	}
	$c_relationship_id = db_prepare_int( $p_relationship_id );

	$query = "UPDATE $t_mantis_bug_relationship_table
				SET source_bug_id=" . db_param() . ",
					destination_bug_id=" . db_param() . ",
					relationship_type=" . db_param() . "
				WHERE id=" . db_param();
	$result = db_query_bound( $query, array( $c_src_bug_id, $c_dest_bug_id, $c_relationship_type, $c_relationship_id ) );
	$t_relationship = db_fetch_array( $result );

	$t_bug_relationship_data = new BugRelationshipData;
	$t_bug_relationship_data->id = $t_relationship['id'];
	$t_bug_relationship_data->src_bug_id = $t_relationship['source_bug_id'];
	$t_bug_relationship_data->dest_bug_id = $t_relationship['destination_bug_id'];
	$t_bug_relationship_data->type = $t_relationship['relationship_type'];

	return $t_bug_relationship_data;
}

/**
 * Delete a relationship
 * @param int $p_relationship_id Relationship Id to update
 */
function relationship_delete( $p_relationship_id ) {
	$c_relationship_id = db_prepare_int( $p_relationship_id );

	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	$query = "DELETE FROM $t_mantis_bug_relationship_table
				WHERE id=" . db_param();
	$result = db_query_bound( $query, array( $c_relationship_id ) );
}

/**
 * Deletes all the relationships related to a specific bug (both source and destination)
 * @param int $p_bug_id Bug Id
 */
function relationship_delete_all( $p_bug_id ) {
	$c_bug_id = db_prepare_int( $p_bug_id );

	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	$query = "DELETE FROM $t_mantis_bug_relationship_table
				WHERE source_bug_id=" . db_param() . " OR
				destination_bug_id=" . db_param();
	$result = db_query_bound( $query, array( $c_bug_id, $c_bug_id ) );
}

/**
 * copy all the relationships related to a specific bug to a new bug
 * @param int $p_bug_id Source Bug Id
 * @param int $p_new_bug_id Destination Bug Id
 */
function relationship_copy_all( $p_bug_id, $p_new_bug_id ) {
	$c_bug_id = db_prepare_int( $p_bug_id );
	$c_new_bug_id = db_prepare_int( $p_new_bug_id );

	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	$t_relationship = relationship_get_all_src( $p_bug_id );
	$t_relationship_count = count( $t_relationship );
	for( $i = 0;$i < $t_relationship_count;$i++ ) {
		relationship_add( $p_new_bug_id, $t_relationship[$i]->dest_bug_id, $t_relationship[$i]->type );
	}

	$t_relationship = relationship_get_all_dest( $p_bug_id );
	$t_relationship_count = count( $t_relationship );
	for( $i = 0;$i < $t_relationship_count;$i++ ) {
		relationship_add( $t_relationship[$i]->src_bug_id, $p_new_bug_id, $t_relationship[$i]->type );
	}

	return;
}

/**
 * get a relationship from id
 * @param int $p_relationship_id Relationship ID
 * @return null|BugRelationshipData BugRelationshipData object
 */
function relationship_get( $p_relationship_id ) {
	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	$query = "SELECT *
				FROM $t_mantis_bug_relationship_table
				WHERE id=" . db_param();
	$result = db_query_bound( $query, array( (int) $p_relationship_id ) );

	$t_relationship_count = db_num_rows( $result );

	if( $t_relationship_count == 1 ) {
		$t_relationship = db_fetch_array( $result );

		$t_bug_relationship_data = new BugRelationshipData;
		$t_bug_relationship_data->id = $t_relationship['id'];
		$t_bug_relationship_data->src_bug_id = $t_relationship['source_bug_id'];
		$t_bug_relationship_data->dest_bug_id = $t_relationship['destination_bug_id'];
		$t_bug_relationship_data->type = $t_relationship['relationship_type'];
	} else {
		$t_bug_relationship_data = null;
	}

	return $t_bug_relationship_data;
}

/**
 * get all relationships with the given bug as source
 * @param int $p_src_bug_id Source Bug id
 * @return array Array of BugRelationshipData objects
 */
function relationship_get_all_src( $p_src_bug_id ) {
	$c_src_bug_id = db_prepare_int( $p_src_bug_id );

	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );
	$t_mantis_bug_table = db_get_table( 'mantis_bug_table' );

	$query = "SELECT $t_mantis_bug_relationship_table.id, $t_mantis_bug_relationship_table.relationship_type,
				$t_mantis_bug_relationship_table.source_bug_id, $t_mantis_bug_relationship_table.destination_bug_id,
				$t_mantis_bug_table.project_id
				FROM $t_mantis_bug_relationship_table
				INNER JOIN $t_mantis_bug_table ON $t_mantis_bug_relationship_table.destination_bug_id = $t_mantis_bug_table.id
				WHERE source_bug_id=" . db_param() . "
				ORDER BY relationship_type, $t_mantis_bug_relationship_table.id";
	$result = db_query_bound( $query, array( $c_src_bug_id ) );

	$t_src_project_id = bug_get_field( $p_src_bug_id, 'project_id' );

	$t_bug_relationship_data = array();
	$t_relationship_count = db_num_rows( $result );
	$t_bug_array = Array();
	for( $i = 0;$i < $t_relationship_count;$i++ ) {
		$row = db_fetch_array( $result );
		$t_bug_relationship_data[$i] = new BugRelationshipData;
		$t_bug_relationship_data[$i]->id = $row['id'];
		$t_bug_relationship_data[$i]->src_bug_id = $row['source_bug_id'];
		$t_bug_relationship_data[$i]->src_project_id = $t_src_project_id;
		$t_bug_relationship_data[$i]->dest_bug_id = $row['destination_bug_id'];
		$t_bug_relationship_data[$i]->dest_project_id = $row['project_id'];
		$t_bug_relationship_data[$i]->type = $row['relationship_type'];
		$t_bug_array[] = $row['destination_bug_id'];
	}
	unset( $t_bug_relationship_data[$t_relationship_count] );
	if( !empty( $t_bug_array ) ) {
		bug_cache_array_rows( $t_bug_array );
	}

	return $t_bug_relationship_data;
}

/**
 * get all relationships with the given bug as destination
 * @param int $p_dest_bug_id Destination Bug id
 * @return array Array of BugRelationshipData objects
 */
function relationship_get_all_dest( $p_dest_bug_id ) {
	$c_dest_bug_id = db_prepare_int( $p_dest_bug_id );

	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );
	$t_mantis_bug_table = db_get_table( 'mantis_bug_table' );

	$query = "SELECT $t_mantis_bug_relationship_table.id, $t_mantis_bug_relationship_table.relationship_type,
				$t_mantis_bug_relationship_table.source_bug_id, $t_mantis_bug_relationship_table.destination_bug_id,
				$t_mantis_bug_table.project_id
				FROM $t_mantis_bug_relationship_table
				INNER JOIN $t_mantis_bug_table ON $t_mantis_bug_relationship_table.source_bug_id = $t_mantis_bug_table.id
				WHERE destination_bug_id=" . db_param() . "
				ORDER BY relationship_type, $t_mantis_bug_relationship_table.id";
	$result = db_query_bound( $query, Array( $c_dest_bug_id ) );

	$t_dest_project_id = bug_get_field( $p_dest_bug_id, 'project_id' );

	$t_bug_relationship_data = array();
	$t_relationship_count = db_num_rows( $result );
	$t_bug_array = Array();
	for( $i = 0;$i < $t_relationship_count;$i++ ) {
		$row = db_fetch_array( $result );
		$t_bug_relationship_data[$i] = new BugRelationshipData;
		$t_bug_relationship_data[$i]->id = $row['id'];
		$t_bug_relationship_data[$i]->src_bug_id = $row['source_bug_id'];
		$t_bug_relationship_data[$i]->src_project_id = $row['project_id'];
		$t_bug_relationship_data[$i]->dest_bug_id = $row['destination_bug_id'];
		$t_bug_relationship_data[$i]->dest_project_id = $t_dest_project_id;
		$t_bug_relationship_data[$i]->type = $row['relationship_type'];
		$t_bug_array[] = $row['source_bug_id'];
	}
	unset( $t_bug_relationship_data[$t_relationship_count] );

	if( !empty( $t_bug_array ) ) {
		bug_cache_array_rows( $t_bug_array );
	}
	return $t_bug_relationship_data;
}

/**
 * get all relationships associated with the given bug
 * @param int $p_bug_id  Bug id
 * @param bool &$p_is_different_projects Returned Boolean value indicating if some relationships cross project boundaries
 * @return array Array of BugRelationshipData objects
 */
function relationship_get_all( $p_bug_id, &$p_is_different_projects ) {
	$t_src = relationship_get_all_src( $p_bug_id );
	$t_dest = relationship_get_all_dest( $p_bug_id );
	$t_all = array_merge( $t_src, $t_dest );

	$p_is_different_projects = false;
	$t_count = count( $t_all );
	for( $i = 0;$i < $t_count;$i++ ) {
		$p_is_different_projects |= ( $t_all[$i]->src_project_id != $t_all[$i]->dest_project_id );
	}
	return $t_all;
}

/**
 * check if there is a relationship between two bugs
 * return id if found 0 otherwise
 * @param int $p_src_bug_id Source Bug Id
 * @param int $p_dest_bug_id Destination Bug Id
 * @return int Relationship ID
 */
function relationship_exists( $p_src_bug_id, $p_dest_bug_id ) {
	$c_src_bug_id = db_prepare_int( $p_src_bug_id );
	$c_dest_bug_id = db_prepare_int( $p_dest_bug_id );

	$t_mantis_bug_relationship_table = db_get_table( 'mantis_bug_relationship_table' );

	$t_query = "SELECT *
				FROM $t_mantis_bug_relationship_table
				WHERE
				(source_bug_id=" . db_param() . "
				AND destination_bug_id=" . db_param() . ")
				OR
				(source_bug_id=" . db_param() . "
				AND destination_bug_id=" . db_param() . ')';
	$result = db_query_bound( $t_query, array( $c_src_bug_id, $c_dest_bug_id, $c_dest_bug_id, $c_src_bug_id ), 1 );

	$t_relationship_count = db_num_rows( $result );

	if( $t_relationship_count == 1 ) {

		# return the first id
		$row = db_fetch_array( $result );
		return $row['id'];
	} else {

		# no relationship found
		return 0;
	}
}

/**
 * check if there is a relationship between two bugs
 * return:
 *  0 if the relationship is not found
 *  -1 if the relationship is found and it's of the same type $p_rel_type
 *  id if the relationship is found and it's of a different time (this means it can be replaced with the new type $p_rel_type
 * @param int $p_src_bug_id Source Bug Id
 * @param int $p_dest_bug_id Destination Bug Id
 * @param int $p_rel_type Relationship Type
 * @return int 0, -1 or id
 */
function relationship_same_type_exists( $p_src_bug_id, $p_dest_bug_id, $p_rel_type ) {

	# Check if there is already a relationship set between them
	$t_id_relationship = relationship_exists( $p_src_bug_id, $p_dest_bug_id );

	if( $t_id_relationship > 0 ) {

		# if there is...
		# get all the relationship info
		$t_relationship = relationship_get( $t_id_relationship );

		if( $t_relationship->src_bug_id == $p_src_bug_id && $t_relationship->dest_bug_id == $p_dest_bug_id ) {
			if( $t_relationship->type == $p_rel_type ) {
				$t_id_relationship = -1;
			}
		} else {
			if( $t_relationship->type == relationship_get_complementary_type( $p_rel_type ) ) {
				$t_id_relationship = -1;
			}
		}
	}
	return $t_id_relationship;
}

/**
 * retrieve the linked bug id of the relationship: provide src -> return dest; provide dest -> return src
 * @param int $p_relationship_id Relationship id
 * @param int $p_bug_id Bug Id
 * @return int Complementary bug id
 */
function relationship_get_linked_bug_id( $p_relationship_id, $p_bug_id ) {

	$t_bug_relationship_data = relationship_get( $p_relationship_id );

	if( $t_bug_relationship_data->src_bug_id == $p_bug_id ) {
		return $t_bug_relationship_data->dest_bug_id;
	}

	if( $t_bug_relationship_data->dest_bug_id == $p_bug_id ) {
		return $t_bug_relationship_data->src_bug_id;
	}

	trigger_error( ERROR_RELATIONSHIP_NOT_FOUND, ERROR );
}

/**
 * get class description of a relationship (source side)
 * @param int $p_relationship_type Relationship type
 * @return string Relationship description
 */
function relationship_get_description_src_side( $p_relationship_type ) {
	global $g_relationships;
	if( !isset( $g_relationships[$p_relationship_type] ) ) {
		trigger_error( ERROR_RELATIONSHIP_NOT_FOUND, ERROR );
	}
	return lang_get( $g_relationships[$p_relationship_type]['#description'] );
}

/**
 * get class description of a relationship (destination side)
 * @param int $p_relationship_type Relationship type
 * @return string Relationship description
 */
function relationship_get_description_dest_side( $p_relationship_type ) {
	global $g_relationships;
	if( !isset( $g_relationships[$p_relationship_type] ) || !isset( $g_relationships[$g_relationships[$p_relationship_type]['#complementary']] ) ) {
		trigger_error( ERROR_RELATIONSHIP_NOT_FOUND, ERROR );
	}
	return lang_get( $g_relationships[$g_relationships[$p_relationship_type]['#complementary']]['#description'] );
}

/**
 * get class description of a relationship as it's stored in the history
 * @param int $p_relationship_code Relationship Type
 * @return string Relationship description
 */
function relationship_get_description_for_history( $p_relationship_code ) {
	return relationship_get_description_src_side( $p_relationship_code );
}

/**
 * return false if there are child bugs not resolved/closed
 * N.B. we don't check if the parent bug is read-only. This is because the answer of this function is indepedent from
 * the state of the parent bug itself.
 * @param int $p_bug_id Bug id
 * @return bool
 */
function relationship_can_resolve_bug( $p_bug_id ) {

	# retrieve all the relationships in which the bug is the source bug
	$t_relationship = relationship_get_all_src( $p_bug_id );
	$t_relationship_count = count( $t_relationship );
	if( $t_relationship_count == 0 ) {
		return true;
	}

	for( $i = 0;$i < $t_relationship_count;$i++ ) {

		# verify if each bug in relation BUG_DEPENDANT is already marked as resolved
		if( $t_relationship[$i]->type == BUG_DEPENDANT ) {
			$t_dest_bug_id = $t_relationship[$i]->dest_bug_id;
			$t_status = bug_get_field( $t_dest_bug_id, 'status' );
			if( $t_status < config_get( 'bug_resolved_status_threshold' ) ) {

				# the bug is NOT marked as resolved/closed
				return false;
			}
		}
	}

	return true;
}

/**
 * return formatted string with all the details on the requested relationship
 * @param int $p_bug_id Bug id
 * @param BugRelationshipData $p_relationship Relationsip object
 * @param bool $p_html Generate html
 * @param bool $p_html_preview ???? generate printable version???
 * @param bool $p_show_project Show Project details
 * @return string
 */
function relationship_get_details( $p_bug_id, $p_relationship, $p_html = false, $p_html_preview = false, $p_show_project = false ) {
	$t_summary_wrap_at = utf8_strlen( config_get( 'email_separator2' ) ) - 28;
	$t_icon_path = config_get( 'icon_path' );

	if( $p_bug_id == $p_relationship->src_bug_id ) {

		# root bug is in the src side, related bug in the dest side
		$t_related_bug_id = $p_relationship->dest_bug_id;
		$t_related_project_name = project_get_name( $p_relationship->dest_project_id );
		$t_relationship_descr = relationship_get_description_src_side( $p_relationship->type );
	} else {

		# root bug is in the dest side, related bug in the src side
		$t_related_bug_id = $p_relationship->src_bug_id;
		$t_related_project_name = project_get_name( $p_relationship->src_project_id );
		$t_relationship_descr = relationship_get_description_dest_side( $p_relationship->type );
	}

	# related bug not existing...
	if( !bug_exists( $t_related_bug_id ) ) {
		return '';
	}

	# user can access to the related bug at least as a viewer
	if( !access_has_bug_level( VIEWER, $t_related_bug_id ) ) {
		return '';
	}

	if( $p_html_preview == false ) {
		$t_td = '<td>';
	} else {
		$t_td = '<td class="print">';
	}

	# get the information from the related bug and prepare the link
	$t_bug = bug_get( $t_related_bug_id, false );
	$t_status = string_attribute( get_enum_element( 'status', $t_bug->status ) );
	$t_resolution = string_attribute( get_enum_element( 'resolution', $t_bug->resolution ) );

	$t_relationship_info_html = $t_td . string_no_break( $t_relationship_descr ) . '&nbsp;</td>';
	if( $p_html_preview == false ) {
		$t_relationship_info_html .= '<td><a href="' . string_get_bug_view_url( $t_related_bug_id ) . '">' . bug_format_id( $t_related_bug_id ) . '</a></td>';
		$t_relationship_info_html .= '<td><span class="issue-status" title="' . $t_resolution . '">' . $t_status . '</span></td>';
	} else {
		$t_relationship_info_html .= $t_td . bug_format_id( $t_related_bug_id ) . '</td>';
		$t_relationship_info_html .= $t_td . $t_status . '&nbsp;</td>';
	}

	$t_relationship_info_text = utf8_str_pad( $t_relationship_descr, 20 );
	$t_relationship_info_text .= utf8_str_pad( bug_format_id( $t_related_bug_id ), 8 );

	# get the handler name of the related bug
	$t_relationship_info_html .= $t_td;
	if( $t_bug->handler_id > 0 ) {
		$t_relationship_info_html .= string_no_break( prepare_user_name( $t_bug->handler_id ) );
	}
	$t_relationship_info_html .= '&nbsp;</td>';

	# add project name
	if( $p_show_project ) {
		$t_relationship_info_html .= $t_td . string_display_line( $t_related_project_name ) . '&nbsp;</td>';
	}

	# add summary
 	if( $p_html == true ) {
 		$t_relationship_info_html .= $t_td . string_display_line_links( $t_bug->summary );
 		if( VS_PRIVATE == $t_bug->view_state ) {
 			$t_relationship_info_html .= sprintf( ' <img src="%s" alt="(%s)" title="%s" />', $t_icon_path . 'protected.gif', lang_get( 'private' ), lang_get( 'private' ) );
 		}
  	} else {
 		if( utf8_strlen( $t_bug->summary ) <= $t_summary_wrap_at ) {
 			$t_relationship_info_text .= string_email_links( $t_bug->summary );
 		} else {
 			$t_relationship_info_text .= utf8_substr( string_email_links( $t_bug->summary ), 0, $t_summary_wrap_at - 3 ) . '...';
 		}
	}

	# add delete link if bug not read only and user has access level
 	if( !bug_is_readonly( $p_bug_id ) && !current_user_is_anonymous() && ( $p_html_preview == false ) ) {
 		if( access_has_bug_level( config_get( 'update_bug_threshold' ), $p_bug_id ) ) {
			$t_relationship_info_html .= ' [<a class="small" href="bug_relationship_delete.php?bug_id=' . $p_bug_id . '&amp;rel_id=' . $p_relationship->id . htmlspecialchars( form_security_param( 'bug_relationship_delete' ) ) . '">' . lang_get( 'delete_link' ) . '</a>]';
		}
	}

	$t_relationship_info_html .= '&nbsp;</td>';
	$t_relationship_info_text .= "\n";

	if( $p_html_preview == false ) {
		$t_relationship_info_html = '<tr bgcolor="' . get_status_color( $t_bug->status ) . '">' . $t_relationship_info_html . '</tr>' . "\n";
	} else {
		$t_relationship_info_html = '<tr>' . $t_relationship_info_html . '</tr>';
	}

	if( $p_html == true ) {
		return $t_relationship_info_html;
	} else {
		return $t_relationship_info_text;
	}
}

/**
 * print ALL the RELATIONSHIPS OF A SPECIFIC BUG
 * @param int $p_bug_id Bug id
 * @return string
 */
function relationship_get_summary_html( $p_bug_id ) {
	$t_summary = '';
	$t_show_project = false;

	$t_relationship_all = relationship_get_all( $p_bug_id, $t_show_project );
	$t_relationship_all_count = count( $t_relationship_all );

	# prepare the relationships table
	for( $i = 0;$i < $t_relationship_all_count;$i++ ) {
		$t_summary .= relationship_get_details( $p_bug_id, $t_relationship_all[$i], true, false, $t_show_project );
	}

	if( !is_blank( $t_summary ) ) {
		if( relationship_can_resolve_bug( $p_bug_id ) == false ) {
			$t_summary .= '<tr class="row-2"><td colspan="' . ( 5 + $t_show_project ) . '"><b>' . lang_get( 'relationship_warning_blocking_bugs_not_resolved' ) . '</b></td></tr>';
		}
		$t_summary = '<table border="0" width="100%" cellpadding="0" cellspacing="1">' . $t_summary . '</table>';
	}

	return $t_summary;
}

/**
 * print ALL the RELATIONSHIPS OF A SPECIFIC BUG
 * @param int $p_bug_id Bug id
 * @return string
 */
function relationship_get_summary_html_preview( $p_bug_id ) {
	$t_summary = '';
	$t_show_project = false;

	$t_relationship_all = relationship_get_all( $p_bug_id, $t_show_project );
	$t_relationship_all_count = count( $t_relationship_all );

	# prepare the relationships table
	for( $i = 0;$i < $t_relationship_all_count;$i++ ) {
		$t_summary .= relationship_get_details( $p_bug_id, $t_relationship_all[$i], true, true, $t_show_project );
	}

	if( !is_blank( $t_summary ) ) {
		if( relationship_can_resolve_bug( $p_bug_id ) == false ) {
			$t_summary .= '<tr class="print"><td class="print" colspan=' . ( 5 + $t_show_project ) . '><b>' . lang_get( 'relationship_warning_blocking_bugs_not_resolved' ) . '</b></td></tr>';
		}
		$t_summary = '<table border="0" width="100%" cellpadding="0" cellspacing="1">' . $t_summary . '</table>';
	}

	return $t_summary;
}

/**
 * print ALL the RELATIONSHIPS OF A SPECIFIC BUG in text format (used by email_api.php
 * @param int $p_bug_id Bug id
 * @return string
 */
function relationship_get_summary_text( $p_bug_id ) {
	$t_summary = '';
	$t_show_project = false;

	$t_relationship_all = relationship_get_all( $p_bug_id, $t_show_project );
	$t_relationship_all_count = count( $t_relationship_all );

	# prepare the relationships table
	for( $i = 0;$i < $t_relationship_all_count;$i++ ) {
		$t_summary .= relationship_get_details( $p_bug_id, $t_relationship_all[$i], false );
	}

	return $t_summary;
}

/**
 * print HTML relationship listbox
 * @param int $p_default_rel_type Relationship Type (default -1)
 * @param string $p_select_name List box name (default "rel_type")
 * @param bool $p_include_any Include an ANY option in list box (default false)
 * @param bool $p_include_none Include a NONE option in list box (default false)
 * @param int $p_bug_id Bug id
 * @return null
 */
function relationship_list_box( $p_default_rel_type = -1, $p_select_name = "rel_type", $p_include_any = false, $p_include_none = false ) {
	global $g_relationships;
	?>
<select name="<?php echo $p_select_name?>">
<?php if( $p_include_any ) {?>
<option value="-1" <?php echo( $p_default_rel_type == -1 ? ' selected="selected"' : '' )?>>[<?php echo lang_get( 'any' )?>]</option>
<?php
	}

	if( $p_include_none ) {?>
<option value="-2" <?php echo( $p_default_rel_type == -2 ? ' selected="selected"' : '' )?>>[<?php echo lang_get( 'none' )?>]</option>
<?php
	}

	foreach( $g_relationships as $type => $relationship ) {
		?>
<option value="<?php echo $type?>"<?php echo( $p_default_rel_type == $type ? ' selected="selected"' : '' )?>><?php echo lang_get( $relationship['#description'] )?></option>
<?php
	}?>
</select>
<?php
}

/**
 * print HTML relationship form
 * @param int $p_bug_id Bug id
 * @return null
 */
function relationship_view_box( $p_bug_id ) {
	?>
<br/>

<?php collapse_open( 'relationships' );?>
<table class="width100" cellspacing="1">
<tr class="row-2" valign="top">
	<td width="15%" class="form-title" colspan="2">
		<?php
			collapse_icon( 'relationships' );
	echo lang_get( 'bug_relationships' );
	if( ON == config_get( 'relationship_graph_enable' ) ) {
		?>
		<span class="small"><?php print_bracket_link( "bug_relationship_graph.php?bug_id=$p_bug_id&graph=relation", lang_get( 'relation_graph' ) )?></span>
		<span class="small"><?php print_bracket_link( "bug_relationship_graph.php?bug_id=$p_bug_id&graph=dependency", lang_get( 'dependency_graph' ) )?></span>
		<?php
	}
	?>
	</td>
</tr>
<?php
	# bug not read-only and user authenticated
	if( !bug_is_readonly( $p_bug_id ) ) {

		# user access level at least updater
		if( access_has_bug_level( config_get( 'update_bug_threshold' ), $p_bug_id ) ) {
			?>
<tr class="row-1">
	<td class="category"><?php echo lang_get( 'add_new_relationship' )?></td>
	<td><?php echo lang_get( 'this_bug' )?>
		<form method="post" action="bug_relationship_add.php">
		<?php echo form_security_field( 'bug_relationship_add' ) ?>
		<input type="hidden" name="src_bug_id" value="<?php echo $p_bug_id?>" size="4" />
		<?php relationship_list_box( -1 )?>
		<input type="text" name="dest_bug_id" value="" />
		<input type="submit" name="add_relationship" class="button" value="<?php echo lang_get( 'add_new_relationship_button' )?>" />
		</form>
	</td></tr>
<?php
		}
	}
	?>
<tr>
	<td colspan="2"><?php echo relationship_get_summary_html( $p_bug_id )?></td>
</tr>
</table>

<?php collapse_closed( 'relationships' );?>
<table class="width100" cellspacing="1">
<tr>
	<td class="form-title">
		<?php
			collapse_icon( 'relationships' );
	echo lang_get( 'bug_relationships' );
	?>
	</td>
</tr>
</table>

<?php
	collapse_end( 'relationships' );
}
