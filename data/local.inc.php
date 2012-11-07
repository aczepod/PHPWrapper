<?php

/*=======================================================================================
 *																						*
 *									local.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	Local include file.
 *
 *	This file should be included at the top level of the application or web site as the
 *	second entry, it includes the local definitions specific to the current site or
 *	application.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Skofic <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *	DEFAULT DEFINITIONS																	*
 *======================================================================================*/

/**
 * Default server.
 *
 * This tag indicates the default server URN.
 */
define( "kDEFAULT_SERVER",					"mongodb://localhost:27017" );

/**
 * Default database name.
 *
 * This tag indicates the default database name.
 */
define( "kDEFAULT_DATABASE",				"ONTOLOGY" );

/**
 * Default language.
 *
 * This tag indicates the default language code.
 */
define( "kDEFAULT_LANGUAGE",				"en" );

/**
 * Default page limit.
 *
 * This tag indicates the default page limit.
 */
define( "kDEFAULT_LIMIT",					50 );

/**
 * Default maximum page limit.
 *
 * This tag indicates the default maximum page limit.
 */
define( "kDEFAULT_MAX_LIMIT",				10000 );

/*=======================================================================================
 *	VERBOSE FLAG																		*
 *======================================================================================*/

/**
 * Verbnose flag.
 *
 * If set, the method will echo all created elements.
 */
define( "kOPTION_VERBOSE",					TRUE );

?>
