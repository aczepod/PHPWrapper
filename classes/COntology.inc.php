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
 *	GENERIC ATTRIBUTESß																	*
 *======================================================================================*/

/**
 * Attributes.
 *
 * This tag identifies the root node for the generic attributes, it collects all generic
 * attributes available to all other data dictionaries in this library.
 */
define( "kDDICT_ATTRIBUTES",					':DDICT-ATTR' );

/*=======================================================================================
 *	WRAPPER WEB-SERVICE API																*
 *======================================================================================*/

/**
 * Wrapper API.
 *
 * This tag identifies the root node for the wrapper web-services API.
 */
define( "kDDICT_WRAPPER",						':DDICT-WRAP' );

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

/*=======================================================================================
 *	DEFAULT ONTOLOGY INSTANCES															*
 *======================================================================================*/

/**
 * Predicates.
 *
 * This tag collects all default predicate terms.
 */
define( "kINSTANCE_PREDICATES",					':INSTANCE-PREDICATES' );

/**
 * Node kinds.
 *
 * This tag collects all default node kind terms.
 */
define( "kINSTANCE_NODE_KINDS",					':INSTANCE-NODE-KIND' );

/**
 * Data types.
 *
 * This tag collects all default node kind terms.
 */
define( "kINSTANCE_DATA_TYPES",					':INSTANCE-DATA-TYPE' );

/*=======================================================================================
 *	DEFAULT ONTOLOGY ATTRIBUTES															*
 *======================================================================================*/

/**
 * Attributes.
 *
 * This tag collects all default attributes.
 */
define( "kDEFAULT_ATTRIBUTES",					':DEFAULT-ATTRIBUTES' );

?>
