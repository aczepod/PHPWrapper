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
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Style includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/styles.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataWrapper.php" );


/*=======================================================================================
 *	TEST WRAPPER OBJECT																	*
 *======================================================================================*/
 
//
// Init local storage.
//
$url = 'http://localhost/mywrapper/DataWrapper.php';

//
// TRY BLOCK.
//
try
{
	//
	// Open mongo connection.
	//
	$mongo = New Mongo();
	
	//
	// Select MCPD database.
	//
	$db = $mongo->selectDB( 'ONTOLOGY' );
	
	//
	// Select test collection.
	//
	$collection = $db->selectCollection( '_terms' );
	
	//
	// Instantiate container.
	//
	$container = new CMongoContainer( $collection );
	
	//
	// Get test object.
	//
	$object_serialised = $object = $collection->findOne( array( "2" => "ISO:639:3:bau" ) );
	CDataType::SerialiseObject( $object_serialised );
	
	//
	// Convert object.
	//
	$object_json = JsonEncode( $object_serialised );
	$object_php = serialize( $object_serialised );
	
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
	
	echo( '<h4>Missing operation</h4>' );
	//
	// Missing operation.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Ping wrapper in PHP</h4>' );
	//
	// Ping wrapper in PHP.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Ping wrapper in JSON</h4>' );
	//
	// Ping wrapper in JSON.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	$decoded = json_decode( $response );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Test decode object in PHP</h4>' );
	//
	// Test decode object in PHP.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_PHP),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_OBJECT.'='.urlencode( $object_php )),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Test decode object in JSON</h4>' );
	//
	// Test decode object in JSON.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_PING),
					 (kAPI_OBJECT.'='.urlencode( $object_json )),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );

	echo( '<h4>Debug query in JSON</h4>' );
	//
	// Debug query in JSON.
	//
	$query_php = array
	(
		kOPERATOR_AND => array
		(
			array
			(
				kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
				kOFFSET_QUERY_TYPE => kTYPE_STRING,
				kOFFSET_QUERY_DATA => '2'
			),
			
			1 => array
			(
				kOPERATOR_OR => array
				(
					array
					(
						kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
						kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
						kOFFSET_QUERY_TYPE => kTYPE_STRING,
						kOFFSET_QUERY_DATA => 'NCBI_taxid:'
					),
					
					array
					(
						kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
						kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
						kOFFSET_QUERY_TYPE => kTYPE_STRING,
						kOFFSET_QUERY_DATA =>  'GR:'
					)
				)
			)
		)
	);
	$query_json = JsonEncode( $query_php );
	$fields_json = JsonEncode( array( ':GID', ':XREF' ) );
	$sort_json = JsonEncode( array( ':LID', ':TYPE' ) );
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_COUNT),
					 (kAPI_PAGE_START.'='.'0'),
					 (kAPI_PAGE_LIMIT.'='.'10'),
					 (kAPI_DATABASE.'='.'Database'),
					 (kAPI_CONTAINER.'='.'Container'),
					 (kAPI_QUERY.'='.urlencode( $query_json )),
					 (kAPI_SELECT.'='.urlencode( $fields_json )),
					 (kAPI_SORT.'='.urlencode( $sort_json )),
					 (kAPI_OBJECT.'='.urlencode( $object_json )),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	
	echo( '<h4>Invalid operation</h4>' );
	//
	// Invalid operation.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.'XXX'),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
	echo( kSTYLE_DATA_PRE.'<pre>' ); print_r( $decoded ); echo( '</pre>'.kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_TABLE_POS );
	echo( '<hr>' );
	
	echo( '<h4>Missing operation</h4>' );
	//
	// Missing operation.
	//
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_STAMP_REQUEST.'='.gettimeofday( true )),
					 (kAPI_LOG_REQUEST.'='.'1') );
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
	echo( kSTYLE_DATA_PRE.htmlspecialchars( $response ).kSTYLE_DATA_POS );
	echo( kSTYLE_ROW_POS );
	echo( kSTYLE_ROW_PRE );
	echo( kSTYLE_HEAD_PRE.'Decoded:'.kSTYLE_HEAD_POS );
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
