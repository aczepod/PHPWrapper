<?php

/**
 * <i>COntologyIterator</i> class definition.
 *
 * This file contains the class definition of <b>COntologyIterator</b> which represents an
 * ontology iterator.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 01/03/2013
 */

/*=======================================================================================
 *																						*
 *									COntologyIterator.php								*
 *																						*
 *======================================================================================*/

/**
 * Terms.
 *
 * This includes the term class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTerm.php" );

/**
 * Master vertices.
 *
 * This includes the master vertex class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyMasterVertex.php" );

/**
 * Alias vertices.
 *
 * This includes the alias vertex class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyAliasVertex.php" );

/**
 * Edges.
 *
 * This includes the edge class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyEdge.php" );

/**
 * Tags.
 *
 * This includes the tag class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTag.php" );

/**
 * Databases.
 *
 * This includes the database class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDatabase.php" );

/**
 * <h4>Ontology object</h4>
 *
 * This class represents an object whose duty is to provide a high level interface for
 * managing ontologies.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntologyIterator extends Iterator
{
	/**
	 * Database connection.
	 *
	 * This data member holds the database connection.
	 *
	 * @var CDatabase
	 */
	 protected $mDatabase = NULL;

	/**
	 * Root node.
	 *
	 * This data member holds the parent node.
	 *
	 * @var COntologyNode
	 */
	 protected $mRoot = NULL;

	/**
	 * Predicates.
	 *
	 * This data member holds the list of predicate terms.
	 *
	 * @var array
	 */
	 protected $mPredicates = NULL;

	/**
	 * Direction.
	 *
	 * This data member holds the direction of the relationships: <tt>TRUE</tt> means
	 * incoming relationships, <tt>FALSE</tt> means outgoing.
	 *
	 * @var boolean
	 */
	 protected $mDirection = NULL;

	/**
	 * List.
	 *
	 * This data member holds the current nodes list.
	 *
	 * @var array
	 */
	 protected $mList = NULL;

	/**
	 * Cache.
	 *
	 * This data member holds the traversal cache.
	 *
	 * @var ArrayObject
	 */
	 protected $mCache = NULL;

		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__construct																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate class</h4>
	 *
	 * You instantiate the class by providing a database, root node, a list of predicates
	 * and a direction for traversing the graph:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: This parameter represents either the database
	 *		connection or another iterator from which all other parameters are to be
	 *		transferred.
	 *	<li><tt>$theRoot</tt>: This parameter represents either the root node object or its
	 *		reference; if the reference resolves into an array of nodes, the method will
	 *		choose the master node.
	 *	<li><tt>$thePredicates</tt>: This parameter represents the list of predicate term
	 *		objects or references.
	 *	<li><tt>$inComing</tt>: This parameter represents the direction in which the
	 *		graph is to be traversed, if <tt>TRUE</tt> it means that the graph is to be
	 *		traversed using incoming relationshipd; if not, it means that the graph should
	 *		be traversed using outgoing relationships.
	 * </ul>
	 *
	 * @param mixed					$theConnection		Database or iterator.
	 * @param mixed					$theRoot			Root node object or reference.
	 * @param array					$thePredicates		List of predicate term objects or
	 *													references.
	 * @param boolean				$inComing			TRUE incoming, FALSE outgoing.
	 *
	 * @access public
	 */
	public function __construct( $theConnection, $theRoot, $thePredicates = NULL,
														   $inComing = TRUE )
	{
		//
		// Handle iterator.
		//
		if( $theConnection instanceof self )
		{
			//
			// Copy database.
			//
			$this->Database( $theConnection->mDatabase );
		
			//
			// Copy root.
			//
			$this->mRoot = $theConnection->mRoot;
		
			//
			// Copy predicates.
			//
			$this->mPredicates = $theConnection->mPredicates;
		
			//
			// Copy direction.
			//
			$this->mDirection = $theConnection->mDirection;
		
			//
			// Copy cache.
			//
			$this->mCache = $theConnection->mCache;
		
		} // Provided iterator.
		
		//
		// Handle database.
		//
		else
			$this->Database( $theConnection );
		
		//
		// Handle root.
		//
		if( ! ($theRoot instanceof COntologyNode) )
			$theRoot = COntologyNode::Resolve( $this->mDatabase, $theRoot, TRUE );
		
		//
		// Handle predicates.
		//
		if( $thePredicates !== NULL )
		{
			//
			// Validate.
			//
			if( ! is_array( $thePredicates ) )
				$thePredicates = array( $thePredicates );
			foreach( $thePredicates as $key => $value )
				$thePredicates[ $key ]
					= COntologyTerm::Resolve( $this->mDatabase, $value, NULL, TRUE );
			
			//
			// Set.
			//
			$this->mPredicates = $thePredicates;
		
		} // Provided predicates.
		
		elseif( ! is_array( $this->mPredicates ) )
			throw new Exception
				( "Missing predicates parameter",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Handle cache.
		//
		if( ! ($this->mCache instanceof ArrayObject) )
			$this->mCache = new ArrayObject();
		
	} // Constructor.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Database																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage database connection</h4>
	 *
	 * This method can be used to set the database connection, it accepts a parameter that
	 * represents the database, or <tt>NULL</tt>, to retrieve its value, and a boolean
	 * switch to determine whether the method should return the old or new value when
	 * replacing it; by default the method returns the new one.
	 *
	 * The database cannot be deleted or cleared.
	 *
	 * @param mixed					$theValue			Native connection or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> database connection.
	 *
	 * @throws Exception
	 */
	public function Database( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Return current value.
		//
		if( $theValue === NULL )
			return $this->mDatabase;												// ==>
		
		//
		// Save old value.
		//
		$save = $this->mDatabase;
		
		//
		// Check database type.
		//
		if( ! ($theValue instanceof CDatabase) )
			throw new Exception
				( "Invalid database connection type",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Set database.
		//
		$this->mDatabase = $theValue;
		
		return ( $getOld ) ? $save													// ==>
						   : $this->mDatabase;										// ==>

	} // Database.

	 
	/*===================================================================================
	 *	Root																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage database connection</h4>
	 *
	 * This method can be used to set the database connection, it accepts a parameter that
	 * represents the database, or <tt>NULL</tt>, to retrieve its value, and a boolean
	 * switch to determine whether the method should return the old or new value when
	 * replacing it; by default the method returns the new one.
	 *
	 * The database cannot be deleted or cleared.
	 *
	 * @param mixed					$theValue			Native connection or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> database connection.
	 *
	 * @throws Exception
	 */
	public function Database( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Return current value.
		//
		if( $theValue === NULL )
			return $this->mDatabase;												// ==>
		
		//
		// Save old value.
		//
		$save = $this->mDatabase;
		
		//
		// Check database type.
		//
		if( ! ($theValue instanceof CDatabase) )
			throw new Exception
				( "Invalid database connection type",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Set database.
		//
		$this->mDatabase = $theValue;
		
		return ( $getOld ) ? $save													// ==>
						   : $this->mDatabase;										// ==>

	} // Database.

	 

} // class COntologyIterator.


?>
