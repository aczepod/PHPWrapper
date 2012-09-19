<?php

/*=======================================================================================
 *																						*
 *								COntologyNode.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyNode} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyNode} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 11/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Edge references.
 *
 * This tag identifies edge references, the attribute contains the list of identifiers of
 * edges that reference the current node.
 */
define( "kOFFSET_REFS_EDGE",					'_edgeReferences' );

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Nodes container name.
 *
 * This tag identifies the default name for the container that will host node objects.
 */
define( "kCONTAINER_NODE_NAME",					'_nodes' );

/*=======================================================================================
 *	DEFAULT SEQUENCE KEY																*
 *======================================================================================*/

/**
 * Node sequence.
 *
 * This tag identifies the default sequence key associated with nodes.
 */
define( "kSEQUENCE_KEY_NODE",					'@node' );

?>
