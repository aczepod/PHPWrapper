<?php
	
/**
 * {@link CQuery.php Query} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CQuery class}.
 *
 *	@package	Test
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/12/2012
 */

/*=======================================================================================
 *																						*
 *									test_CQuery.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQuery.php" );


/*=======================================================================================
 *	LOAD TEST OBJECTS																	*
 *======================================================================================*/
 
//
// Test queries.
//
$query01 = array
(
	kOPERATOR_AND => array
	(
		0 => array
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
				0 => array
				(
					kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'NCBI_taxid:'
				),
				
				1 => array
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

$query02 = array
(
	kOPERATOR_AND => array
	(
		0 => array
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
				0 => array
				(
					kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA => 'NCBI_taxid:'
				),
				
				1 => array
				(
					kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
					kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
					kOFFSET_QUERY_TYPE => kTYPE_STRING,
					kOFFSET_QUERY_DATA =>  'GR:'
				),
				
				2 => array
				(
					kOPERATOR_AND => array
					(
						0 => array
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
								0 => array
								(
									kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
									kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
									kOFFSET_QUERY_TYPE => kTYPE_STRING,
									kOFFSET_QUERY_DATA => 'NCBI_taxid:'
								),
								
								1 => array
								(
									kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
									kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
									kOFFSET_QUERY_TYPE => kTYPE_STRING,
									kOFFSET_QUERY_DATA =>  'GR:'
								)
							)
						)
					)
				)
			)
		)
	)
);

$query03 = array
(
	kOPERATOR_AND => array
	(
		0 => array
		(
//				kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
			kOFFSET_QUERY_TYPE => kTYPE_STRING,
			kOFFSET_QUERY_DATA => '2'
		),
	)
);

$query04 = array
(
	kOPERATOR_AND => array
	(
		0 => array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
//				kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
			kOFFSET_QUERY_TYPE => kTYPE_STRING,
			kOFFSET_QUERY_DATA => '2'
		),
	)
);

$query05 = array
(
	kOPERATOR_AND => array
	(
		0 => array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
//				kOFFSET_QUERY_TYPE => kTYPE_STRING,
			kOFFSET_QUERY_DATA => '2'
		),
	)
);

$query06 = array
(
	kOPERATOR_AND => array
	(
		0 => array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
			kOFFSET_QUERY_TYPE => kTYPE_STRING,
//				kOFFSET_QUERY_DATA => '2'
		),
	)
);

$query07 = array
(
	kOPERATOR_AND => array
	(
		0 => array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_NULL,
		),
	)
);


/*=======================================================================================
 *	TEST QUERY OBJECT																	*
 *======================================================================================*/
 
