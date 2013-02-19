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
 *									LandracePassport.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/data/includes.inc.php' );

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

//
// PHPExcel includes.
//
require_once( '/Library/WebServer/Library/PHPExcel/Classes/PHPExcel.php' );


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
	// Get all landrace tags.
	// Get all features of the landrace namespace.
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
				kOFFSET_QUERY_DATA => 'LR:'
			)
		)
	);
	$params = array( (kAPI_FORMAT.'='.kTYPE_JSON),
					 (kAPI_OPERATION.'='.kAPI_OP_GetTag),
					 (kAPI_LOG_REQUEST.'='.urlencode(JsonEncode(TRUE))),
					 (kAPI_PAGE_START.'='.urlencode(JsonEncode(0))),
					 (kAPI_PAGE_LIMIT.'='.urlencode(JsonEncode(1000))),
					 (kAPI_DATABASE.'='.urlencode(JsonEncode('ONTOLOGY'))),
					 (kAPI_QUERY.'='.urlencode(JsonEncode( $query ))),
					 (kAPI_LANGUAGE.'='.urlencode(JsonEncode( kDEFAULT_LANGUAGE ))) );
	$request = $url.'?'.implode( '&', $params );
	$response = file_get_contents( $request );
	$result = JsonDecode( $response );
	
	//
	// Init local storage.
	//
	$ids = & $result[ kAPI_RESPONSE ][ kAPI_COLLECTION_ID ];
	$tags = & $result[ kAPI_RESPONSE ][ kAPI_COLLECTION_TAG ];
	$terms = & $result[ kAPI_RESPONSE ][ kAPI_COLLECTION_TERM ];
	
	//
	// Create excel object.
	//
	$excel = new PHPExcel();
	$excel->getProperties()->setCreator( "Trait Information Portal" )
						   ->setTitle( "Landrace passport descriptors template" )
						   ->setDescription( "Excel template file for loading landrace passport data. Add data starting from third row." );
	$sheet = $excel->setActiveSheetIndex( 0 );
	
	//
	// Iterate tags.
	//
	for( $i = 0; $i < count( $ids ); $i++ )
	{
		//
		// Set values.
		//
		$id = $tags[ $ids[ $i ] ][ kTAG_GID ];
		$ref = & $terms[ $tags[ $ids[ $i ] ][ kTAG_PATH ][ 0 ] ];
		$label = ( array_key_exists( kTAG_LABEL, $ref ) )
			   ? $ref[ kTAG_LABEL ][ kDEFAULT_LANGUAGE ]
			   : NULL;
		$definition = ( array_key_exists( kTAG_DEFINITION, $ref ) )
					? $ref[ kTAG_DEFINITION ][ kDEFAULT_LANGUAGE ]
					: NULL;

		//
		// Load values.
		//
		$sheet->setCellValueByColumnAndRow( $i, 1, $id );
		$sheet->setCellValueByColumnAndRow( $i, 2, $label );
		$sheet->setCellValueByColumnAndRow( $i, 3, $definition );
	
	} // Iterating tag identifiers.
	
	//
	// Set excel headers.
	//
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="LandraceTemplate.xlsx"');
	header('Cache-Control: max-age=0');
	
	//
	// Write excel.
	//
	$objWriter = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
	$objWriter->save( 'php://output' );
	exit;
	
}
catch( Exception $error )
{
	echo( (string) $error );
}

?>
