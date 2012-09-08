<?php

/*=======================================================================================
 *																						*
 *									Offsets.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	Default common offsets.
 *
 *	This file contains the common offsets shared by several classes in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 *				1.05 08/09/2012
 */

/*=======================================================================================
 *	DEFAULT COMMON OFFSETS																*
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

/**
 * Name.
 *
 * This tag identifies the object name, this value is dependent on the specific object
 * implementing it. This offset should be associated with an internal attribute of the
 * object rather than with a public one.
 */
define( "kOFFSET_NAME",							'_nam' );

?>
