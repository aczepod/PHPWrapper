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
 *	DEFAULT NODE KINDS																	*
 *======================================================================================*/

/**
 * Root node.
 *
 * This tag identifies a root or ontology node kind.
 */
define( "kKIND_NODE_ROOT",						':ROOT' );

/**
 * Data dictionary node.
 *
 * This tag identifies a structure definition or data dictionary node kind, in general this
 * will be used in conjunction to the {@link kKIND_NODE_ROOT} node kind to indicate a data
 * structure description.
 */
define( "kKIND_NODE_DDICT",						':DDICT' );

/**
 * Trait node.
 *
 * This tag identifies a trait or measurable node kind.
 */
define( "kKIND_NODE_TRAIT",						':TRAIT' );

/**
 * Method node.
 *
 * This tag identifies a method node kind.
 */
define( "kKIND_NODE_METHOD",					':METHOD' );

/**
 * Scale node.
 *
 * This tag identifies a scale or measure node kind.
 */
define( "kKIND_NODE_SCALE",						':SCALE' );

/**
 * Enumeration node.
 *
 * This tag identifies an enumeration node kind.
 */
define( "kKIND_NODE_ENUMERATION",				':ENUMERATION' );

/**
 * Instance node.
 *
 * This tag identifies an instance node kind.
 */
define( "kKIND_NODE_INSTANCE",					':INSTANCE' );


?>
