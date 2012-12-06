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
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Edges container name.
 *
 * This tag identifies the default name for the container that will host edge objects.
 */
define( "kCONTAINER_EDGE_NAME",					':_edges' );

/*=======================================================================================
 *	DEFAULT SEQUENCE KEY																*
 *======================================================================================*/

/**
 * Edge sequence.
 *
 * This tag identifies the default sequence key associated with edges.
 */
define( "kSEQUENCE_KEY_EDGE",					'@edge' );

/*=======================================================================================
 *	CURRENT SWITCHES																	*
 *======================================================================================*/

/**
 * Reference edges.
 *
 * This switch determines whether edges add a reference to nodes in their {@link kTAG_EDGES}
 * attribute. The relationships between edges and nodes are recorded in the edge itself,
 * which means that the {@link kTAG_EDGES} attribute is redundant and might become rather
 * large, so this feature is disabled by default.
 */
define( "kSWITCH_kTAG_EDGES",					FALSE );

?>
