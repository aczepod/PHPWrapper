<?php

/*=======================================================================================
 *																						*
 *									includes.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Global include file.
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
 *	GRAPH DB SWITCH																		*
 *======================================================================================*/

/**
 * Graph database activator.
 *
 * If this switch is set on, it means that the library will make use of the graph database.
 */
define( "kGRAPH_DB",						FALSE );

/*=======================================================================================
 *	NAMESPACE ROOT																		*
 *======================================================================================*/

/**
 * MyWrapper namespace root.
 *
 * This string indicates the root namespace name for this library.
 */
define( "kPATH_MYWRAPPER_NAMESPACE_ROOT",	"MyWrapper" );

/*=======================================================================================
 *	LIBRARY PATHS																		*
 *======================================================================================*/

/**
 * MyWrapper class library root.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library root
 * directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_ROOT",		"/Library/WebServer/Library/PHPWrapper" );

/**
 * Neo4j library root.
 *
 * This value defines the <b><i>absolute</i></b> path to the Neo4j library directory.
 */
define( "kPATH_LIBRARY_NEO4J",				"/Library/WebServer/Library/Neo4jphp/" );

/*=======================================================================================
 *	LIBRARY SUB-PATHS																		*
 *======================================================================================*/

/**
 * MyWrapper class library definitions.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library
 * definitions directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_DEFINE",	kPATH_MYWRAPPER_LIBRARY_ROOT."/defines" );

/**
 * MyWrapper class library sources.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper class library sources
 * directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_CLASS",	kPATH_MYWRAPPER_LIBRARY_ROOT."/classes" );

/**
 * MyWrapper function library sources.
 *
 * This value defines the <b><i>absolute</i></b> path to the MyWrapper function library
 * sources directory.
 */
define( "kPATH_MYWRAPPER_LIBRARY_FUNCTION",	kPATH_MYWRAPPER_LIBRARY_ROOT."/functions" );

/*=======================================================================================
 *	SESSION GLOBALS																		*
 *======================================================================================*/

/**
 * Server instance.
 *
 * This tag identifies the session element that will hold the native server connection.
 */
define( "kSESSION_SERVER",					"@sr" );

/**
 * Database instance.
 *
 * This tag identifies the session element that will hold the native database connection.
 */
define( "kSESSION_DATABASE",				"@db" );

/**
 * Ontology instance.
 *
 * This tag identifies the session element that will hold the ontology instance.
 */
define( "kSESSION_ONTOLOGY",				"@on" );

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
	
	} // This librarie's namespace.
	
	//
	// Handle without namespaces.
	//
	else
		$path = kPATH_MYWRAPPER_LIBRARY_CLASS."/$theClassName.php";
		
	//
	// Require class.
	//
	if( file_exists( $path ) )
		require_once( $path );

} spl_autoload_register( 'MyAutoload' );

/*=======================================================================================
 *	GRAPG DB AUTOLOADER																	*
 *======================================================================================*/

/**
 * Autoloader.
 *
 * This section allows automatic inclusion of the library classes.
 *
 * @param string				$theClassName		name of class to load.
 */
function Neo4jAutoload( $theClassName )
{
	//
	// Build path.
	//
	$_path = kPATH_LIBRARY_NEO4J.'lib/'
			.str_replace( '\\', DIRECTORY_SEPARATOR, $theClassName )
			.'.php';
	
	//
	// Check file.
	//
	if( file_exists( $_path ) )
		require_once( $_path );

} spl_autoload_register( 'Neo4jAutoload' );

?>
