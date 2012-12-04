<?php
	
/**
 * {@link COntologyWrapperClient.php Wrapper} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link COntologyWrapperClient class}.
 *
 *	@package	Test
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 14/11/2012
 */

/*=======================================================================================
 *																						*
 *								test_COntologyWrapperClient.php							*
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
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyWrapperClient.php" );


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
$url = 'http://localhost/mywrapper/MongoOntologyWrapper.php';

//
// TRY BLOCK.
//
try
{
	//
	// Parent debug.
	//
	if( kDEBUG_PARENT )
	{
		echo( '<h4>Instantiate</h4>' );
		//
		// Build object.
		//
		$test = new COntologyWrapperClient( $url );
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
		echo( '<i>$decoded = COntologyWrapperClient::Request( $url, $params, \'POST\', kTYPE_JSON );</i><br>' );
		$decoded = COntologyWrapperClient::Request( $url, $params, 'POST', kTYPE_JSON );
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
		echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
		$test = new COntologyWrapperClient( $url );
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
		echo( '<i>$test = new COntologyWrapperClient();</i><br>' );
		$test = new COntologyWrapperClient();
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
		echo( '<i>$test = new COntologyWrapperClient();</i><br>' );
		$test = new COntologyWrapperClient();
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
		echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
		$test = new COntologyWrapperClient( $url );
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
		echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
		$test = new COntologyWrapperClient( $url );
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
		echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
		$test = new COntologyWrapperClient( $url );
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
		
		echo( '<h4>Test container MATCH in JSON</h4>' );
		//
		// Instantiate.
		//
		echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
		$test = new COntologyWrapperClient( $url );
		echo( '<i>$test->Operation( kAPI_OP_MATCH );</i><br>' );
		$test->Operation( kAPI_OP_MATCH );
		echo( '<i>$test->Format( kTYPE_JSON );</i><br>' );
		$test->Format( kTYPE_JSON );
		echo( '<i>$test->Database( "ONTOLOGY" );</i><br>' );
		$test->Database( "ONTOLOGY" );
		echo( '<i>$test->Container( "_terms" );</i><br>' );
		$test->Container( "_terms" );
		echo( '<i>$test->AddQueryListStatement( "A", kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "IT-XXX" );</i><br>' );
		$test->AddQueryListStatement( "A", kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "IT-XXX" );
		echo( '<i>$test->AddQueryListStatement( "B", kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "IT-ZZZ" );</i><br>' );
		$test->AddQueryListStatement( "B", kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "IT-ZZZ" );
		echo( '<i>$test->AddQueryListStatement( "C", kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "IT-82" );</i><br>' );
		$test->AddQueryListStatement( "C", kOPERATOR_AND, kTAG_LID, kOPERATOR_EQUAL, "IT-82" );
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
		echo( '<hr>' );
	}
	
	echo( '<h4>Test root GetVertex list</h4>' );
	//
	// Instantiate.
	//
	echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
	$test = new COntologyWrapperClient( $url );
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
	echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
	$test = new COntologyWrapperClient( $url );
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
	echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
	$test = new COntologyWrapperClient( $url );
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
	echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
	$test = new COntologyWrapperClient( $url );
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
	echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
	$test = new COntologyWrapperClient( $url );
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
	echo( '<i>$test = new COntologyWrapperClient( $url );</i><br>' );
	$test = new COntologyWrapperClient( $url );
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
