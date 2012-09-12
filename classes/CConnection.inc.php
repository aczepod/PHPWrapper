<?php

/*=======================================================================================
 *																						*
 *									CConnection.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CConnection} definitions.
 *
 *	This file contains common definitions used by the {@link CConnection} class.
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
 * Name.
 *
 * This tag identifies the object name, this value is dependent on the specific object
 * implementing it. This offset should be associated with an internal attribute of the
 * object rather than with a public one.
 */
define( "kOFFSET_NAME",							'_nam' );

/**
 * Parent.
 *
 * This tag identifies the parent reference, the eventual object that created the current
 * one.
 */
define( "kOFFSET_PARENT",						'_par' );

?>
