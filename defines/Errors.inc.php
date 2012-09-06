<?php

/*=======================================================================================
 *																						*
 *										Errors.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Errors.
 *
 *	This file contains the common error codes used by all classes in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 02/09/2012
 */

/*=======================================================================================
 *	GENERAL ERRORS																		*
 *======================================================================================*/

/**
 * Idle.
 *
 * This code indicates successful operation or idle state.
 */
define( "kERROR_OK",						0 );			// Idle.

/**
 * Encode error.
 *
 * This code indicates an encoding error.
 */
define( "kERROR_ENCODE",					-1 );			// Encode error.

/**
 * Decode error.
 *
 * This code indicates a decoding error.
 */
define( "kERROR_DECODE",					-2 );			// Decode error.

/**
 * Unsupported.
 *
 * This code indicates an unsupported operation.
 */
define( "kERROR_UNSUPPORTED",				-3 );			// Unsupported.

/**
 * Invalid parameter.
 *
 * This code indicates an invalid parameter.
 */
define( "kERROR_PARAMETER",					-4 );			// Invalid parameter.

/**
 * Invalid state.
 *
 * This code indicates an invalid state for the object.
 */
define( "kERROR_STATE",						-5 );			// Invalid state.

/**
 * Unable to commit.
 *
 * This code indicates a commit error.
 */
define( "kERROR_COMMIT",					-6 );			// Unable to commit.

/**
 * Not found.
 *
 * This code indicates failure to locate an object in a container.
 */
define( "kERROR_NOT_FOUND",					-7 );			// Not found.

/**
 * Missing.
 *
 * This code indicates a missing parameter.
 */
define( "kERROR_MISSING",					-8 );			// Missing.

/**
 * Locked.
 *
 * This code indicates the attempt to modify a locked resource.
 */
define( "kERROR_LOCKED",					-9 );			// Locked.


?>
