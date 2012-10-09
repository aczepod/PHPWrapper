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

/*=======================================================================================
 *	DEFAULT NODE KINDS																	*
 *======================================================================================*/

/**
 * Root node.
 *
 * This tag identifies a root or ontology node kind.
 */
define( "kNODE_KIND_ROOT",						'ROOT' );

/**
 * Trait node.
 *
 * This tag identifies a trait or measurable node kind.
 */
define( "kNODE_KIND_TRAIT",						'TRAIT' );

/**
 * Method node.
 *
 * This tag identifies a method node kind.
 */
define( "kNODE_KIND_METH",						'METHOD' );

/**
 * Scale node.
 *
 * This tag identifies a scale or measure node kind.
 */
define( "kNODE_KIND_SCALE",						'SCALE' );

/**
 * Enumeration node.
 *
 * This tag identifies an enumerated value node kind.
 */
define( "kNODE_KIND_ENUM",						'ENUM' );

/*=======================================================================================
 *	CUSTOM NODE DATA TYPES																*
 *======================================================================================*/

/**
 * Enumeration type.
 *
 * This value represents the enumeration data type, it represents an enumeration element or
 * container.
 *
 * Enumerations represent a vocabulary from which one value must be chosen, this particular
 * data type is used in {@link COntologyNode} objects: it indicates that the node refers to
 * a controlled vocabulary scalar data type and that the enumerated set follows in the graph
 * definition.
 */
define( "kTYPE_ENUM",							':ENUM' );

/**
 * Set type.
 *
 * This value represents the enumerated set data type, it represents an enumerated set
 * element or container.
 *
 * Sets represent a vocabulary from which one or more value must be chosen, this particular
 * data type is used in {@link COntologyNode} objects: it indicates that the node refers to
 * a controlled vocabulary array data type and that the enumerated set follows in the graph
 * definition.
 */
define( "kTYPE_ENUM_SET",						':SET' );

/*=======================================================================================
 *	CARDINALITY ENUMERATIONS															*
 *======================================================================================*/

/**
 * Required.
 *
 * This tag indicates that the element is required, which means that the offset must be
 * present in the object.
 */
define( "kTYPE_CARD_REQUIRED",					':REQUIRED' );

/**
 * Array.
 *
 * This tag indicates that the element represents an array and that the data type applies
 * to the elements of the array.
 */
define( "kTYPE_CARD_ARRAY",						':ARRAY' );

?>
