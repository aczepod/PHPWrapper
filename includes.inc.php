<?php

/*=======================================================================================
 *																						*
 *									includes.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	User include file.
 *
 *	This file should be included at the top level of the application or web site as the
 *	first entry, it includes the file paths to the relevant directories and the autoload
 *	function for this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Skofic <m.skofic@cgiar.org>
 *	@version	1.00 31/08/2012
 */

/*=======================================================================================
 *	MYWRAPPER NAMESPACE ROOT															*
 *======================================================================================*/

/**
 * MyWrapper namespace root.
 *
 * This string indicates the root namespace name for this library.
 */
define( "kPATH_MYWRAPPER_NAMESPACE_ROOT",	"MyWrapper" );

/*=======================================================================================
 *	MYWRAPPER LIBRARY PATHS																*
 *======================================================================================*/

/**
 * MyWrapper class library root.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library root
 * directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_ROOT",		"/Library/WebServer/Library/MyWrapper" );

/**
 * MyWrapper class library definitions.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library
 * definitions directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_DEFINE",	"/Library/WebServer/Library/MyWrapper/defines" );

/**
 * MyWrapper class library sources.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library sources
 * directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_CLASS",	"/Library/WebServer/Library/MyWrapper/classes" );

/**
 * MyWrapper function library sources.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper function library
 * sources directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_FUNCTION",	"/Library/WebServer/Library/MyWrapper/functions" );

/*=======================================================================================
 *	CLASS AUTOLOADER																	*
 *======================================================================================*/

/**
 * This section allows automatic inclusion of the library classes.
 */
function MyAutoload( $theClassName )
{
	//
	// Separate namespace elements.
	//
	$namespaces = explode( '\\', $theClassName );
	
	//
	// Handle our classes.
	//
	if( (count( $namespaces ) > 1)								// Declared a namespace
	 && ($namespaces[ 0 ] == kPATH_MYWRAPPER_NAMESPACE_ROOT) )	// and corresponds.
	{
		//
		// Replace root namespace with class directory.
		//
		$namespaces[ 0 ] = kPATH_MYWRAPPER_LIBRARY_CLASS;
		
		//
		// Create path.
		//
		$path = implode( DIRECTORY_SEPARATOR, $namespaces ).'.php';
		
		//
		// Require class.
		//
		if( file_exists( $path ) )
			require_once( $path );
		
		//
		// Require whatever.
		//
		else
			require_once( $theClassName );
	
	} // This librarie's namespace.

} spl_autoload_register( 'MyAutoload' );

?>
