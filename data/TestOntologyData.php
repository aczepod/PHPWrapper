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
	$stmt = CQueryStatement::Equals( kTAG_KIND, kKIND_ROOT, kTYPE_STRING );
	$query->AppendStatement( $stmt );
	$rs = $node_cont->Query( $query );
	if( $rs->count() )
	{
		//
		// Init local storage.
		//
		$root_data = NULL;
		
		//
		// Iterate nodes.
		//
		foreach( $rs as $node )
		{
			//
			// Get node ID.
			//
			$root = $node[ kTAG_NID ];
			$node = CPersistentObject::DocumentObject( $node );
			
			//
			// Export node.
			//
			$ontology->ExportNode( $root_data, $node, NULL, FALSE );
			
			//
			// Get root relations.
			//
			$parents = $ontology->ResolveEdge( NULL, NULL, $root );
			$children = $ontology->ResolveEdge( $root, NULL, NULL );
			if( is_array( $parents )
			 || is_array( $children ) )
			{
				//
				// Init local storage.
				//
				$data = NULL;
				
				//
				// Collect edges.
				//
				if( is_array( $parents )
				 && is_array( $children ) )
					$edges = array_merge( $parents, $children );
				elseif( is_array( $parents ) )
					$edges = $parents;
				elseif( is_array( $children ) )
					$edges = $children;
				
				//
				// Export edges.
				//
				$ontology->ExportEdge( $data, $edges );
	
				//
				// Write root relations json.
				//
				$filename = "NODE.$root.RELATIONS.json";
				$json = JsonEncode( $data );
				file_put_contents( $filename, $json );
				echo( "$filename\n" );
				
				//
				// Iterate first level relations.
				//
				if( is_array( $parents ) )
				{
					foreach( $parents as $parent )
					{
						//
						// Init local storage.
						//
						$data = NULL;
						
						//
						// Get parent ID.
						//
						$id = $parent->offsetGet( kTAG_SUBJECT );
						
						//
						// Export node.
						//
						$ontology->ExportNode( $data, $id );
						
						//
						// Get node relations.
						//
						$parents_bis = $ontology->ResolveEdge( NULL, NULL, $id );
						$children_bis = $ontology->ResolveEdge( $id, NULL, NULL );
						if( is_array( $parents )
						 || is_array( $children ) )
						{
							//
							// Collect edges.
							//
							if( is_array( $parents_bis )
							 && is_array( $children_bis ) )
								$edges = array_merge( $parents_bis, $children_bis );
							elseif( is_array( $parents_bis ) )
								$edges = $parents_bis;
							elseif( is_array( $children_bis ) )
								$edges = $children_bis;
							
							//
							// Export edges.
							//
							$ontology->ExportEdge( $data, $edges );
				
							//
							// Write node relations json.
							//
							$filename = "NODE.$id.RELATIONS.json";
							$json = JsonEncode( $data );
							file_put_contents( $filename, $json );
							echo( "$filename\n" );
						}
					}
				}
				
				//
				// Iterate first level children.
				//
				if( is_array( $children ) )
				{
					foreach( $children as $child )
					{
						//
						// Init local storage.
						//
						$data = NULL;
						
						//
						// Get child ID.
						//
						$id = $child->offsetGet( kTAG_OBJECT );
						
						//
						// Export node.
						//
						$ontology->ExportNode( $data, $id );
						
						//
						// Get node relations.
						//
						$parents_bis = $ontology->ResolveEdge( NULL, NULL, $id );
						$children_bis = $ontology->ResolveEdge( $id, NULL, NULL );
						if( is_array( $parents )
						 || is_array( $children ) )
						{
							//
							// Collect edges.
							//
							if( is_array( $parents_bis )
							 && is_array( $children_bis ) )
								$edges = array_merge( $parents_bis, $children_bis );
							elseif( is_array( $parents_bis ) )
								$edges = $parents_bis;
							elseif( is_array( $children_bis ) )
								$edges = $children_bis;
							
							//
							// Export edges.
							//
							$ontology->ExportEdge( $data, $edges );
				
							//
							// Write node relations json.
							//
							$filename = "NODE.$id.RELATIONS.json";
							$json = JsonEncode( $data );
							file_put_contents( $filename, $json );
							echo( "$filename\n" );
						}
					}
				}
			}
		}

		//
		// Write root json.
		//
		$filename = "ROOTS.json";
		$json = JsonEncode( $root_data );
		file_put_contents( $filename, $json );
		echo( "$filename\n" );
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

?>
