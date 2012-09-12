<?php

/*=======================================================================================
 *																						*
 *								CPersistentObject.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CPersistentObject} definitions.
 *
 *	This file contains common definitions used by the {@link CPersistentObject} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Global unique identifier.
 *
 * This tag identifies the attribute that contains the global or full unique identifier.
 * This value will constitute the object's native key ({@link kOFFSET_NID}) in full or
 * hashed format.
 */
define( "kOFFSET_GID",							'_gid' );

/**
 * Unique identifier.
 *
 * This tag identifies the attribute that contains the unique identifier. This offset is
 * the hashed value of {@link kOFFSET_GID} and is generally set as a unique key. It is
 * used when the native identifier is not dependent on the global identifier, such as with
 * sequences. It is useful to detect duplicate records.
 */
define( "kOFFSET_UID",							'_uid' );

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
define( "kOFFSET_CLASS",						'_cls' );

?>
