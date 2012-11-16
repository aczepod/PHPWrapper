<?php

/**
 * Neo4j test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the Neo4j library.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 28/10/2012
 */

/*=======================================================================================
 *																						*
 *									test_Neo4j.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
use	Everyman\Neo4j\Client,
	Everyman\Neo4j\Transport,
	Everyman\Neo4j\Node,
	Everyman\Neo4j\Relationship;


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Create connection.
	//
	$client = new Everyman\Neo4j\Client( 'localhost', 7474 );
	
	//
	// Create actors.
	//
	$kevin = new Node( $client );
	$kevin->setProperty( 'name', 'Kevin Bacon' )->save();
	$keanu = new Node( $client );
	$keanu->setProperty( 'name', 'Keanu Reeves' )->save();
	$jennifer = new Node( $client );
	$jennifer->setProperty( 'name', 'Jennifer Connelly' )->save();
	$laurence = new Node( $client );
	$laurence->setProperty( 'name', 'Laurence Fishburne' )->save();

	echo( '<h4>Created actors</h4>' );
	echo( $kevin->getId().'<pre>' ); print_r( $kevin->getProperties() ); echo( '</pre>' );
	echo( $keanu->getId().'<pre>' ); print_r( $keanu->getProperties() ); echo( '</pre>' );
	echo( $jennifer->getId().'<pre>' ); print_r( $jennifer->getProperties() ); echo( '</pre>' );
	echo( $laurence->getId().'<pre>' ); print_r( $laurence->getProperties() ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create movies.
	//
	$matrix = new Node( $client );
	$matrix->setProperty( 'title', 'The Matrix' )->save();
	$mysticRiver = new Node( $client );
	$mysticRiver->setProperty( 'title', 'Mystic River' )->save();
	$higherLearning = new Node( $client );
	$higherLearning->setProperty( 'title', 'Higher Learning' )->save();

	echo( '<h4>Created movies</h4>' );
	echo( $matrix->getId().'<pre>' ); print_r( $matrix->getProperties() ); echo( '</pre>' );
	echo( $mysticRiver->getId().'<pre>' ); print_r( $mysticRiver->getProperties() ); echo( '</pre>' );
	echo( $higherLearning->getId().'<pre>' ); print_r( $higherLearning->getProperties() ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create relationships.
	//
	$rels = Array();
	$rels[] = $keanu->relateTo( $matrix, 'Was in' )->save();
	$rels[] = $laurence->relateTo( $matrix, 'Played in' )->save();
	$rels[] = $kevin->relateTo( $mysticRiver, 'Was in' )->save();
	$rels[] = $laurence->relateTo( $mysticRiver, 'Played in' )->save();
	$rels[] = $laurence->relateTo( $higherLearning, 'Was in' )->save();
	$rels[] = $jennifer->relateTo( $higherLearning, 'Played in' )->save();

	echo( '<h4>Created relations</h4>' );
	foreach( $rels as $rel )
	{
		echo( '['.$rel->getId().']<pre>' );
		print_r( $rel->getStartNode()->getProperties() );
		echo( $rel->getType().'<br>' );
		print_r( $rel->getEndNode()->getProperties() );
		echo( '</pre>' );
	}
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Find links between actors.
	//
	echo( '<h5>$path = $keanu->findPathsTo($kevin)->setMaxDepth(12)->getSinglePath();</h5>' );
	$path = $keanu->findPathsTo($kevin)->setMaxDepth(12)->getSinglePath();
	foreach ($path as $i => $node)
	{
		echo( "$i".'<pre>' );
		print_r( $node->getProperties() );
		echo( '</pre>' );
	}
	echo( '<hr />' );
	echo( '<h5>$rels = $path->getRelationships();</h5>' );
	$rels = $path->getRelationships();
	foreach( $rels as $rel )
	{
		echo( '['.$rel->getId().']<pre>' );
		print_r( $rel->getStartNode()->getProperties() );
		echo( $rel->getType().'<br>' );
		print_r( $rel->getEndNode()->getProperties() );
		echo( '</pre>' );
	}
	echo( '<hr />' );
	echo( '<hr />' );
/*
	{
		if ($i % 2 == 0)
		{
			echo $node->getProperty('name');
			if ($i+1 != count($path))
			{
				echo " was in<br>";
			}
		}
		else
		{
			echo "\t" . $node->getProperty('title') . " with<br>";
		}
	}
*/
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
