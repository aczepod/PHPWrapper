<?php

/*=======================================================================================
 *																						*
 *								COntologyEdge.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyEdge} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyEdge} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Unique identifier.
 *
 * This tag identifies the hashed version of the subject/predicate/object triplet stored in
 * the {@link kOFFSET_GID} offset.
 */
define( "kOFFSET_UID",							'_uniqueIdentifier' );

/**
 * Subject vertex kind.
 *
 * This tag identifies the subject vertex kind, it represents a set of enumerated values
 * that define the subject vertex kind in the current edge.
 * For instance one may indicate that the subject vertex of the relationship is a root node.
 */
define( "kOFFSET_KIND_SUBJECT",					'_subjectVertexKind' );

/**
 * Object vertex kind.
 *
 * This tag identifies the object vertex kind, it represents a set of enumerated values
 * that define the object vertex kind in the current edge.
 * For instance one may indicate that the object vertex of the relationship is a scale node.
 */
define( "kOFFSET_KIND_OBJECT",					'_objectVertexKind' );

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Edges container name.
 *
 * This tag identifies the default name for the container that will host edge objects.
 */
define( "kCONTAINER_EDGE_NAME",					'_edges' );

/*=======================================================================================
 *	DEFAULT SEQUENCE KEY																*
 *======================================================================================*/

/**
 * Edge sequence.
 *
 * This tag identifies the default sequence key associated with edges.
 */
define( "kSEQUENCE_KEY_EDGE",					'@edge' );

?>
