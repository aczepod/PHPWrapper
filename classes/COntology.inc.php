<?php

/*=======================================================================================
 *																						*
 *									COntology.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntology} definitions.
 *
 *	This file contains common definitions used by the {@link COntology} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *	DEFAULT ONTOLOGY OBJECT DATA STRUCTURES												*
 *======================================================================================*/

/**
 * Terms.
 *
 * This tag identifies the root data dictionary node of the terms object data structure, it
 * describes the default elements comprising the term objects in this library.
 */
define( "kDDICT_TERM",							':DDICT-TERM' );

/**
 * Nodes.
 *
 * This tag identifies the root data dictionary node of the nodes object data structure, it
 * describes the default elements comprising the node objects in this library.
 */
define( "kDDICT_NODE",							':DDICT-NODE' );

/**
 * Edges.
 *
 * This tag identifies the root data dictionary node of the edges object data structure, it
 * describes the default elements comprising the edge objects in this library.
 */
define( "kDDICT_EDGE",							':DDICT-EDGE' );

/**
 * Tags.
 *
 * This tag identifies the root data dictionary node of the tags object data structure, it
 * describes the default elements comprising the tag objects in this library.
 */
define( "kDDICT_TAG",							':DDICT-TAG' );

?>