//
// TRY BLOCK.
//
try
{
	//
	// Instantiate empty object.
	//
	echo( '<i>$test = new CQuery();</i><br>' ); 
	$test = new CQuery();
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Add statement.
	//
	echo( '<b>Add an AND statement</b><br>' );
	$statement = array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
			kOFFSET_QUERY_TYPE => kTYPE_STRING,
			kOFFSET_QUERY_DATA => '2'
		);
	$test->AppendStatement( $statement, kOPERATOR_AND );
	echo( 'Statement<pre>' ); print_r( $statement ); echo( '</pre>' );
	echo( '<i>$test->AppendStatement( $statement );</i><br>' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Add another statement.
	//
	echo( '<b>Add another AND statement</b><br>' );
	$statement = array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_NOT_NULL
		);
	$test->AppendStatement( $statement );
	echo( 'Statement<pre>' ); print_r( $statement ); echo( '</pre>' );
	echo( '<i>$test->AppendStatement( $statement );</i><br>' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );

	//
	// Add another statement.
	//
	echo( '<b>Add another OR statement</b><br>' );
	$statement = array
	(
		kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
		kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
		kOFFSET_QUERY_TYPE => kTYPE_STRING,
		kOFFSET_QUERY_DATA => 'NCBI_taxid:'
	);
	$test->AppendStatement( $statement, kOPERATOR_OR );
	echo( 'Statement<pre>' ); print_r( $statement ); echo( '</pre>' );
	echo( '<i>$test->AppendStatement( $statement, kOPERATOR_OR );</i><br>' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );

	//
	// Add another statement.
	//
	echo( '<b>Add another OR statement</b><br>' );
	$statement = array
	(
		kOFFSET_QUERY_SUBJECT => ':XREF.:DATA._code',
		kOFFSET_QUERY_OPERATOR => kOPERATOR_PREFIX,
		kOFFSET_QUERY_TYPE => kTYPE_STRING,
		kOFFSET_QUERY_DATA =>  'GR:'
	);
	$test->AppendStatement( $statement, kOPERATOR_OR );
	echo( 'Statement<pre>' ); print_r( $statement ); echo( '</pre>' );
	echo( '<i>$test->AppendStatement( $statement, kOPERATOR_OR );</i><br>' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Add another statement.
	//
	echo( '<b>Add another AND statement</b><br>' );
	$statement = array
		(
			kOFFSET_QUERY_SUBJECT => ':XREF.:SCOPE',
			kOFFSET_QUERY_OPERATOR => kOPERATOR_EQUAL,
			kOFFSET_QUERY_TYPE => kTYPE_STRING,
			kOFFSET_QUERY_DATA => '2'
		);
	$test->AppendStatement( $statement );
	echo( 'Statement<pre>' ); print_r( $statement ); echo( '</pre>' );
	echo( '<i>$test->AppendStatement( $statement );</i><br>' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );

	//
	// Check another condition.
	//
	echo( '<b>Check another condition</b><br>' );
	$query = array
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
	);
	$statement = array
	(
		kOFFSET_QUERY_SUBJECT => ':XREF',
		kOFFSET_QUERY_OPERATOR => kOPERATOR_NOT_NULL
	);
	$test = new CQuery( $query );
	$test->AppendStatement( $statement );
	echo( 'Query<pre>' ); print_r( $query ); echo( '</pre>' );
	echo( 'Statement<pre>' ); print_r( $statement ); echo( '</pre>' );
	echo( '<i>$test = new CQuery( $query );</i><br>' );
	echo( '<i>$test->AppendStatement( $statement );</i><br>' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate queries.
	//
	$queries = array( $query01, $query02, $query03, $query04,
					  $query05, $query06, $query07 );
	foreach( $queries as $key => $query )
	{
		try
		{
			echo( "<br><b>$key</b><br>" );
			//
			// Instantiate.
			//
			$test = new CQuery( $query );
			echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
			$test->Validate();
			echo( 'OK!<br>' );
		}
		catch( Exception $error )
		{
			echo( '<h5>Expected exception</h5>' );
			echo( '<pre>'.(string) $error.'</pre>' );
			echo( '<hr>' );
		}
	}

	echo( '<hr>' );
	echo( '<hr>' );

	//
	// Test .
	//
	echo( '<b>Play with query statements</b><br>' );
	echo( '<i>$query = new CQuery();</i><br>' );
	$query = new CQuery();
	echo( '<i>$query1 = new CQuery();</i><br>' );
	$query1 = new CQuery();
	echo( '<i>$statement = CQueryStatement::Equals( \'Field1\', \'String1\' );</i><br>' );
	$statement = CQueryStatement::Equals( 'Field1', 'String1' );
	echo( '<i>$query1->AppendStatement( $statement, kOPERATOR_OR );</i><br>' );
	$query1->AppendStatement( $statement, kOPERATOR_OR );
	echo( '<i>$statement = CQueryStatement::Contains( \'Field2\', \'pippo\' );</i><br>' );
	$statement = CQueryStatement::Equals( 'Field2', 'pippo' );
	echo( '<i>$query1->AppendStatement( $statement, kOPERATOR_OR );</i><br>' );
	$query1->AppendStatement( $statement, kOPERATOR_OR );
	echo( '<i>$query2 = new CQuery();</i><br>' );
	$query2 = new CQuery();
	echo( '<i>$statement = CQueryStatement::Member( \'Field3\', array( 1, 2, 3 ) );</i><br>' );
	$statement = CQueryStatement::Member( 'Field3', array( 1, 2, 3 ) );
	echo( '<i>$query2->AppendStatement( $statement, kOPERATOR_AND );</i><br>' );
	$query2->AppendStatement( $statement, kOPERATOR_AND );
	echo( '<i>$statement = CQueryStatement::RangeInclusive( \'Field4\', 10, 20 );</i><br>' );
	$statement = CQueryStatement::RangeInclusive( 'Field4', 10, 20 );
	echo( '<i>$query2->AppendStatement( $statement, kOPERATOR_AND );</i><br>' );
	$query2->AppendStatement( $statement, kOPERATOR_AND );
	echo( '<i>$query->AppendStatement( $query1, kOPERATOR_AND );</i><br>' );
	$query->AppendStatement( $query1, kOPERATOR_AND );
	echo( '<i>$query->AppendStatement( $query2, kOPERATOR_AND );</i><br>' );
	$query->AppendStatement( $query2, kOPERATOR_AND );
	echo( '<pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<hr>' );
	
	echo( '<h3>DONE</h3>' );
}
//
// Catch exceptions.
//
catch( \Exception $error )
{
	echo( '<h3><font color="red">Unexpected exception</font></h3>' );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

?>
