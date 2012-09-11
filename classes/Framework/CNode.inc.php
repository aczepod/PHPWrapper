<?php

/*=======================================================================================
 *																						*
 *									CNode.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CNode} definitions.
 *
 *	This file contains common definitions used by the {@link CNode} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Term reference.
 *
 * This tag identifies a reference to a term object, its value will be the native unique
 * identifier, {@link kOFFSET_NID}, of the referenced term.
 */
define( "kOFFSET_TERM",							'_trm' );

/**
 * Object kind.
 *
 * This tag identifies the object kind or type, the offset is a set of enumerations that
 * define the kind or specific type of an object, these enumerations will be in the form of
 * native unique identifiers, {@link kOFFSET_NID}, of the terms that define the enumeration.
 */
define( "kOFFSET_KIND",							'_knd' );

/**
 * Object data type.
 *
 * This tag identifies the object data type, the offset is an enumerated scalar that defines
 * the specific data type of an object, this value will be in the form of the native unique
 * identifier, {@link kOFFSET_NID}, of the term that defines the enumeration.
 */
define( "kOFFSET_TYPE",							'_typ' );

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
