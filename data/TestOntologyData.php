<?php

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Local includes.
//
require_once( 'local.inc.php' );

//
// Parser functions.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION.'/parsing.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntology.php" );

//
// Test class.
//
try
{
	//
	// Open connections.
	//
	$server = New CMongoServer();
	$database = $server->Database( kDEFAULT_DATABASE );
	$ontology = new COntology( $database );
	
	//
	// Instantiate containers.
	//
	$tag_cont = COntologyTag::DefaultContainer( $database );
	$term_cont = COntologyTerm::DefaultContainer( $database );
	$node_cont = COntologyNode::DefaultContainer( $database );
	$edge_cont = COntologyEdge::DefaultContainer( $database );
	
	//
	// Select root nodes.
	//
	$query = CMongoContainer::NewQuery();
	$stmt = CQueryStatement::Equals( kTAG_KIND, kKIND_NODE_ROOT, kTYPE_STRING );
	$query->AppendStatement( $stmt );
	$rs = $node_cont->Query( $query );
	if( $rs->count() )
	{
		//
		// Init local storage.
		//
		$data = array( 'status' => array( 'code' => 0, 'message' => 'OK' ),
					   'tags' => Array(),
					   'terms' => Array(),
					   'nodes' => Array(),
					   'edges' => Array() );
		
		//
		// Iterate nodes.
		//
		$json = Array();
		foreach( $rs as $node )
			ParseNode( $node, $data, $ontology );
				
		//
		// Write roots.
		//
		$filename = 'roots.json';
		$json = JsonEncode( $data );
		file_put_contents( $filename, $json );
		echo( "$filename\n" );
		
		//
		// Iterate roots.
		//
		$roots = array_keys( $data[ 'nodes' ] );
		foreach( $roots as $root )
		{
			//
			// Init local storage.
			//
			$data = array( 'status' => array( 'code' => 0, 'message' => 'OK' ),
						   'tags' => Array(),
						   'terms' => Array(),
						   'nodes' => Array(),
						   'edges' => Array() );
			
			//
			// Get pointers to root.
			//
			$query = CMongoContainer::NewQuery();
			$stmt = CQueryStatement::Equals( kTAG_VERTEX_OBJECT, $root, kTYPE_INT32 );
			$query->AppendStatement( $stmt );
			$rs = $edge_cont->Query( $query );
			if( $rs->count() )
			{
				//
				// Iterate edges.
				//
				foreach( $rs as $edge )
					ParseEdge( $edge, $data, $ontology );
			}
			
			//
			// Get pointers from root.
			//
			$query = CMongoContainer::NewQuery();
			$stmt = CQueryStatement::Equals( kTAG_VERTEX_SUBJECT, $root, kTYPE_INT32 );
			$query->AppendStatement( $stmt );
			$rs = $edge_cont->Query( $query );
			if( $rs->count() )
			{
				//
				// Iterate edges.
				//
				foreach( $rs as $edge )
					ParseEdge( $edge, $data, $ontology );
			}
					
			//
			// Write root.
			//
			$filename = "root$root.json";
			$json = JsonEncode( $data );
			file_put_contents( $filename, $json );
			echo( "$filename\n" );
		}
	}
}

//
// Catch exceptions.
//
catch( Exception $error )
{
	echo( (string) $error );
}

echo( "\nDone!\n" );

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/

function ParseNode( &$theNode, &$theData, $theOntology )
{
	//
	// Convert to array.
	//
	if( ! is_array( $theNode ) )
		$theNode = $theNode->getArrayCopy();
	
	//
	// Check node.
	//
	if( ! array_key_exists( $theNode[ '_id' ], $theData[ 'nodes' ] ) )
	{
		//
		// Convert node.
		//
		foreach( $theNode as $key => $value )
		{
			//
			// Parse tags.
			//
			switch( $key )
			{
				//
				// Resolve term.
				//
				case kTAG_TERM:
					//
					// Resolve term.
					//
					$term = $theOntology->ResolveTerm( $value, NULL, TRUE );
					ParseTerm( $term, $theData, $theOntology );
					
					//
					// Convert in node.
					//
					$value = bin2hex( $value->bin );
					$theNode[ $key ] = $value;
	
					break;
			}
		}
		
		//
		// Write node.
		//
		$theData[ 'nodes' ][ (string) $theNode[ '_id' ] ] = $theNode;
		
		//
		// Parse tags.
		//
		$tags = array_keys( $theNode );
		foreach( $tags as $tag )
		{
			if( $tag != '_id' )
				ParseTag( $tag, $theData, $theOntology );
		}
	}
}

