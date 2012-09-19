<?php

/**
 * <i>COntology</i> class definition.
 *
 * This file contains the class definition of <b>COntology</b> which represents a high
 * level ontology wrapper.
 *
 * This class derives from {@link CConnection} and expects a {@link CDatabase} instance
 * in its constructor. The class features a property, {@link Root()}, which represents the
 * root or ontology node.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *																						*
 *									COntology.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "COntology.inc.php" );

/**
 * Terms.
 *
 * This includes the term class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTerm.php" );

/**
 * Nodes.
 *
 * This includes the node class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyNode.php" );

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
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * <h3>Ontology object</h3>
 *
 * This class represents an object whose duty is to provide a high level interface for
 * managing an ontology.
 *
 * The class features a series of public methods that can be used to instantiate and relate
 * ontology related objects.
 *
 * One instantiates the object witha {@link CDatabase} instance which refers to the database
 * in which the ontology resides.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 */
class COntology extends CConnection
{
		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return connection name</h4>
	 *
	 * We implement this method by letting the connection object take care of returning its
	 * name.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()				{	return (string) $this->Connection();	}

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Connection																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage native connection</h4>
	 *
	 * We overload this method to ensure the provided connection is a {@link CDatabase}
	 * instance.
	 *
	 * @param mixed					$theValue			Native connection or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native connection.
	 *
	 * @uses _isInited()
	 * @uses ManageProperty()
	 */
	public function Connection( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check connection type.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE)
		 && (! ($theValue instanceof CDatabase)) )
			throw new Exception
				( "Invalid connection type",
				  kERROR_PARAMETER );											// !@! ==>
		
		return parent::Connection( $theValue, $getOld );							// ==>

	} // Connection.

		

/*=======================================================================================
 *																						*
 *								PUBLIC COMPONENTS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewTerm																			*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a term</h4>
	 *
	 * This method can be used to instantiate a new {@link COntologyTerm} instance, it
	 * expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theNamespace</tt>: The term namespace, it can be provided in two forms:
	 *	 <ul>
	 *		<li><tt>string</tt>: A string is interpreted as the namespace global identifier.
	 *		<li><tt>COntologyTerm</tt>: This type is expected to be the namespace term
	 *			object.
	 *		<li><i>other</i>: Any other type is interpreted as the term native identifier.
	 *	 </ul>
	 *	<li><tt>$theCode</tt>: The term code, it can be provided in two forms:
	 *	 <ul>
	 *		<li><tt>string</tt>: A string is interpreted as the term local identifier.
	 *		<li><i>other</i>: Any other type is interpreted as the term native identifier.
	 *	 </ul>
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing nodes; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * When providing a new node, this method will insert it if not {@link _IsCommitted()}.
	 * The method will also add the {@link kNODE_KIND_ROOT} kind to the node and refresh it.
	 *
	 * @param mixed					$theValue			Root node or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native connection.
	 *
	 * @uses _isInited()
	 * @uses ManageProperty()
	 */
	public function Root( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle new node.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Check node type.
			//
			if( ! ($theValue instanceof COntologyNode) )
				throw new Exception
					( "Invalid root node",
					  kERROR_PARAMETER );										// !@! ==>
			
			//
			// Check ontology connection.
			//
			$connection = $this->Connection();
			if( $connection === NULL )
				throw new Exception
					( "Missing ontology container",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Set root kind.
			//
			$theValue->Kind( kNODE_KIND_ROOT, TRUE );
			
			//
			// Commit node.
			//
			if( ! $theValue->_IsCommitted() )
				$theValue->Insert( $connection );
			
			//
			// Refresh node.
			//
			$theValue->Restore( $connection );
		
		} // Provided new node.
		
		//
		// Manage property.
		//
		$save = ManageProperty( $this->mOntology, $theValue, $getOld );
		
		//
		// Update inited status.
		//
		$this->_isInited( $this->_Ready() );
		
		return $save;																// ==>

	} // Root.
		


/*=======================================================================================
 *																						*
 *								PROTECTED STATUS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Ready																			*
	 *==================================================================================*/

	/**
	 * <h4>Determine if the object is ready</h4>
	 *
	 * In this class we tie the {@link _IsInited()} status to the presence or absence of the
	 * root or ontology node.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return ( $this->mOntology !== NULL );									// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class COntology.


?>
