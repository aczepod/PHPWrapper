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
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Nodes container name.
 *
 * This tag identifies the default name for the container that will host node objects.
 */
define( "kCONTAINER_NODE_NAME",					':_nodes' );

/*=======================================================================================
 *	DEFAULT SEQUENCE KEY																*
 *======================================================================================*/

/**
 * Node sequence.
 *
 * This tag identifies the default sequence key associated with nodes.
 */
define( "kSEQUENCE_KEY_NODE",					'@node' );

/*=======================================================================================
 *	REFERENCE SWITCHES																	*
 *======================================================================================*/

/**
 * Edge references.
 *
 * This switch determines whether to keep track of terms that reference the current term as
 * a namespace. The switch can take the following values:
 *
 * <ul>
 *	<li><tt>0x2</tt>: <i>Keep count of edge references</i>. This means that the
 *		{@link kTAG_EDGES} attribute will be an integer representing the number of
 *		times the current node was referenced as the subject or object of an edge.
 *	<li><tt>0x3</tt>: <i>Keep list of edge references</i>. This means that the
 *		{@link kTAG_EDGES} attribute will be a list of edge references representing
 *		the native identifier of all edges that reference the current node as a subject or
 *		object.
 *	<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This means that
 *		the {@link kTAG_EDGES} attribute will not be handled.
 * </ul>
 */
define( "kSWITCH_kTAG_EDGES",					0x0 );


?>
