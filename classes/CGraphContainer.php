<?php

/**
 * <i>CGraphContainer</i> class definition.
 *
 * This file contains the class definition of <b>CGraphContainer</b> which implements a
 * graph container.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 20/11/2012
 */

/*=======================================================================================
 *																						*
 *									CGraphContainer.php									*
 *																						*
 *======================================================================================*/

/**
 * Data types.
 *
 * This include file contains all default data type definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Types.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * <h4>Graph container</h4>
 *
 * This class wraps the {@link CConnection} class family around a graph database connection.
 *
 * Since in graph databases there is not really the concept of database and container, we
 * derive this class from {@link CContainer} and declare a bare minimum set of commands that
 * can be used to create graph nodes, relate them among each other and make basic path
 * operations. Concrete classes will implement a specific graph database engine and
 * class users can use the native connection to perform more custom operations.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
abstract class CGraphContainer extends CConnection
{
		

/*=======================================================================================
 *																						*
 *							PUBLIC NODE MANAGEMENT INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Create a new node</h4>
	 *
	 * This method should return a new node optionally filled with the provided attributes.
	 *
	 * The returned node is not supposed to be saved yet.
	 *
	 * @param array					$theProperties		Node properties.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function NewNode( $theProperties = NULL );

	 
	/*===================================================================================
	 *	SetNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Save a node</h4>
	 *
	 * This method should insert or update the provided node in the current graph.
	 *
	 * The method should return the node identifier if the operation was successful.
	 *
	 * If you provide the <tt>$theProperties</tt> parameter, these will be set in the node
	 * before it is saved.
	 *
	 * @param mixed					$theNode			Node to be saved.
	 * @param mixed					$theProperties		Node properties.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function SetNode( $theNode, $theProperties = NULL );

	 
	/*===================================================================================
	 *	GetNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Get an existing node</h4>
	 *
	 * This method should return a node corresponding to the provided identifier.
	 *
	 * If the second parameter is <tt>TRUE</tt> and the node was not found, the method
	 * should raise an exception.
	 *
	 * @param mixed					$theIdentifier		Node identifier.
	 * @param boolean				$doThrow			TRUE throw exception if not found.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function GetNode( $theIdentifier, $doThrow = FALSE );

	 
	/*===================================================================================
	 *	DelNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete an existing node</h4>
	 *
	 * This method should delete the provided node from the current graph.
	 *
	 * The method should return <tt>TRUE</tt> if the operation was successful and
	 * <tt>NULL</tt> if the provided identifier is not resolved.
	 *
	 * @param mixed					$theIdentifier		Node identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function DelNode( $theIdentifier );

		

/*=======================================================================================
 *																						*
 *							PUBLIC EDGE MANAGEMENT INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Create a new edge</h4>
	 *
	 * This method should return a new edge connecting the provided subject and object nodes
	 * via the provided predicate, holding the eventual provided properties.
	 *
	 * The returned edge is not supposed to be saved yet.
	 *
	 * @param mixed					$theSubject			Subject node.
	 * @param array					$thePredicate		Edge predicate.
	 * @param mixed					$theObject			Object node.
	 * @param array					$theProperties		Edge properties.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function NewEdge( $theSubject, $thePredicate, $theObject,
									  $theProperties = NULL );

	 
	/*===================================================================================
	 *	SetEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Save an edge</h4>
	 *
	 * This method should insert or update the provided edge in the current graph.
	 *
	 * The method should return the edge identifier if the operation was successful.
	 *
	 * @param mixed					$theEdge			Edge to be saved.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function SetEdge( $theEdge );

	 
	/*===================================================================================
	 *	GetEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Get an existing edge</h4>
	 *
	 * This method should return an edge corresponding to the provided identifier.
	 *
	 * @param mixed					$theIdentifier		Edge identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function GetEdge( $theIdentifier );

	 
	/*===================================================================================
	 *	DelEdge																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete an existing edge</h4>
	 *
	 * This method should delete the provided edge from the current graph.
	 *
	 * The method should return <tt>TRUE</tt> if the operation was successful and
	 * <tt>NULL</tt> if the provided identifier is not resolved.
	 *
	 * @param mixed					$theIdentifier		Edge identifier.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function DelEdge( $theIdentifier );

		

/*=======================================================================================
 *																						*
 *								PUBLIC PROPERTY INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	GetNodeProperties																*
	 *==================================================================================*/

	/**
	 * <h4>Get node properties</h4>
	 *
	 * This method can be used to retrieve the provided node's properties.
	 *
	 * The method accepts one parameter which can either be the node, or the node identifier
	 * for which we want the properties.
	 *
	 * If the node reference is not resolved, the method should return <tt>FALSE</tt>.
	 *
	 * If the provided node is not of the correct type, the method should raise an
	 * exception.
	 *
	 * @param mixed					$theNode			Node object or reference.
	 *
	 * @access public
	 * @return array				The node properties
	 */
	abstract public function GetNodeProperties( $theNode );

		

/*=======================================================================================
 *																						*
 *							PUBLIC STRUCTURE MANAGEMENT INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	GetNodeEdges																	*
	 *==================================================================================*/

	/**
	 * <h4>Get node edges</h4>
	 *
	 * This method can be used to retrieve the provided node's edges according to the
	 * provided sense.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theNode</tt>: The node of which we want the relationships.
	 *	<li><tt>$thePredicate</tt>: The eventual predicate or predicates references that
	 *		must be present in the relationships.
	 *	<li><tt>$theSense</tt>: The relationship direction:
	 *	 <ul>
	 *		<li><tt>{@link kTYPE_RELATION_IN}</tt>: Incoming relationships, or all edges
	 *			that point to the provided node.
	 *		<li><tt>{@link kTYPE_RELATION_OUT}</tt>: Outgoing relationships, or all edges
	 *			to which the current node points to.
	 *		<li><tt>{@link kTYPE_RELATION_ALL}</tt>: All relationships, or all edges that
	 *			point or to which the provided node points to.
	 *	 </ul>
	 * </ul>
	 *
	 * The method should return an array of edges.
	 *
	 * @param mixed					$theNode			Reference node.
	 * @param mixed					$thePredicate		Edge predicates filter.
	 * @param string				$theSense			Relationship sense.
	 *
	 * @access public
	 * @return mixed
	 */
	abstract public function GetNodeEdges( $theNode, $thePredicate = NULL,
													 $theSense = NULL );

	 

} // class CGraphContainer.


?>
