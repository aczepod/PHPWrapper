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
	 *
	 * @uses Connection()
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
	 * @throws Exception
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
	 * This method can be used to instantiate a new {@link COntologyTerm} instance, the
	 * method allows creating a term including the label and description. The method expects
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: The term local or global identifier, if you provide
	 *		<tt>NULL</tt>, the method will raise an exception.
	 *	<li><tt>$theNamespace</tt>: The term namespace, it can be provided in the following
	 *		forms:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This indicates that the term has no namespace.
	 *		<li><tt>{@link COntologyTerm}</tt>: This type is expected to be the namespace
	 *			term object.
	 *		<li><i>other</i>: Any other type is interpreted as the term native identifier;
	 *			if the namespace term cannot be found, the method will raise an exception.
	 *	 </ul>
	 *		Note that if you want to provide a global identifier you should do so using the
	 *		first parameter.
	 *	<li><tt>$theLabel</tt>: The term label string, this parameter is optional.
	 *	<li><tt>$theDescription</tt>: The term description string this parameter is optional.
	 *	<li><tt>$theLanguage</tt>: The language code of both the label and the description.
	 * </ul>
	 *
	 * The method will first attempt to locate a term matching the global identifier
	 * stemming from the provided parameters, if it matches one, this will be returned as
	 * found, regardless of the provided parameters. If the term was not found, the method
	 * will return a new uncommitted object with the provided attributes.
	 *
	 * @param string				$theIdentifier		Term local identifier.
	 * @param mixed					$theNamespace		Namespace term reference.
	 * @param string				$theLabel			Term label.
	 * @param string				$theDescription		Term description.
	 * @param string				$theLanguage		Label and description language code.
	 *
	 * @access public
	 * @return COntologyTerm		New or found term.
	 *
	 * @throws Exception
	 */
	public function NewTerm( $theIdentifier, $theNamespace = NULL,
											 $theLabel = NULL, $theDescription = NULL,
											 $theLanguage = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Check identifier.
			//
			if( $theIdentifier !== NULL )
			{
				//
				// Normalise local identifier.
				//
				$identifier = (string) $theIdentifier;
				
				//
				// Handle namespace.
				//
				if( $theNamespace !== NULL )
				{
					//
					// Provided namespace identifier.
					//
					if( ! ($theNamespace instanceof CPersistentObject) )
					{
						//
						// Load namespace object.
						//
						$theNamespace = COntologyTerm::NewObject
											( $this->Connection(), $theNamespace );
						if( $theNamespace === NULL )
							throw new Exception
								( "Namespace not found",
								  kERROR_NOT_FOUND );							// !@! ==>
					
					} // Provided namespace identifier.
					
					//
					// Assume namespace has global identifier.
					//
					
					//
					// Build global identifier.
					//
					$identifier = $theNamespace[ kOFFSET_GID ]
								 .kTOKEN_NAMESPACE_SEPARATOR
								 .$identifier;
				
				} // Provided namespace.
				
				//
				// Build term native identifier.
				//
				$id = COntologyTerm::_id( $identifier, $this->Connection() );
				
				//
				// Match term.
				//
				$term = COntologyTerm::NewObject
							( $this->Connection(),
							  COntologyTerm::_id( $identifier, $this->Connection() ) );
				if( $term !== NULL )
					return $term;													// ==>
				
				//
				// Build new term.
				//
				$term = new COntologyTerm();
				$term->NS( $theNamespace );
				$term->LID( $theIdentifier );
				if( $theLabel !== NULL )
					$term->Label( $theLanguage, $theLabel );
				if( $theDescription !== NULL )
					$term->Description( $theLanguage, $theDescription );
				
				return $term;														// ==>
			
			} // Provided local or global identifier.
			
			throw new Exception
				( "Missing term identifier",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // NewTerm.

	 
	/*===================================================================================
	 *	NewNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a node</h4>
	 *
	 * This method can be used to instantiate a {@link COntologyNode} instance from a term
	 * or from a node identifier. The method accepts a single parameter that may take the
	 * following values:
	 *
	 * <ul>
	 *	<li><tt>{@link COntologyTerm}</tt>: In this case the method will assume you want to
	 *		retrieve the term or terms that refer to the provided term object. If any nodes
	 *		match, the method will return an array with the list of matching objects; if no
	 *		nodes match, the method will return a new node object pointing to the provided
	 *		term.
	 *	<li><tt>integer</tt>: In this case the method assumes that the parameter represents
	 *		a node identifier and will attempt to retrieve it: if found it will return it;
	 *		if not, it will return <tt>NULL</tt>.
	 *	<li><tt>string</tt>: Any other type will be cast to a string and will be interpreted
	 *		as the term's global identifier: the method will then follow the same rules as
	 *		if a term object was provided.
	 * </ul>
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()} and if
	 * the provided parameter is <tt>NULL</tt>.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 *
	 * @access public
	 * @return mixed				New, found node or nodes.
	 *
	 * @throws Exception
	 */
	public function NewNode( $theIdentifier )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Check identifier.
			//
			if( $theIdentifier !== NULL )
			{
				//
				// Handle node identifier.
				//
				if( is_integer( $theIdentifier ) )
					return COntologyNode::NewObject
								( $this->Connection(), $theIdentifier );			// ==>
							
				//
				// Handle term object.
				//
				if( $theIdentifier instanceof COntologyTerm )
				{
					//
					// Handle new term.
					//
					if( ! $theIdentifier->offsetExists( kOFFSET_NID ) )
					{
						$node = new COntologyNode();
						$node->Term( $theIdentifier );
						
						return $node;												// ==>
					
					} // New term ==> new node.
					
					//
					// Get term identifier.
					//
					$theIdentifier = $theIdentifier->offsetGet( kOFFSET_NID );
				
				} // Provided term object.
				
				//
				// Handle term global identifier.
				//
				else
					$theIdentifier
						= COntologyTerm::_id
							( $theIdentifier, $this->Connection() );
				
			} // Provided local or global identifier.
			
			throw new Exception
				( "Missing node identifier or term",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // NewNode.

		

/*=======================================================================================
 *																						*
 *								PUBLIC OPERATIONS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Insert																			*
	 *==================================================================================*/

	/**
	 * <h4>Insert an element</h4>
	 *
	 * This method can be used to insert a term, node, edge or tag into the ontology. The
	 * method should only be used on new items, since it will raise an exception on
	 * duplicates.
	 *
	 * The following types are supported: {@link COntologyTerm}, {@link COntologyNode},
	 * {@link COntologyEdge} and {@link COntologyTag}.
	 *
	 * The method will return the object's native unique identifier attribute
	 * ({@link kOFFSET_NID}), or raise an exception if an error occurs.
	 *
	 * @param mixed					$theElement			Term, node, edge or tag.
	 *
	 * @access public
	 * @return mixed				The object's native identifier.
	 *
	 * @throws Exception
	 */
	public function Insert( $theElement )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Check object type.
			//
			if( ($theElement instanceof COntologyTerm)
			 || ($theElement instanceof COntologyNode)
			 || ($theElement instanceof COntologyEdge)
			 || ($theElement instanceof COntologyTag) )
				return $theElement->Insert( $this->Connection() );					// ==>
			
			throw new Exception
				( "Unsupported element type",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is initialised.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // Insert.

	 

} // class COntology.


?>
