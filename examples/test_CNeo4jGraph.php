<?php

/**
 * {@link CNeo4jGraph.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CNeo4jGraph class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CNeo4jContainer.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CNeo4jGraph.php" );


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Create container.
	//
	echo( '<hr />' );
	echo( '<h4>Create test container</h4>' );
	echo( '$graph = new CNeo4jGraph();<br />' );
	$graph = new CNeo4jGraph();
	echo( '<pre>' ); print_r( $graph ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Create node.
	//
	echo( '<h4>Create node</h4>' );
	echo( '$node = $graph->NewNode( array( "NAME" => "Milko", "SURNAME" => "Škofič" ) );<br />' );
	$node = $graph->NewNode( array( "NAME" => "Milko", "SURNAME" => "Škofič" ) );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Save node.
	//
	echo( '<h4>Save node</h4>' );
	echo( '$ok = $graph->SetNode( $node );<br />' );
	$ok = $graph->SetNode( $node );
	echo( 'Result::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( 'Node:<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Update node.
	//
	echo( '<h4>Update node</h4>' );
	echo( '$node->setProperty( "MIDDLE", "Andrea" );<br />' );
	$node->setProperty( "MIDDLE", "Andrea" );
	echo( '$ok = $graph->SetNode( $node );<br />' );
	$ok = $graph->SetNode( $node );
	echo( 'Result::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( 'Node:<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get node.
	//
	echo( '<h4>Get node</h4>' );
	echo( '$node = $graph->GetNode( $ok );<br />' );
	$node = $graph->GetNode( $ok );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Delete node.
	//
	echo( '<h4>Delete node</h4>' );
	echo( '$ok = $graph->DelNode( $ok );<br />' );
	$ok = $graph->DelNode( $ok );
	echo( 'Result::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( 'Node:<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Check if deleted.
	//
	echo( '<h4>Check if deleted</h4>' );
	echo( '$node = $graph->GetNode( $node->getId() );<br />' );
	$node = $graph->GetNode( $node->getId() );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create nodes.
	//
	echo( '<h4>Create nodes (A, B, C)</h4>' );
	$nodeA = $graph->Connection()->makeNode( array( "NAME" => "A" ) )->save();
	$nodeB = $graph->Connection()->makeNode( array( "NAME" => "B" ) )->save();
	$nodeC = $graph->Connection()->makeNode( array( "NAME" => "C" ) )->save();
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create edge 1.
	//
	echo( '<h4>Create edge 1</h4>' );
	echo( '$edge1 = $graph->NewEdge( $nodeA, "FATHER-OF", $nodeB, array( "NAME" => "Edge 1" ) );<br />' );
	$edge1 = $graph->NewEdge( $nodeA, "FATHER-OF", $nodeB, array( "NAME" => "Edge 1" ) );
	echo( '<pre>' ); print_r( $edge1 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Create edge 2.
	//
	echo( '<h4>Create edge 2</h4>' );
	echo( '$edge2 = $graph->NewEdge( $nodeB, "FATHER-OF", $nodeC, array( "NAME" => "Edge 2" ) );<br />' );
	$edge2 = $graph->NewEdge( $nodeB, "FATHER-OF", $nodeC, array( "NAME" => "Edge 2" ) );
	echo( '<pre>' ); print_r( $edge2 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Create edge 3.
	//
	echo( '<h4>Create edge 3</h4>' );
	echo( '$edge3 = $graph->NewEdge( $nodeA->getId(), "COUSIN-OF", $nodeC->getId(), array( "NAME" => "Edge 3" ) );<br />' );
	$edge3 = $graph->NewEdge( $nodeA->getId(), "COUSIN-OF", $nodeC->getId(), array( "NAME" => "Edge 3" ) );
	echo( '<pre>' ); print_r( $edge3 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Create edge 4.
	//
	echo( '<h4>Create edge 4</h4>' );
	echo( '$edge4 = $graph->NewEdge( $nodeC, "SON-OF", $nodeA, array( "NAME" => "Edge 4" ) );<br />' );
	$edge4 = $graph->NewEdge( $nodeC, "SON-OF", $nodeA, array( "NAME" => "Edge 4" ) );
	echo( '<pre>' ); print_r( $edge4 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Save edges.
	//
	echo( '<h4>Save edges</h4>' );
	echo( '$ok = $graph->SetEdge( $edge1 );<br />' );
	$ok = $graph->SetEdge( $edge1 );
	echo( 'Edge 1::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '$ok = $graph->SetEdge( $edge2 );<br />' );
	$ok = $graph->SetEdge( $edge2 );
	echo( 'Edge 2::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '$ok = $graph->SetEdge( $edge3 );<br />' );
	$ok = $graph->SetEdge( $edge3 );
	echo( 'Edge 3::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '$ok = $graph->SetEdge( $edge3 );<br />' );
	$ok = $graph->SetEdge( $edge4 );
	echo( 'Edge 4::<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get edge.
	//
	echo( '<h4>Get edge</h4>' );
	echo( '$edge = $graph->GetEdge( $ok );<br />' );
	$edge = $graph->GetEdge( $ok );
	echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get node incoming edges.
	//
	echo( '<h4>Get node incoming edges</h4>' );
	echo( '$edges = $graph->GetNodeEdges( $nodeC, NULL, kTYPE_RELATION_IN );<br />' );
	$edges = $graph->GetNodeEdges( $nodeC, NULL, kTYPE_RELATION_IN );
	foreach( $edges as $edge )
		echo( $edge->getStartNode()->getId()." ".$edge->getType()." ".$edge->getEndNode()->getId()."<br>" );
	echo( '<hr />' );

	//
	// Get node outgoing edges.
	//
	echo( '<h4>Get node outgoing edges</h4>' );
	echo( '$edges = $graph->GetNodeEdges( $nodeC, NULL, kTYPE_RELATION_OUT );<br />' );
	$edges = $graph->GetNodeEdges( $nodeC, NULL, kTYPE_RELATION_OUT );
	foreach( $edges as $edge )
		echo( $edge->getStartNode()->getId()." ".$edge->getType()." ".$edge->getEndNode()->getId()."<br>" );
	echo( '<hr />' );

	//
	// Get all node edges.
	//
	echo( '<h4>Get all node edges</h4>' );
	echo( '$edges = $graph->GetNodeEdges( $nodeC, NULL, kTYPE_RELATION_ALL );<br />' );
	$edges = $graph->GetNodeEdges( $nodeC, NULL, kTYPE_RELATION_ALL );
	foreach( $edges as $edge )
		echo( $edge->getStartNode()->getId()." ".$edge->getType()." ".$edge->getEndNode()->getId()."<br>" );
	echo( '<hr />' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( Exception $error )
{
	echo( '<h3><font color="red">Unexpected exception</font></h3>' );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