function ParseTerm( &$theTerm, &$theData, $theOntology )
{
	//
	// Init local storage.
	//
	$terms = Array();
	
	//
	// Convert to array.
	//
	if( $theTerm instanceof COntologyTerm )
		$theTerm = $theTerm->getArrayCopy();
	
	//
	// Check node.
	//
	if( ! array_key_exists( bin2hex( $theTerm[ '_id' ]->bin ), $theData[ 'terms' ] ) )
	{
		//
		// Convert term.
		//
		foreach( $theTerm as $key => $value )
		{
			//
			// Parse tags.
			//
			switch( $key )
			{
				//
				// Handle binary properties.
				//
				case kTAG_TERM:
				case kTAG_NAMESPACE:
					//
					// Resolve term.
					//
					$term = $theOntology->ResolveTerm( $value, NULL, TRUE );
					$terms[] = $term;
					
				case '_id':
					//
					// Convert in term.
					//
					$value = bin2hex( $value->bin );
					$theTerm[ $key ] = $value;
	
					break;
			}
		}
		
		//
		// Write term.
		//
		$theData[ 'terms' ][ $theTerm[ '_id' ] ] = $theTerm;
		
		//
		// Parse recursive terms.
		//
		foreach( $terms as $term )
			ParseTerm( $term, $theData, $theOntology );
		
		//
		// Parse tags.
		//
		$tags = array_keys( $theTerm );
		foreach( $tags as $tag )
		{
			if( $tag != '_id' )
				ParseTag( $tag, $theData, $theOntology );
		}
	}
}

function ParseEdge( &$theEdge, &$theData, $theOntology )
{
	//
	// Convert to array.
	//
	if( ! is_array( $theEdge ) )
		$theEdge = $theEdge->getArrayCopy();
	
	//
	// Check node.
	//
	if( ! array_key_exists( $theEdge[ '_id' ], $theData[ 'edges' ] ) )
	{
		//
		// Convert edge.
		//
		foreach( $theEdge as $key => $value )
		{
			//
			// Parse tags.
			//
			switch( $key )
			{
				//
				// Handle term.
				//
				case kTAG_PREDICATE:
					//
					// Resolve term.
					//
					$term = $theOntology->ResolveTerm( $value, NULL, TRUE );
					ParseTerm( $term, $theData, $theOntology );
					
				case kTAG_UID:
					//
					// Convert in node.
					//
					$value = bin2hex( $value->bin );
					$theEdge[ $key ] = $value;
	
					break;
			}
		}
		
		//
		// Write edge.
		//
		$theData[ 'edges' ][ (string) $theEdge[ '_id' ] ] = $theEdge;
		
		//
		// Parse tags.
		//
		$tags = array_keys( $theEdge );
		foreach( $tags as $tag )
		{
			if( $tag != '_id' )
				ParseTag( $tag, $theData, $theOntology );
		}
	}
}

function ParseTag( $theTag, &$theData, $theOntology )
{
	//
	// Check tag.
	//
	if( ! array_key_exists( $theTag, $theData[ 'tags' ] ) )
	{
		//
		// Init tag.
		//
		$tag = $theOntology->ResolveTag( $theTag, TRUE )->getArrayCopy();
		$theTag = Array();
		
		//
		// Convert tag.
		//
		foreach( $tag as $key => $value )
		{
			//
			// Parse tags.
			//
			switch( $key )
			{
				//
				// Handle unique identifier.
				//
				case kTAG_UID:
					//
					// Convert in tag.
					//
					$value = bin2hex( $value->bin );
	
					break;
				
				//
				// Handle path.
				//
				case kTAG_TAG_PATH:
					for( $i = 1; $i < count( $value ); $i += 2 )
					{
						$id = $value[ $i ];
						$term = $theOntology->ResolveTerm( $id, NULL, TRUE );
						ParseTerm( $term, $theData, $theOntology );
						$value[ $i ] = bin2hex( $id->bin );
					}
					
					break;
				
				//
				// Handle vertex terms.
				//
				case kTAG_VERTEX_TERMS:
					for( $i = 0; $i < count( $value ); $i++ )
					{
						$id = $value[ $i ];
						$term = $theOntology->ResolveTerm( $id, NULL, TRUE );
						ParseTerm( $term, $theData, $theOntology );
						$value[ $i ] = bin2hex( $id->bin );
					}
					
					break;
			}
			
			//
			// Set property.
			//
			$theTag[ $key ] = $value;
		}
		
		//
		// Write tag.
		//
		$theData[ 'tags' ][ (string) $theTag[ '_id' ] ] = $theTag;
		
		//
		// Parse tags.
		//
		$tags = array_keys( $theTag );
		foreach( $tags as $tag )
		{
			if( $tag != '_id' )
				ParseTag( $tag, $theData, $theOntology );
		}
	}
}

?>
