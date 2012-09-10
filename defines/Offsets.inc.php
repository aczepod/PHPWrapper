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
 * Native unique identifier.
 *
 * This tag identifies the attribute that contains the native unique identifier.
 * This value is a full or hashed representation of the object's global unique identifier
 * ({@link kOFFSET_GID}) optimised specifically for the container in which the object will
 * be stored.
 */
define( "kOFFSET_NID",							'_id' );

/**
 * Global unique identifier.
 *
 * This tag identifies the attribute that contains the global or full unique identifier.
 * This value will constitute the object's native key ({@link kOFFSET_NID}) in full or
 * hashed format.
 */
define( "kOFFSET_GID",							'_gid' );

/**
 * Local unique identifier.
 *
 * This tag identifies the attribute that contains the local or full unique identifier.
 * This value represents the identifier that uniquely identifies an object within a specific
 * domain or namespace. It is by default a string constituting a portion of the global
 * unique identifier, {@link kOFFSET_GID}.
 */
define( "kOFFSET_LID",							'_lid' );

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
define( "kOFFSET_CLASS",						'_cls' );

/**
 * Namespace.
 *
 * This tag is used as the offset for a namespace. By default this attribute contains the
 * native unique identifier, {@link kOFFSET_NID}, of the namespace object; if you want to
 * refer to the namespace code, this is not the offset to use.
 */
define( "kOFFSET_NAMESPACE",					'_nsp' );

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

/**
 * Namespace references.
 *
 * This tag identifies namespace references, the attribute contains the count of how many
 * times the term was referenced as a namespace.
 */
define( "kOFFSET_REFS_NAMESPACE",				'_nsr' );

/**
 * Node references.
 *
 * This tag identifies node references, the attribute contains the list of identifiers of
 * nodes that reference the current object.
 */
define( "kOFFSET_REFS_NODE",					'_nor' );

/**
 * Tag references.
 *
 * This tag identifies tag references, the attribute contains the list of identifiers of
 * tags that reference the current term.
 */
define( "kOFFSET_REFS_TAG",						'_tgr' );

?>
