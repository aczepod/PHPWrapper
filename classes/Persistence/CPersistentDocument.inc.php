<?php

/*=======================================================================================
 *																						*
 *								CPersistentDocument.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CPersistentDocument} definitions.
 *
 *	This file contains common definitions used by the {@link CPersistentDocument} class.
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
 * Native unique identifier.
 *
 * This tag identifies the attribute that contains the native unique identifier.
 * This value is a full or hashed representation of the object's global unique identifier
 * ({@link kOFFSET_GID}) optimised specifically for the container in which the object will
 * be stored.
 */
define( "kOFFSET_NID",							'_id' );

?>
