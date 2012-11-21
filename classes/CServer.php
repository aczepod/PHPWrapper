<?php

/**
 * <i>CServer</i> class definition.
 *
 * This file contains the class definition of <b>CServer</b> which represents the
 * ancestor of all server objects in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *										CServer.php										*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * Graph.
 *
 * This includes the graph class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CGraphContainer.php" );

/**
 * <h4>Server object ancestor</h4>
 *
 * This <i>abstract</i> class is the ancestor of all server classes in this library, it
 * implements the interface and workflow that all concrete derived classes should implement.
 *
 * A server object holds a data member that represents a native connection to a server
 * environment, server objects have the ability to generate other connection derived objects
 * that have specific functionality, such as databases.
 *
 * The object is instantiated by providing the native server connection which is stored in a
 * data member of the object, the array part of the object can be used to store specific
 * attributes of the native server connection.
 *
 * The class also features a second property that can be used to store a concrete instance
 * of the {@link CGraphContainer} class using the {@link Graph()} member accessor method.
 * This property will be used by generated {@link CContainer} instances to write both to
 * data containers and graphs.
 *
 * The abstract class must be overloaded by concrete classes that implement a native server
 * object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
abstract class CServer extends CConnection
{
	/**
	 * Graph container.
	 *
	 * This data member holds the graph container.
	 *
	 * @var CGraphContainer
	 */
	 protected $mGraph = NULL;

		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__destruct																		*
	 *==================================================================================*/

	/**
	 * <h4>Destructor</h4>
	 *
	 * We implement the destructor to get rid of the graph: the Neo4j PHP interface, for
	 * instance, has closures that cannot be serialised, so we need to reset the graph
	 * before destroying the object.
	 *
	 * @access public
	 */
	public function __destruct()
	{
		//
		// Reset graph.
		//
		if( $this->Graph() !== NULL )
			$this->Graph( FALSE );
		
	} // Destructor.

	

/*=======================================================================================
 *																						*
 *								PUBLIC CONNECTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Database																		*
	 *==================================================================================*/

	/**
	 * <h4>Generate a database object</h4>
	 *
	 * This method can be used to return a database object belonging to the current server.
	 *
	 * The parameter will be used by concrete instances to select which database to return,
	 * the goal of this class is only to declare the public interface, which must be
	 * implemented by specialised derived classes.
	 *
	 * <i>Note: This method should also take care of setting the {@link kOFFSET_NAME},
	 * {@link kOFFSET_GRAPH} and {@link kOFFSET_PARENT} offsets of the generated object.</i>
	 *
	 * @param mixed					$theDatabase		Database selector.
	 *
	 * @access public
	 * @return mixed				The database object.
	 *
	 * @see kOFFSET_NAME kOFFSET_GRAPH kOFFSET_PARENT
	 */
	abstract public function Database( $theDatabase = NULL );

	 
	/*===================================================================================
	 *	Graph																			*
	 *==================================================================================*/

	/**
	 * <h4>Set, retrieve or delete a graph container instance</h4>
	 *
	 * The first parameter can take the following values:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>{@link CGraphContainer}</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * <i>Note: If you generate databases from the server and containers from these
	 * databases, the graph will be passed on to those objects: if you afterwards change the
	 * graph, this will not be reflected in those objects.</i>
	 *
	 * @param CGraphContainer		$theValue			Graph container.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> graph container.
	 *
	 * @uses ManageProperty()
	 */
	public function Graph( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check graph type.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			if( ! ($theValue instanceof CGraphContainer) )
				throw new Exception
					( "Invalid graph container type",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // New graph.
		
		return ManageProperty( $this->mGraph, $theValue, $getOld );					// ==>
	
	} // Graph.

	 

} // class CServer.


?>
