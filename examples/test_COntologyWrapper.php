<?php
	
/**
 * {@link CMongoOntologyWrapper.php Data} wrapper object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoOntologyWrapper class}.
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
 *								test_COntologyWrapper.php								*
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
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyWrapper.php" );


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
		echo( '<hr>' );
	
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
		echo( '<hr>' );

		echo( '<h4>Test COUNT in JSON</h4>' );
		//
		// Test COUNT in JSON.
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

		echo( '<h4>Test COUNT in PHP</h4>' );
		//
		// Test COUNT in PHP.
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

		echo( '<h4>Test COUNT distinct in JSON</h4>' );
		//
		// Test COUNT distinct in JSON.
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
		$distinct = kTAG_LABEL.'.en';
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
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

		echo( '<h4>Test COUNT distinct list in JSON</h4>' );
		//
		// Test COUNT distinct list in JSON.
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
		$distinct = array( '1', '2' );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
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

		echo( '<h4>Test COUNT MATCH in PHP</h4>' );
		//
		// Test COUNT MATCH in PHP.
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
					)
				)
			)
		);
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( true )))),
						 (kAPI_QUERY.'='.urlencode(serialize($queries))) );
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

		echo( '<h4>Test COUNT MATCH distinct in PHP</h4>' );
		//
		// Test COUNT MATCH distinct in PHP.
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
					)
				)
			)
		);
		$distinct = '2';
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( true )))),
						 (kAPI_DISTINCT.'='.urlencode(serialize($distinct))),
						 (kAPI_QUERY.'='.urlencode(serialize($queries))) );
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

		echo( '<h4>Test COUNT MATCH distinct list in JSON</h4>' );
		//
		// Test COUNT MATCH distinct list in JSON.
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
					)
				)
			)
		);
		$distinct = array( '1', '2' );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
						 (kAPI_QUERY.'='.urlencode(JsonEncode($queries))) );
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

		echo( '<h4>Test COUNT container in JSON</h4>' );
		//
		// Test COUNT container in JSON.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
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

		echo( '<h4>Test COUNT container distinct in JSON</h4>' );
		//
		// Test COUNT container distinct in JSON.
		//
		$distinct = kTAG_NAMESPACE;
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
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

		echo( '<h4>Test COUNT container distinct list in JSON</h4>' );
		//
		// Test COUNT container distinct list in JSON.
		//
		$distinct = array( kTAG_GID, kTAG_LID, kTAG_NAMESPACE ) ;
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
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
		echo( '<hr>' );

		echo( '<h4>Test GET in JSON</h4>' );
		//
		// Test container GET in JSON.
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
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
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

		echo( '<h4>Test GET in PHP</h4>' );
		//
		// Test container GET in PHP.
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
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
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

		echo( '<h4>Test GET distinct in JSON</h4>' );
		//
		// Test GET distinct in JSON.
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
		$distinct = kTAG_LABEL.'.en';
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( TRUE )))),
						 (kAPI_QUERY.'='.urlencode(JsonEncode($query))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))) );
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

		echo( '<h4>Test GET distinct list in JSON</h4>' );
		//
		// Test GET distinct list in JSON.
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
		$distinct = array( kTAG_LABEL.'.en', kTAG_SYNONYMS );
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( TRUE )))),
						 (kAPI_QUERY.'='.urlencode(JsonEncode($query))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))) );
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

		echo( '<h4>Test GET MATCH in PHP</h4>' );
		//
		// Test GET MATCH in PHP.
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
					)
				)
			)
		);
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(serialize(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(serialize(5))),
						 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( TRUE )))),
						 (kAPI_QUERY.'='.urlencode(serialize($queries))),
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

		echo( '<h4>Test GET MATCH distinct in PHP</h4>' );
		//
		// Test GET MATCH distinct in PHP.
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
					)
				)
			)
		);
		$distinct = '2';
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(serialize(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(serialize(5))),
						 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( TRUE )))),
						 (kAPI_DISTINCT.'='.urlencode(serialize($distinct))),
						 (kAPI_QUERY.'='.urlencode(serialize($queries))),
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

		echo( '<h4>Test GET MATCH distinct list in PHP</h4>' );
		//
		// Test GET MATCH distinct list in PHP.
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
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
						kOFFSET_QUERY_DATA => 'INSTCODE'
					)
				)
			)
		);
		$distinct = array( '10.en', '2' );
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(serialize(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(serialize(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(serialize(5))),
						 (kAPI_DATABASE.'='.urlencode(serialize('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(serialize(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(serialize(gettimeofday( TRUE )))),
						 (kAPI_DISTINCT.'='.urlencode(serialize($distinct))),
						 (kAPI_QUERY.'='.urlencode(serialize($queries))),
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

		echo( '<h4>Test GET container in JSON</h4>' );
		//
		// Test GET container in JSON.
		//
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$sort = array( kTAG_LABEL.'.en' => 1 );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( TRUE )))),
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

		echo( '<h4>Test GET container distinct in JSON</h4>' );
		//
		// Test GET container distinct in JSON.
		//
		$distinct = kTAG_LABEL.'.en';
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
						 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( TRUE )))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
						 (kAPI_SELECT.'='.urlencode(JsonEncode($fields))) );
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

		echo( '<h4>Test GET container distinct list in JSON</h4>' );
		//
		// Test GET container distinct list in JSON.
		//
		$distinct = array( kTAG_GID, kTAG_LID, kTAG_LABEL.'.en' );
		$fields = array( kTAG_LID, kTAG_GID, kTAG_LABEL );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
	//					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
	//					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( TRUE )))),
						 (kAPI_DISTINCT.'='.urlencode(JsonEncode($distinct))),
						 (kAPI_SELECT.'='.urlencode(JsonEncode($fields))) );
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
		echo( '<hr>' );

		echo( '<h4>Test GET-ONE in JSON</h4>' );
		//
		// Test query GET-ONE in JSON.
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
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET_ONE),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode(':_terms'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_QUERY.'='.urlencode(JsonEncode($query))),
						 (kAPI_SELECT.'='.urlencode(JsonEncode($fields))) );
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
		echo( '<hr>' );

		echo( '<h4>Test INSERT array in JSON</h4>' );
		//
		// Test INSERT array in JSON.
		//
		$object = array
		(
			'Name' => 'Milko',
			'Surname' => 'Skofic',
			'Increment' => 1,
			'Append' => array( 'A' ),
			'Set' => array( 'A', 'B', 'C' ),
			'Array' => array( 1, 2, 3, 4 )
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

		echo( '<h4>Test modify</h4>' );
		//
		// Test modify.
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
		$criteria = array
		(
			'Surname'	=> array( kAPI_MODIFY_REPLACE => 'Škofič' ),
			'Increment'	=> array( kAPI_MODIFY_INCREMENT => 3 ),
			'Append'	=> array( kAPI_MODIFY_APPEND => 'B' ),
			'Set'		=> array( kAPI_MODIFY_ADDSET => 'Z' ),
			'Array'		=> array( kAPI_MODIFY_POP => 1,
								  kAPI_MODIFY_PULL => 3 )
		);
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_MODIFY),
						 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('TEST'))),
						 (kAPI_CONTAINER.'='.urlencode(JsonEncode('test'))),
						 (kAPI_STAMP_REQUEST.'='.urlencode(JsonEncode(gettimeofday( true )))),
						 (kAPI_QUERY.'='.urlencode(JsonEncode($query))),
						 (kAPI_CRITERIA.'='.urlencode(JsonEncode($criteria))) );
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

		echo( '<h4>Check if object was modified</h4>' );
		//
		// Check if object was modified.
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
		echo( '<hr>' );
	}

	//
	// Init section storage.
	//
	$terms = Array();
	$new_url = 'http://localhost/mywrapper/GraphWrapper.php';

	echo( '<h4>Test SetNamespace in JSON</h4>' );
	//
	// Test SetNamespace in JSON.
	//
	$object = array
	(
		kTAG_LID		=>	'TEST',
		kTAG_SYNONYMS	=>	array( 'test', 'prova' ),
		kTAG_LABEL		=>	array( 'en' => 'Test namespace term' ),
		kTAG_DEFINITION	=>	array( 'en' => 'A namespace term for testing purposes' )
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_SetNamespace),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode( $object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	$terms[] = $decoded[ ':WS:RESPONSE' ][ '_ids' ][ 0 ];
	$namespace = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	echo( '<hr>' );

	echo( '<h4>Test SetTerm with GID namespace in JSON</h4>' );
	//
	// Test SetTerm with GID namespace in JSON.
	//
	$object = array
	(
		kTAG_NAMESPACE	=>	'TEST',
		kTAG_LID		=>	'TEST',
		kTAG_SYNONYMS	=>	array( 'test', 'prova' ),
		kTAG_LABEL		=>	array( 'en' => 'Test namespace term' ),
		kTAG_DEFINITION	=>	array( 'en' => 'A namespace term for testing purposes' )
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_SetNamespace),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode( $object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	$terms[] = $decoded[ ':WS:RESPONSE' ][ '_ids' ][ 0 ];
	$term1 = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	echo( '<hr>' );

	echo( '<h4>Test SetTerm with NID namespace in JSON</h4>' );
	//
	// Test SetTerm with NID namespace in JSON.
	//
	$object = array
	(
		kTAG_NAMESPACE	=>	$decoded[ kAPI_STATUS ][ kTERM_STATUS_IDENTIFIER ],
		kTAG_LID		=>	'TEST',
		kTAG_SYNONYMS	=>	array( 'test', 'prova' ),
		kTAG_LABEL		=>	array( 'en' => 'Test namespace term' ),
		kTAG_DEFINITION	=>	array( 'en' => 'A namespace term for testing purposes' )
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_SetNamespace),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode( $object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	$terms[] = $decoded[ ':WS:RESPONSE' ][ '_ids' ][ 0 ];
	$term2 = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	echo( '<hr>' );

	echo( '<h4>Test GetTerms in JSON</h4>' );
	//
	// Test query GetTerms in JSON.
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
				kOFFSET_QUERY_DATA => 'TEST'
			)
		)
	);
	$sort = array( kTAG_GID => 1 );
	$fields = array( kTAG_GID, kTAG_LABEL );
	$languages = array( 'en', 'fr' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetTerm),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SORT.'='.urlencode(JsonEncode( $sort ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetTerms by namespace GID in JSON</h4>' );
	//
	// Test query GetTerms by namespace GID in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NAMESPACE,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'TEST'
			)
		)
	);
	$sort = array( kTAG_GID => -1 );
	$fields = array( kTAG_GID, kTAG_LABEL );
	$languages = array( 'en', 'fr' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetTerm),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SORT.'='.urlencode(JsonEncode( $sort ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetTerms by namespace NID in JSON</h4>' );
	//
	// Test GetTerms by namespace NID in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NAMESPACE,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_BINARY_STRING,
				kOFFSET_QUERY_DATA => $namespace
			)
		)
	);
	$fields = array( kTAG_GID, kTAG_LABEL );
	$languages = array( 'en', 'fr' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetTerm),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	//
	// Init objects to be deleted.
	//
	$nodes = Array();

	echo( '<h4>Test SetMasterVertex in JSON by term GID</h4>' );
	//
	// Test SetMasterVertex in JSON by term GID.
	//
	$object = array
	(
		kTAG_TERM		=>	'TEST:TEST',
		kTAG_CATEGORY	=>	array( 'Category 1', 'Category 2' ),
		kTAG_KIND		=>	array( kKIND_FEATURE, kKIND_SCALE ),
		kTAG_TYPE		=>	array( kTYPE_STRING, kTYPE_ARRAY ),
		kTAG_DESCRIPTION	=>	array( 'en' => 'A node for testing purposes' )
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_SetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode( 'COntologyMasterVertex' ))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode( $object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	$rel_subject = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	$nodes[] = $rel_subject;
	echo( '<hr>' );

	echo( '<h4>Test SetAliasVertex in JSON by term NID</h4>' );
	//
	// Test SetAliasVertex in JSON by term NID.
	//
	$object = array
	(
		kTAG_TERM		=>	$term1,
		kTAG_CATEGORY	=>	array( 'Category 3', 'Category 4' ),
		kTAG_KIND		=>	array( kKIND_FEATURE, kKIND_METHOD, kKIND_SCALE ),
		kTAG_KIND		=>	array( kTYPE_STRING, kTYPE_ARRAY, kTYPE_REQUIRED ),
		kTAG_DESCRIPTION	=>	array( 'en' => 'A node for testing purposes' )
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_SetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode( 'COntologyAliasVertex' ))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode( $object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	$rel_object = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	$nodes[] = $rel_object;
	echo( '<hr>' );

	echo( '<h4>Test duplicate SetMasterVertex in JSON</h4>' );
	//
	// Test duplicate SetMasterVertex in JSON.
	//
	$object = array
	(
		kTAG_TERM		=>	'TEST:TEST',
		kTAG_CATEGORY	=>	array( 'Category 1', 'Category 2' ),
		kTAG_KIND		=>	array( kKIND_FEATURE, kKIND_SCALE ),
		kTAG_KIND		=>	array( kTYPE_STRING, kTYPE_ARRAY ),
		kTAG_DESCRIPTION	=>	array( 'en' => 'A node for testing purposes' )
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_SetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode( 'COntologyMasterVertex' ))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode( $object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	if( ! in_array( $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ], $nodes ) )
	{
		echo( '<font color="red">FAILED!!</font><br>' );
		$nodes[] = $decoded[ ':WS:STATUS' ][ ':STATUS-IDENTIFIER' ];
	}
	echo( '<hr>' );

	echo( '<h4>Test GetVertex in JSON</h4>' );
	//
	// Test query GetVertex in JSON.
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
				kOFFSET_QUERY_DATA => 'TEST'
			)
		)
	);
	$fields = array( kTAG_GID, kTAG_LABEL, kTAG_KIND, kTAG_TYPE, kTAG_CLASS );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test RelateTo in JSON</h4>' );
	//
	// Test RelateTo in JSON.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_RelateTo),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_REL_FROM.'='.urlencode(JsonEncode( $rel_subject ))),
					 (kAPI_PREDICATE.'='.urlencode(JsonEncode( kPREDICATE_SUBCLASS_OF ))),
					 (kAPI_REL_TO.'='.urlencode(JsonEncode( $rel_object ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $new_url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	$id = $decoded[ ':WS:RESPONSE' ][ '_ids' ][ 0 ];
	echo( '<hr>' );
	
	//
	// Delete edges.
	//
	echo( '<hr>Deleted edges:' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_DELETE),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode('COntologyEdge'))),
					 (kAPI_OBJECT.'='.urlencode(JsonEncode($id))) );
	$result = JsonDecode( file_get_contents( $new_url.'?'.implode( '&', $params ) ) );
	if( $result[ ':WS:STATUS' ][ ':STATUS-CODE' ] )
	{
		echo( '<pre>' );
		print_r( $result );
		exit( '</pre>' );
	}
	echo( " $id" );
	echo( '<hr>' );
	
	//
	// Delete terms.
	//
	echo( '<hr>Deleted terms:' );
	foreach( $terms as $id )
	{
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_DELETE),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CLASS.'='.urlencode(JsonEncode('COntologyTerm'))),
						 (kAPI_OBJECT.'='.urlencode(JsonEncode($id))) );
		$result = JsonDecode( file_get_contents( $new_url.'?'.implode( '&', $params ) ) );
		if( $result[ ':WS:STATUS' ][ ':STATUS-CODE' ] )
		{
			echo( '<pre>' );
			print_r( $result );
			exit( '</pre>' );
		}
		echo( " $id" );
	}
	echo( '<hr>' );
	
	//
	// Delete nodes.
	//
	echo( '<hr>Deleted nodes:' );
	foreach( $nodes as $id )
	{
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_DELETE),
						 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
						 (kAPI_CLASS.'='.urlencode(JsonEncode('COntologyNode'))),
						 (kAPI_OBJECT.'='.urlencode(JsonEncode($id))) );
		$result = JsonDecode( file_get_contents( $new_url.'?'.implode( '&', $params ) ) );
		if( $result[ ':WS:STATUS' ][ ':STATUS-CODE' ] )
		{
			echo( '<pre>' );
			print_r( $result );
			exit( '</pre>' );
		}
		echo( " $id" );
	}
	echo( '<hr>' );

	echo( '<h4>Test GetVertex list in JSON</h4>' );
	//
	// Test query GetVertex in JSON.
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
	$fields = array( kTAG_GID, kTAG_LABEL, kTAG_KIND, kTAG_TYPE, kTAG_CLASS );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex incoming relationships in JSON</h4>' );
	echo( '<h5>:ATTRIBUTES</h5>' );
	//
	// Test GetVertex incoming relationships in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_INT32,
				kOFFSET_QUERY_DATA => 3
			)
		)
	);
	$fields = array( kTAG_GID );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_IN ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex outgoing relationships in JSON</h4>' );
	echo( '<h5>:CLASS</h5>' );
	//
	// Test GetVertex outgoing relationships in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_TERM,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'FAO-INSTITUTES:INSTCODE'
			)
		)
	);
	$fields = array( kTAG_GID );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_OUT ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex relationships in JSON</h4>' );
	echo( '<h5>:INT</h5>' );
	//
	// Test GetVertex relationships in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:1:alpha-3:ITA'
			)
		)
	);
	$fields = array( kTAG_GID );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode('en'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_ALL ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex relationships by predicate in JSON</h4>' );
	echo( '<h5>:INT</h5>' );
	echo( '<h5>'.kPREDICATE_ENUM_OF.'</h5>' );
	//
	// Test GetVertex relationships by predicate in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:1:alpha-3:ITA'
			)
		)
	);
	$fields = array( kTAG_GID );
	$predicates = kPREDICATE_ENUM_OF;
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_PREDICATE.'='.urlencode(JsonEncode( $predicates ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_ALL ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode('en'))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex relationships by predicate in JSON</h4>' );
	echo( '<h5>:INT</h5>' );
	echo( '<h5>'.kPREDICATE_XREF_EXACT." ".kPREDICATE_ENUM_OF.'</h5>' );
	//
	// Test GetVertex relationships by predicate in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:1:alpha-3:ITA'
			)
		)
	);
	$fields = array( kTAG_GID );
	$predicates = array( kPREDICATE_ENUM_OF, kPREDICATE_XREF_EXACT );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_PREDICATE.'='.urlencode(JsonEncode( $predicates ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_ALL ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode('en'))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex relationships by filter in JSON</h4>' );
	//
	// Test GetVertex relationships by filter in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:1:alpha-3:ITA'
			)
		)
	);
	$subquery = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_LABEL.'.en',
				kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'Ita'
			)
		)
	);
	$fields = array( kTAG_GID );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SUBQUERY.'='.urlencode(JsonEncode( $subquery ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_IN ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode('en'))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex relationships by filter list in JSON</h4>' );
	//
	// Test GetVertex relationships by filter in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:1:alpha-3:ITA'
			)
		)
	);
	$subquery = array
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
					kOFFSET_QUERY_DATA => 'italy'
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
					kOFFSET_QUERY_DATA => 'italy'
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
					kOFFSET_QUERY_DATA => 'italy'
				)
			)
		),
		array
		(
			kOPERATOR_AND => array
			(
				array
				(
					kOFFSET_QUERY_SUBJECT => kTAG_LABEL.'.en',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_CONTAINS_NOCASE,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'italy'
				)
			)
		)
	);
	$fields = array( kTAG_GID );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SUBQUERY.'='.urlencode(JsonEncode( $subquery ))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( 'en' ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_IN ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex relationships with language in JSON</h4>' );
	echo( '<h5>:INT</h5>' );
	//
	// Test GetVertex relationships with language in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:1:alpha-3'
			)
		)
	);
	$fields = array( kTAG_GID, kTAG_LABEL, kTAG_DESCRIPTION. kTAG_DEFINITION );
	$languages = array( 'en', 'it', 'ru', 'ar' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_IN ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetVertex alias relationships in JSON</h4>' );
	echo( '<h5>:ATTRIBUTES</h5>' );
	//
	// Test GetVertex alias relationships in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_GID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:639:1'
			)
		)
	);
	$fields = array( kTAG_GID );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_RELATION.'='.urlencode(JsonEncode( kAPI_RELATION_IN ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( 'en' ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetTags in JSON</h4>' );
	//
	// Test query GetTags in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_IN,
				kOFFSET_QUERY_TYPE => kTYPE_INT,
				kOFFSET_QUERY_DATA => array( kTAG_LID, kTAG_GID, kTAG_UID )
			)
		)
	);
	$sort = array( kTAG_GID => 1 );
	$fields = array( kTAG_GID, kTAG_LABEL );
	$languages = array( 'en', 'fr' );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetTag),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(5))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_SORT.'='.urlencode(JsonEncode( $sort ))),
					 (kAPI_SELECT.'='.urlencode(JsonEncode( $fields ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetEnums by node in JSON</h4>' );
	//
	// Test GetEnums by node in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_INT,
				kOFFSET_QUERY_DATA => 186
			)
		)
	);
	$languages = 'en';
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetEnums),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode( 'COntologyMasterVertex' ))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test GetEnums by tag in JSON</h4>' );
	//
	// Test GetEnums by tag in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => kTAG_NID,
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_INT,
				kOFFSET_QUERY_DATA => kTAG_TYPE
			)
		)
	);
	$languages = 'en';
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetEnums),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_CLASS.'='.urlencode(JsonEncode( 'COntologyTag' ))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( $languages ))),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )) );
	//
	// Display.
	//
	echo( kSTYLE_TABLE_PRE );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'URL:'.kSTYLE_HEAD_POS );
	$request = $url.'?'.implode( '&', $params );
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $request ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Response:'.kSTYLE_HEAD_POS );
	$response = file_get_contents( $request );
	echo( kSTYLE_DATA_PRE.$response.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	$decoded = JsonDecode( $response );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
