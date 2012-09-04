<?php

/*=======================================================================================
 *																						*
 *										Offsets.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Default offsets.
 *
 *	This file contains the common error codes used by all classes in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Local unique identifier.
 *
 * This tag identifies the attribute that contains the local or native unique identifier.
 * This value is a full or hashed representation of the object's global unique identifier
 * ({@link kTAG_GID}).
 */
define( "kTAG_LID",								'_id' );

/**
 * Global unique identifier.
 *
 * This tag identifies the attribute that contains the global or full unique identifier.
 * This value will constitute the object's local or native key ({@link kTAG_LID}) in full or
 * hashed format.
 */
define( "kTAG_GID",								'_ix' );

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
define( "kTAG_CLASS",							'_class' );

?>
