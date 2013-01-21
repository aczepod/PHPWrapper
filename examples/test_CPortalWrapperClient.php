<?php
	
/**
 * {@link CPortalWrapperClient.php Wrapper} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CPortalWrapperClient class}.
 *
 *	@package	Test
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/12/2012
 */

/*=======================================================================================
 *																						*
 *								test_CPortalWrapperClient.php							*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Local includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/data/local.inc.php' );

//
// Style includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/styles.inc.php' );

//
// Predicates.
//
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Predicates.inc.php" );

//
// Parsers.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/parsing.php" );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPortalWrapperClient.php" );


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', FALSE );


/*=======================================================================================
 *	TEST WRAPPER OBJECT																	*
 *======================================================================================*/
 
//
// Init local storage.
//
$url = 'http://localhost/mywrapper/MongoPortalWrapper.php';

//
// TRY BLOCK.
//
try
{
	//
	// Create container.
	//
	echo( '<hr />' );
	echo( '<h4>Create test container</h4>' );
	echo( '$server = new CMongoServer();<br />' );
	$server = New CMongoServer();
	echo( '$database = $server->Database( "TEST" );<br />' );
	$database = $server->Database( "TEST" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Parent debug.
	//
	if( kDEBUG_PARENT )
	{
		echo( '<h4>Instantiate</h4>' );
		//
		// Build object.
		//
		$test = new CDataWrapperClient( $url );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $url ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		echo( '<hr>' );
		
		echo( '<h4>Test static method</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( kAPI_FORMAT => kTYPE_JSON, kAPI_OPERATION => kAPI_OP_PING );
		echo( '<i>$decoded = CDataWrapperClient::Request( $url, $params, \'POST\', kTYPE_JSON );</i><br>' );
		$decoded = CDataWrapperClient::Request( $url, $params, 'POST', kTYPE_JSON );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		echo( '<hr>' );
		
		echo( '<h4>Test public method</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_PING );</i><br>' );
		$test->Operation( kAPI_OP_PING );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$decoded = $test->Execute( \'GET\' );</i><br>' );
		$decoded = $test->Execute( 'GET' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test help in POST</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient();</i><br>' );
		$test = new CDataWrapperClient();
		echo( '<i>$test->Connection( $url );</i><br>' );
		$test->Connection( $url );
		echo( '<i>$test->Operation( kAPI_OP_HELP );</i><br>' );
		$test->Operation( kAPI_OP_HELP );
		echo( '<i>$test->Format( kTYPE_PHP );</i><br>' );
		$test->Format( kTYPE_PHP );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test ping with timers</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient();</i><br>' );
		$test = new CDataWrapperClient();
		echo( '<i>$test->Connection( $url );</i><br>' );
		$test->Connection( $url );
		echo( '<i>$test->Operation( kAPI_OP_PING );</i><br>' );
		$test->Operation( kAPI_OP_PING );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Stamp( TRUE );</i><br>' );
		$test->Stamp( TRUE );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test invalid operation</h4>' );
		//
		// Invalid operation.
		//
		try
		{
			echo( '<i>$test->Operation( "XXX" );</i><br>' );
			$test->Operation( "XXX" );
		}
		catch( Exception $error )
		{
			echo( CException::AsHTML( $error ) );
		}
		echo( '<hr>' );
		
		echo( '<h4>Test invalid format</h4>' );
		//
		// Invalid format.
		//
		try
		{
			echo( '<i>$test->Format( "XXX" );</i><br>' );
			$test->Format( "XXX" );
		}
		catch( Exception $error )
		{
			echo( CException::AsHTML( $error ) );
		}
		echo( '<hr>' );
		
		echo( '<h4>Test missing element</h4>' );
		//
		// Missing element.
		//
		try
		{
			echo( '<i>$test->Format( FALSE );</i><br>' );
			$test->Format( FALSE );
			//
			// Display.
			//
			echo( kSTYLE_TABLE_PRE );
			echo( kSTYLE_ROW_PRE );
			echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
			echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
			echo( kSTYLE_ROW_POS );
			echo( kSTYLE_TABLE_POS );
			//
			// Execute.
			//
			echo( '<i>$decoded = $test->Execute();</i><br>' );
			$decoded = $test->Execute();
		}
		catch( Exception $error )
		{
			echo( CException::AsHTML( $error ) );
		}
		echo( '<hr>' );
		
		echo( '<h4>Test client debug</h4>' );
		//
		// Client debug.
		//
		try
		{
			echo( '<i>$test->Connection( $url );</i><br>' );
			$test->Connection( $url );
			//
			// Execute.
			//
			echo( '<i>$test->Format( kTYPE_META );</i><br>' );
			$test->Format( kTYPE_META );
			//
			// Execute.
			//
			echo( '<i>$decoded = $test->Execute();</i><br>' );
			$decoded = $test->Execute();
			//
			// Display.
			//
			echo( kSTYLE_TABLE_PRE );
			echo( kSTYLE_ROW_PRE );
			echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
			echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
			echo( kSTYLE_ROW_POS );
			echo( kSTYLE_ROW_PRE );
			echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
			echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
			echo( kSTYLE_ROW_POS );
			echo( kSTYLE_TABLE_POS );
		}
		catch( Exception $error )
		{
			echo( CException::AsHTML( $error ) );
		}
		echo( '<hr>' );
		echo( '<hr>' );
	
		echo( '<h4>Test container count in JSON</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_COUNT );</i><br>' );
		$test->Operation( kAPI_OP_COUNT );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Container( "_terms" );</i><br>' );
		$test->Container( "_terms" );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test container GET in JSON</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GET );</i><br>' );
		$test->Operation( kAPI_OP_GET );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Container( "_terms" );</i><br>' );
		$test->Container( "_terms" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_LID, kOPERATOR_PREFIX, "IT-" );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_LID, kOPERATOR_PREFIX, "IT-" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, "31", kOPERATOR_LIKE, "region" );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, "31", kOPERATOR_LIKE, "region" );
		echo( '<i>$test->Select( kTAG_LID );</i><br>' );
		$test->Select( kTAG_LID );
		echo( '<i>$test->Select( kTAG_GID );</i><br>' );
		$test->Select( kTAG_GID );
		echo( '<i>$test->Select( "31" );</i><br>' );
		$test->Select( "31" );
		echo( '<i>$test->Sort( kTAG_LID, -1 );</i><br>' );
		$test->Sort( kTAG_LID, -1 );
		echo( '<i>$test->Sort( kTAG_GID, 1 );</i><br>' );
		$test->Sort( kTAG_GID, 1 );
		echo( '<i>$test->PageLimit( 5 );</i><br>' );
		$test->PageLimit( 5  );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test container GET ONE in JSON</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GET_ONE );</i><br>' );
		$test->Operation( kAPI_OP_GET_ONE );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Container( "_terms" );</i><br>' );
		$test->Container( "_terms" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "date_withdrawn" );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "date_withdrawn" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_GID, kOPERATOR_PREFIX_NOCASE, "iso" );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_GID, kOPERATOR_PREFIX_NOCASE, "iso" );
		echo( '<i>$test->Select( array( kTAG_LID, kTAG_GID ) );</i><br>' );
		$test->Select( array( kTAG_LID, kTAG_GID ) );
		echo( '<i>$test->Sort( kTAG_LID, -1 );</i><br>' );
		$test->Sort( kTAG_LID, -1 );
		echo( '<i>$test->Sort( kTAG_GID, 1 );</i><br>' );
		$test->Sort( kTAG_GID, 1 );
		echo( '<i>$test->PageLimit( 5 );</i><br>' );
		$test->PageLimit( 5  );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test INSERT array in JSON</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_INSERT );</i><br>' );
		$test->Operation( kAPI_OP_INSERT );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "TEST" );</i><br>' );
		$test->Database( "TEST" );
		echo( '<i>$test->Container( "test" );</i><br>' );
		$test->Container( "test" );
		echo( '<i>$test->Stamp( TRUE );</i><br>' );
		$test->Stamp( TRUE );
		echo( '<i>$test->LogRequest( TRUE );</i><br>' );
		$test->LogRequest( TRUE );
		echo( '<i>$test->Object( array( "Name" => "Milko", "Surname" => "Skofic" ) );</i><br>' );
		$test->Object( array( "Name" => "Milko", "Surname" => "Skofic" ) );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		//
		// Save ID.
		//
		$id1 = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	
		echo( '<h4>Check if object was written</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GET_ONE );</i><br>' );
		$test->Operation( kAPI_OP_GET_ONE );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "TEST" );</i><br>' );
		$test->Database( "TEST" );
		echo( '<i>$test->Container( "test" );</i><br>' );
		$test->Container( "test" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_NID, kOPERATOR_EQUAL, $id1, kTYPE_MongoId );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_NID, kOPERATOR_EQUAL, $id1, kTYPE_MongoId );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test INSERT object in JSON</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$object = new CUser();</i><br>' );
		$object = new CUser();
		echo( '<i>$object->Code( "code" );</i><br>' );
		$object->Code( "code" );
		echo( '<i>$object->Pass( "pass" );</i><br>' );
		$object->Pass( "pass" );
		echo( '<i>$object->Name( "Name" );</i><br>' );
		$object->Name( "Name" );
		echo( '<i>$object->Mail( "me@me.com" );</i><br>' );
		$object->Mail( "me@me.com" );
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_INSERT );</i><br>' );
		$test->Operation( kAPI_OP_INSERT );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "TEST" );</i><br>' );
		$test->Database( "TEST" );
		echo( '<i>$test->Stamp( TRUE );</i><br>' );
		$test->Stamp( TRUE );
		echo( '<i>$test->LogRequest( TRUE );</i><br>' );
		$test->LogRequest( TRUE );
		echo( '<i>$test->Object( $object );</i><br>' );
		$test->Object( $object );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		//
		// Save ID.
		//
		$id2 = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	
		echo( '<h4>Check if object was written</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GET_ONE );</i><br>' );
		$test->Operation( kAPI_OP_GET_ONE );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "TEST" );</i><br>' );
		$test->Database( "TEST" );
		echo( '<i>$test->Container( ":_users" );</i><br>' );
		$test->Container( ":_users" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_NID, kOPERATOR_EQUAL, $id2, kTYPE_STRING );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_NID, kOPERATOR_EQUAL, $id2, kTYPE_STRING );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test delete selection</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_DELETE );</i><br>' );
		$test->Operation( kAPI_OP_DELETE );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "TEST" );</i><br>' );
		$test->Database( "TEST" );
		echo( '<i>$test->Container( "test" );</i><br>' );
		$test->Container( "test" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_NID, kOPERATOR_EQUAL, $id1, kTYPE_MongoId );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_NID, kOPERATOR_EQUAL, $id1, kTYPE_MongoId );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test delete object</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CDataWrapperClient( $url );</i><br>' );
		$test = new CDataWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_DELETE );</i><br>' );
		$test->Operation( kAPI_OP_DELETE );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "TEST" );</i><br>' );
		$test->Database( "TEST" );
		echo( '<i>$test->Classname( "CUser" );</i><br>' );
		$test->Classname( "CUser" );
		echo( '<i>$test->Object( $id2 );</i><br>' );
		$test->Object( $id2 );
		echo( '<i>$decoded = $test->Execute( \'POST\' );</i><br>' );
		$decoded = $test->Execute( 'POST' );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test root GetVertex list</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
		$test = new CPortalWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GetVertex );</i><br>' );
		$test->Operation( kAPI_OP_GetVertex );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->AddQueryStatement( kOPERATOR_AND, kTAG_KIND, kOPERATOR_EQUAL, kKIND_ROOT );</i><br>' );
		$test->AddQueryStatement( kOPERATOR_AND, kTAG_KIND, kOPERATOR_EQUAL, kKIND_ROOT );
		echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
		$decoded = $test->Execute( "POST" );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test GetVertex by ID</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
		$test = new CPortalWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GetVertex );</i><br>' );
		$test->Operation( kAPI_OP_GetVertex );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Query( 1 );</i><br>' );
		$test->Query( 1 );
		echo( '<i>$test->Select( kTAG_GID );</i><br>' );
		$test->Select( kTAG_GID );
		echo( '<i>$test->Select( kTAG_LABEL );</i><br>' );
		$test->Select( kTAG_LABEL );
		echo( '<i>$test->Relations( kAPI_RELATION_OUT );</i><br>' );
		echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
		$decoded = $test->Execute( "POST" );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		echo( '<hr>' );
	
		echo( '<h4>Test GetVertex incoming relationships</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
		$test = new CPortalWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GetVertex );</i><br>' );
		$test->Operation( kAPI_OP_GetVertex );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Query( 5 );</i><br>' );
		$test->Query( 5 );
		echo( '<i>$test->Select( kTAG_GID );</i><br>' );
		$test->Select( kTAG_GID );
		echo( '<i>$test->Select( kTAG_KIND );</i><br>' );
		$test->Select( kTAG_KIND );
		echo( '<i>$test->Select( kTAG_TYPE );</i><br>' );
		$test->Select( kTAG_TYPE );
		echo( '<i>$test->Relations( kAPI_RELATION_IN );</i><br>' );
		$test->Relations( kAPI_RELATION_IN );
		echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
		$decoded = $test->Execute( "POST" );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test GetVertex outgoing relationships</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
		$test = new CPortalWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GetVertex );</i><br>' );
		$test->Operation( kAPI_OP_GetVertex );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Query( 5 );</i><br>' );
		$test->Query( 5 );
		echo( '<i>$test->Select( kTAG_GID );</i><br>' );
		$test->Select( kTAG_GID );
		echo( '<i>$test->Select( kTAG_KIND );</i><br>' );
		$test->Select( kTAG_KIND );
		echo( '<i>$test->Select( kTAG_TYPE );</i><br>' );
		$test->Select( kTAG_TYPE );
		echo( '<i>$test->Relations( kAPI_RELATION_OUT );</i><br>' );
		$test->Relations( kAPI_RELATION_OUT );
		echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
		$decoded = $test->Execute( "POST" );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test GetVertex relationships</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
		$test = new CPortalWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GetVertex );</i><br>' );
		$test->Operation( kAPI_OP_GetVertex );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Query( 116 );</i><br>' );
		$test->Query( 116 );
		echo( '<i>$test->Select( kTAG_GID );</i><br>' );
		$test->Select( kTAG_GID );
		echo( '<i>$test->Select( kTAG_KIND );</i><br>' );
		$test->Select( kTAG_KIND );
		echo( '<i>$test->Select( kTAG_TYPE );</i><br>' );
		$test->Select( kTAG_TYPE );
		echo( '<i>$test->Relations( kAPI_RELATION_ALL );</i><br>' );
		$test->Relations( kAPI_RELATION_ALL );
		echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
		$decoded = $test->Execute( "POST" );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		echo( '<hr>' );
	
		echo( '<h4>Test GetVertex subclass-of relationships</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
		$test = new CPortalWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_GetVertex );</i><br>' );
		$test->Operation( kAPI_OP_GetVertex );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Query( 116 );</i><br>' );
		$test->Query( 116 );
		echo( '<i>$test->Select( kTAG_GID );</i><br>' );
		$test->Select( kTAG_GID );
		echo( '<i>$test->Select( kTAG_KIND );</i><br>' );
		$test->Select( kTAG_KIND );
		echo( '<i>$test->Select( kTAG_TYPE );</i><br>' );
		$test->Select( kTAG_TYPE );
		echo( '<i>$test->Predicate( kPREDICATE_SUBCLASS_OF );</i><br>' );
		$test->Predicate( kPREDICATE_SUBCLASS_OF );
		echo( '<i>$test->Relations( kAPI_RELATION_ALL );</i><br>' );
		$test->Relations( kAPI_RELATION_ALL );
		echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
		$decoded = $test->Execute( "POST" );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		echo( '<hr>' );
	}

	echo( '<h4>Test login with invalid credentials structure</h4>' );
	//
	// Instantiate.
	//
	echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
	$test = new CPortalWrapperClient( $url );
	echo( '<i>$test->Operation( kAPI_OP_Login );</i><br>' );
	$test->Operation( kAPI_OP_Login );
	echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
	$test->Format( kTYPE_JSON );
	echo( '<i>$test->Database( "TEST" );</i><br>' );
	$test->Database( "TEST" );
	echo( '<i>$test->Credentials( "xxx", "xxx" );</i><br>' );
	$test->Credentials( "xxx", "xxx" );
	echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
	$decoded = $test->Execute( "POST" );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test login with unknown credentials</h4>' );
	//
	// Instantiate.
	//
	echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
	$test = new CPortalWrapperClient( $url );
	echo( '<i>$test->Operation( kAPI_OP_Login );</i><br>' );
	$test->Operation( kAPI_OP_Login );
	echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
	$test->Format( kTYPE_JSON );
	echo( '<i>$test->Database( "TEST" );</i><br>' );
	$test->Database( "TEST" );
	echo( '<i>$test->Credentials( kAPI_CREDENTIALS_CODE, "xxx" );</i><br>' );
	$test->Credentials( kAPI_CREDENTIALS_CODE, "xxx" );
	echo( '<i>$test->Credentials( kAPI_CREDENTIALS_PASS, "xxx" );</i><br>' );
	$test->Credentials( kAPI_CREDENTIALS_PASS, "xxx" );
	echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
	$decoded = $test->Execute( "POST" );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test successful login</h4>' );
	$user = new CUser();
	$user->Name( "Ungabunga" );
	$user->Code( "USER" );
	$user->Pass( "PASS" );
	$user->Mail( "u.bunga@cgiar.org" );
	$user->Profile( "DATASET" );
	$user->Profile( "CURATE" );
	$user->Insert( $database );
	//
	// Instantiate.
	//
	echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
	$test = new CPortalWrapperClient( $url );
	echo( '<i>$test->Operation( kAPI_OP_Login );</i><br>' );
	$test->Operation( kAPI_OP_Login );
	echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
	$test->Format( kTYPE_JSON );
	echo( '<i>$test->Database( "TEST" );</i><br>' );
	$test->Database( "TEST" );
	echo( '<i>$test->Credentials( kAPI_CREDENTIALS_CODE, $user->Code() );</i><br>' );
	$test->Credentials( kAPI_CREDENTIALS_CODE, $user->Code() );
	echo( '<i>$test->Credentials( kAPI_CREDENTIALS_PASS, $user->Pass() );</i><br>' );
	$test->Credentials( kAPI_CREDENTIALS_PASS, $user->Pass() );
	echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
	$decoded = $test->Execute( "POST" );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	echo( '<hr>' );

	echo( '<h4>Test successful new user</h4>' );
	$user = Array();
	$user[ kTAG_USER_NAME ] = "New user";
	$user[ kTAG_USER_CODE ] = "NEW";
	$user[ kTAG_USER_PASS ] = "password";
	$user[ kTAG_USER_MAIL ] = "new@me.com";
	$user[ kTAG_USER_ROLE ] = "ROLE";
	$user[ kTAG_USER_PROFILE ] = array( 'PROFILE1', 'PROFILE2', 'PROFILE1' );
	$user[ kTAG_USER_DOMAIN ] = "TEST";
	$user[ kTAG_USER_MANAGER ] = "USER";
	//
	// Instantiate.
	//
	echo( '<i>$test = new CPortalWrapperClient( $url );</i><br>' );
	$test = new CPortalWrapperClient( $url );
	echo( '<i>$test->Operation( kAPI_OP_NewUser );</i><br>' );
	$test->Operation( kAPI_OP_NewUser );
	echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
	$test->Format( kTYPE_JSON );
	echo( '<i>$test->Database( "TEST" );</i><br>' );
	$test->Database( "TEST" );
	echo( '<i>$test->Object( $user );</i><br>' );
	$test->Object( $user );
	echo( '<i>$decoded = $test->Execute( "POST" );</i><br>' );
	$decoded = $test->Execute( "POST" );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Client:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $test ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	echo( '<hr>' );
	
	echo( '<h3>DONE</h3>' );
}
catch( Exception $error )
{
	echo( '<h3>Unexpected exception</h3>' );
	echo( CException::AsHTML( $error ) );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}


?>
