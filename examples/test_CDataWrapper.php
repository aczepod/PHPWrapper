<?php
	
/**
 * {@link CDataWrapper.php Data} wrapper object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CDataWrapper class}.
 *
 *	@package	Test
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/12/2011
 *				2.00 22/02/2012
 */

/*=======================================================================================
 *																						*
 *									test_CDataWrapper.php								*
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
// Tags.
//
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tags.inc.php" );

//
// Parsers.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/parsing.php" );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.php" );


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', TRUE );


/*=======================================================================================
 *	TEST WRAPPER OBJECT																	*
 *======================================================================================*/
 
//
// Init local storage.
//
$url = 'http://localhost/mywrapper/MongoDataWrapper.php';

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
		echo( '<h4>Empty request</h4>' );
		//
		// Empty request.
		//
		$response = file_get_contents( $url );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $url ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test ping</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING) );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test ping with log request</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))) );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test ping with timers</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))) );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test help</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_HELP) );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test invalid operator</h4>' );
		//
		// Invalid operator.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.'XXX'),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))) );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test missing operator</h4>' );
		//
		// Missing operator.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))) );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		//
		// Display.
		//
		echo( kSTYLE_TABLE_PRE );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_ROW_PRE );
		echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	}
	
	echo( '<h4>Test database and container</h4>' );
	//
	// Ping wrapper.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode("TEST"))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode("TEST-CNT"))) );
	$request = implode( '&', $params );
	$request = "$url?$request";
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Test paging (missing limit)</h4>' );
	//
	// Ping wrapper.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))) );
	$request = implode( '&', $params );
	$request = "$url?$request";
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Test paging (missing start)</h4>' );
	//
	// Ping wrapper.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(1))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(120))) );
	$request = implode( '&', $params );
	$request = "$url?$request";
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Test paging (limit overflow)</h4>' );
	//
	// Ping wrapper.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(1000000))) );
	$request = implode( '&', $params );
	$request = "$url?$request";
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Parameters:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $params ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test count in JSON</h4>' );
	//
	// Test count in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_LID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => '10'
			)
		)
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(10))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($query))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test count in PHP</h4>' );
	//
	// Test count in PHP.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_LID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => '10'
			)
		)
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
					 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
					 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(serialize(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(serialize(10))),
					 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(serialize($query))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( unserialize( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test container count in JSON</h4>' );
	//
	// Test container count in JSON.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(10))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test query in JSON</h4>' );
	//
	// Test container query in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:2:'
			)
		)
	);
	$fields = array( kTAG_LID, kTAG_GID, '31' );
	$sort = array( kTAG_LID => -1 );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GET),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( TRUE )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($query))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode($fields))),
					 (kAPI_SORT.'='.urlencode(JsonEncode($sort))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test query in PHP</h4>' );
	//
	// Test container query in PHP.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:2:'
			)
		)
	);
	$fields = array( kTAG_LID, kTAG_GID, '31' );
	$sort = array( kTAG_LID => -1 );
	$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
					 (kAPI_OPERATION.'='.kAPI_OP_GET),
					 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(serialize(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(serialize(5))),
					 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( TRUE )))),
					 (kAPI_QUERY.'='.urlencode(serialize($query))),
					 (kAPI_SELECT.'='.urlencode(serialize($fields))),
					 (kAPI_SORT.'='.urlencode(serialize($sort))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( unserialize( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test query GetOne in JSON</h4>' );
	//
	// Test query GetOne in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:2:'
			)
		)
	);
	$fields = array( kTAG_LID, kTAG_GID, '31' );
	$sort = array( kTAG_LID => -1 );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GET_ONE),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($query))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode($fields))),
					 (kAPI_SORT.'='.urlencode(JsonEncode($sort))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test query Match in JSON</h4>' );
	//
	// Test container Match in JSON.
	//
	$queries = array
	(
		array
		(
			kOPERATOR_AND => array
			(
				array
				(
					kOFFSET_QUERY_SUBJECT => kTAG_GID,
					kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'NICODE'
				)
			)
		),
		array
		(
			kOPERATOR_AND => array
			(
				array
				(
					kOFFSET_QUERY_SUBJECT => kTAG_LID,
					kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'NICODE'
				)
			)
		),
		array
		(
			kOPERATOR_AND => array
			(
				array
				(
					kOFFSET_QUERY_SUBJECT => kTAG_SYNONYMS,
					kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'NICODE'
				)
			)
		)
	);
	$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
	$sort = array( kTAG_LID => -1 );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_MATCH),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($queries))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode($fields))),
					 (kAPI_SORT.'='.urlencode(JsonEncode($sort))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test INSERT array in JSON</h4>' );
	//
	// Test INSERT array in JSON.
	//
	$object = array
	(
		'Name' => 'Milko',
		'Surname' => 'Skofic'
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_INSERT),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode('test'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode($object))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	//
	// Save ID.
	//
	$id1 = JsonDecode( $response )[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];

	echo( '<h4>Check if object was written</h4>' );
	//
	// Check if object was written.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_MongoId,
				kOFFSET_QUERY_DATA => $id1
			)
		)
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GET_ONE),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode('test'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($query))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test INSERT object in JSON</h4>' );
	//
	// Test INSERT object in JSON.
	//
	$object = new CUser();
	$object->Code( 'code' );
	$object->Pass( 'pass' );
	$object->Name( 'Name' );
	$object->Mail( 'me@me.com' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_INSERT),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode(get_class($object)))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode($object))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	//
	// Save ID.
	//
	$id2 = JsonDecode( $response )[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];

	echo( '<h4>Check if object was written</h4>' );
	//
	// Check if object was written.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => $id2
			)
		)
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GET_ONE),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_users'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($query))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test delete selection</h4>' );
	//
	// Test delete selection.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_MongoId,
				kOFFSET_QUERY_DATA => $id1
			)
		)
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_DELETE),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_CONTAINER.'='.urlencode(JsonEncode('test'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode($query))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test resolve object</h4>' );
	//
	// Test delete selection.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_RESOLVE),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode('CUser'))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode($id2))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test delete object</h4>' );
	//
	// Test delete selection.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_DELETE),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
					 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode('CUser'))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode($id2))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( JsonDecode( $response ) ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
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
