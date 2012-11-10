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
 *							test_CMongoOntologyWrapper.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Local includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/data/local.inc.php' );

//
// Style includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/styles.inc.php' );

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
		echo( '<h4>Empty request</h4>' );
		//
		// Empty request.
		//
		$response = file_get_contents( $url );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test ping with log request</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_LOG_REQUEST.'='.'1') );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test ping with timers</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1') );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test invalid operator</h4>' );
		//
		// Invalid operator.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.'XXX'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1') );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test missing operator</h4>' );
		//
		// Missing operator.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1') );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test database and container</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_DATABASE.'='."TEST"),
						 (kAPI_CONTAINER.'='."TEST-CNT") );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test paging (missing limit)</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='."0") );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test paging (missing start)</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_LIMIT.'='."120") );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
		
		echo( '<h4>Test paging (limit overflow)</h4>' );
		//
		// Ping wrapper.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_PING),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_LIMIT.'='."1000000") );
		$request = implode( '&', $params );
		$request = "$url?$request";
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
					kOFFSET_QUERY_SUBJECT => '_id',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
					kOFFSET_QUERY_TYPE => kTYPE_BINARY,
					kOFFSET_QUERY_DATA => new CDataTypeBinary( hex2bin( '80B196896559FEA57DAE4360FF46BF59' ) )
				)
			)
		);
		$query_enc = JsonEncode( $query );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'10'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_terms'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_QUERY.'='.urlencode( $query_enc )) );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
					kOFFSET_QUERY_SUBJECT => '12',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => ':SCALE'
				)
			)
		);
		$query_enc = serialize( $query );
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'10'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_nodes'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_QUERY.'='.urlencode( $query_enc )) );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = unserialize( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	
		echo( '<h4>Test container count in JSON</h4>' );
		//
		// Test container count in JSON.
		//
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'10'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_terms') );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
					kOFFSET_QUERY_SUBJECT => '2',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'ISO:3166:2:'
				)
			)
		);
		$query_enc = JsonEncode( $query );
		$fields = array( '1', '2', '31' );
		$fields_enc = JsonEncode( $fields );
		$sort = array( '1' => -1 );
		$sort_enc = JsonEncode( $sort );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'5'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_terms'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_QUERY.'='.urlencode( $query_enc )),
						 (kAPI_SELECT.'='.urlencode( $fields_enc )),
						 (kAPI_SORT.'='.urlencode( $sort_enc )) );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
					kOFFSET_QUERY_SUBJECT => '2',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'ISO:3166:2:'
				)
			)
		);
		$query_enc = serialize( $query );
		$fields = array( '1', '2', '31' );
		$fields_enc = serialize( $fields );
		$sort = array( '1' => -1 );
		$sort_enc = serialize( $sort );
		$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
						 (kAPI_OPERATION.'='.kAPI_OP_GET),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'5'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_terms'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_QUERY.'='.urlencode( $query_enc )),
						 (kAPI_SELECT.'='.urlencode( $fields_enc )),
						 (kAPI_SORT.'='.urlencode( $sort_enc )) );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = unserialize( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
					kOFFSET_QUERY_SUBJECT => '2',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'ISO:3166:2:'
				)
			)
		);
		$query_enc = JsonEncode( $query );
		$fields = array( '1', '2', '31' );
		$fields_enc = JsonEncode( $fields );
		$sort = array( '1' => -1 );
		$sort_enc = JsonEncode( $sort );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_GET_ONE),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'5'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_terms'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_QUERY.'='.urlencode( $query_enc )),
						 (kAPI_SELECT.'='.urlencode( $fields_enc )),
						 (kAPI_SORT.'='.urlencode( $sort_enc )) );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
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
						kOFFSET_QUERY_SUBJECT => '2',
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
						kOFFSET_QUERY_SUBJECT => '1',
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
						kOFFSET_QUERY_SUBJECT => '7',
						kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
						kOFFSET_QUERY_TYPE => kTYPE_STRING,
						kOFFSET_QUERY_DATA => 'NICODE'
					)
				)
			)
		);
		$query_enc = JsonEncode( $queries );
		$fields = array( '1', '2', '31' );
		$fields_enc = JsonEncode( $fields );
		$sort = array( '1' => -1 );
		$sort_enc = JsonEncode( $sort );
		$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
						 (kAPI_OPERATION.'='.kAPI_OP_MATCH),
						 (kAPI_LOG_REQUEST.'='.'1'),
						 (kAPI_PAGE_START.'='.'0'),
						 (kAPI_PAGE_LIMIT.'='.'5'),
						 (kAPI_DATABASE.'='.'ONTOLOGY'),
						 (kAPI_CONTAINER.'='.'_terms'),
						 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
						 (kAPI_QUERY.'='.urlencode( $query_enc )),
						 (kAPI_SELECT.'='.urlencode( $fields_enc )),
						 (kAPI_SORT.'='.urlencode( $sort_enc )) );
		$request = $url.'?'.implode( '&', $params );
		$response = file_get_contents( $request );
		$decoded = JsonDecode( $response );
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
		echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
		echo( kSTYLE_ROW_POS );
		echo( kSTYLE_TABLE_POS );
		echo( '<hr>' );
	}

	echo( '<h4>Test GetRootsByKind in JSON</h4>' );
	//
	// Test query GetRootsByKind in JSON.
	//
	$query = array( kKIND_NODE_DDICT );
	$query_enc = JsonEncode( $query );
	$fields = array( '2', '6', '12' );
	$fields_enc = JsonEncode( $fields );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetRootsByKind),
					 (kAPI_LOG_REQUEST.'='.'1'),
					 (kAPI_PAGE_START.'='.'0'),
					 (kAPI_PAGE_LIMIT.'='.'5'),
					 (kAPI_DATABASE.'='.'ONTOLOGY'),
					 (kAPI_SELECT.'='.urlencode( $fields_enc )),
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
				kOFFSET_QUERY_SUBJECT => '2',
				kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => 'ISO:3166:2:'
			)
		)
	);
	$query_enc = JsonEncode( $query );
	$fields = array( '2', '6', '12' );
	$fields_enc = JsonEncode( $fields );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.'1'),
					 (kAPI_PAGE_START.'='.'0'),
					 (kAPI_PAGE_LIMIT.'='.'5'),
					 (kAPI_DATABASE.'='.'ONTOLOGY'),
					 (kAPI_SELECT.'='.urlencode( $fields_enc )),
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

	echo( '<h4>Test GetVertex input relatons in JSON</h4>' );
	//
	// Test GetVertex input relatons in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => '_id',
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_INT32,
				kOFFSET_QUERY_DATA => 13764
			)
		)
	);
	$query_enc = JsonEncode( $query );
	$fields = array( '2', '6', '12' );
	$fields_enc = JsonEncode( $fields );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.'1'),
					 (kAPI_PAGE_START.'='.'0'),
					 (kAPI_PAGE_LIMIT.'='.'5'),
					 (kAPI_DATABASE.'='.'ONTOLOGY'),
					 (kAPI_RELATION.'='.kAPI_RELATION_IN),
					 (kAPI_QUERY.'='.urlencode( $query_enc )),
					 (kAPI_SELECT.'='.urlencode( $fields_enc )),
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

	echo( '<h4>Test GetVertex output relatons in JSON</h4>' );
	//
	// Test GetVertex output relatons in JSON.
	//
	$query = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => '_id',
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_INT32,
				kOFFSET_QUERY_DATA => 13764
			)
		)
	);
	$query_enc = JsonEncode( $query );
	$fields = array( '2', '6', '12' );
	$fields_enc = JsonEncode( $fields );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetVertex),
					 (kAPI_LOG_REQUEST.'='.'1'),
					 (kAPI_PAGE_START.'='.'0'),
					 (kAPI_PAGE_LIMIT.'='.'5'),
					 (kAPI_DATABASE.'='.'ONTOLOGY'),
					 (kAPI_RELATION.'='.kAPI_RELATION_OUT),
					 (kAPI_QUERY.'='.urlencode( $query_enc )),
					 (kAPI_SELECT.'='.urlencode( $fields_enc )),
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
