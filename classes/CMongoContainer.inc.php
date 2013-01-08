<?php

/*=======================================================================================
 *																						*
 *								CMongoContainer.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CMongoContainer} definitions.
 *
 *	This file contains common definitions used by the {@link CMongoContainer} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 07/01/2013
 */

/*=======================================================================================
 *	DEFAULT MONGO ENVIRONMENT SETTINGS													*
 *======================================================================================*/

/**
 * WriteConcern.
 *
 * MongoDB provides several different ways of selecting how durable a write to the database
 * should be. These ways are called Write Concerns and span everything from completely
 * ignoring all errors, to specifically targetting which servers are required to confirm the
 * write before returning the operation.
 *
 * This define indicates the default value for write operations.
 */
define( "kMONGO_WRITE_CONCERN",		1 );


?>
