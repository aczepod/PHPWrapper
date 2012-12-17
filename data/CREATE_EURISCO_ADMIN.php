<?php

/**
 * Create admin user of EURISCO.
 *
 *	@package	Test
 *	@subpackage	Users
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 17/12/2012
 */

/*=======================================================================================
 *																						*
 *								CREATE_EURISCO_ADMIN.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CUser.php" );


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Create container.
	//
	$server = New CMongoServer();
	$database = $server->Database( "EURISCO" );
//	$database->Drop();
	
	//
	// Save user.
	//
	$user = new CUser();
	$user->Name( "System Administrator" );
	$user->Code( "admin" );
	$user->Pass( "nimda" );
	$user->Mail( "m.skofic@cgiar.org" );
	$user->Role( "ROLE_ADMIN" );
	$status = $user->Insert( $database );
}

//
// Catch exceptions.
//
catch( \Exception $error )
{
	echo( (string) $error );
}

echo( "\nDone!\n" );

?>
