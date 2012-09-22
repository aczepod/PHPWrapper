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
	 * This method can be used to create a new term, or to retrieve an existing term.
	 *
	 * The method will first attempt to locate a term that corresponds to the identifier
	 * generated with the provided attributes, if the term is found, it will be returned
	 * and the other parameters will be ignored. If the term is not found, a new one will
	 * be instantiated <i>and committed before being returned</i>.
	 *
	 * The main reason for committing objects immediately is that once an object is saved,
	 * we will only issue attributes modifications, we shall never load the whole object and
	 * replace it. This is necessary in order to prevent the need of complex locking
	 * mechanisms, since ontology elements share many references among each other. For this
	 * reason you should first call {@link ResolveTerm()} before calling this method.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: This parameter represents the term local identifier.
	 *	<li><tt>$theNamespace</tt>: The term namespace, it can be provided in several ways:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This indicates that the term has no namespace.
	 *		<li><tt>{@link COntologyTerm}</tt>: This represents the term namespace object.
	 *		<li><i>other</i>: Any other type is interpreted as the namespace native
	 *			identifier; if the namespace cannot be found, the method will raise an
	 *			exception.
	 *	 </ul>
	 *	<li><tt>$theLabel</tt>: The term label string, this parameter is optional.
	 *	<li><tt>$theDescription</tt>: The term description string this parameter is optional.
	 *	<li><tt>$theLanguage</tt>: The language code of both the label and the description.
	 * </ul>
	 *
	 * The method will first attempt to locate an existing term. if that fails, it will
	 * create a new one, commit it and return it.
	 *
	 * @param string				$theIdentifier		Term local identifier.
	 * @param mixed					$theNamespace		Term namespace reference.
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
				// Handle namespace.
				//
				if( $theNamespace !== NULL )
				{
					//
					// Resolve namespace.
					// Notice we expect an exception if not resolved.
					//
					if( (! ($theNamespace instanceof COntologyTerm))	// Not an object,
					 || $theNamespace->_IsCommitted() )					// or committed.
						$theNamespace = $this->ResolveTerm( $theNamespace, NULL, TRUE );
					
					//
					// Handle new namespace object.
					//
					else	// Uncommitted object.
					{
						//
						// Create term.
						//
						$term = new COntologyTerm();
						$term->NS( $theNamespace );
						$term->LID( $theIdentifier );
						if( $theLabel !== NULL )
							$term->Label( $theLanguage, $theLabel );
						if( $theDescription !== NULL )
							$term->Description( $theLanguage, $theDescription );
						
						//
						// Save term.
						//
						$term->Insert( $this->Connection() );
						
						return $term;												// ==>
					
					} // New namespace.
					
					//
					// Locate term.
					//
					$term = COntologyTerm::NewObject(
								$this->Connection(),
								COntologyTerm::_id(
									COntologyTerm::TermCode(
										$theIdentifier,
										$theNamespace->offsetGet( kOFFSET_GID ) ),
									$this->Connection() ) );
					if( $term !== NULL )
						return $term;												// ==>

					//
					// Create term.
					//
					$term = new COntologyTerm();
					$term->NS( $theNamespace );
					$term->LID( $theIdentifier );
					if( $theLabel !== NULL )
						$term->Label( $theLanguage, $theLabel );
					if( $theDescription !== NULL )
						$term->Description( $theLanguage, $theDescription );
					
					//
					// Save term.
					//
					$term->Insert( $this->Connection() );
					
					return $term;													// ==>
				
				} // Provided namespace.
				
				//
				// Look for term.
				//
				$term = $this->ResolveTerm( $theIdentifier );
				if( $term !== NULL )
					return $term;													// ==>

				//
				// Create term.
				//
				$term = new COntologyTerm();
				$term->LID( $theIdentifier );
				if( $theLabel !== NULL )
					$term->Label( $theLanguage, $theLabel );
				if( $theDescription !== NULL )
					$term->Description( $theLanguage, $theDescription );
				
				//
				// Save term.
				//
				$term->Insert( $this->Connection() );
				
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
	 * This method can be used to instantiate a new node, retrieve an existing node by
	 * identifier, or retrieve the list of nodes matching a term.
	 *
	 * The method expects a single parameter that may represent either the node identifier,
	 * or the term object or identifier:
	 *
	 * <ul>
	 *	<li><tt>integer</tt>: In this case the method assumes that the parameter represents
	 *		the node identifier: it will attempt to retrieve the node, if it is not found,
	 *		the method will return <tt>NULL</tt>.
	 *	<li><tt>{@link COntologyTerm}</tt>: In this case the method will check if the term
	 *		exists:
	 *	 <ul>
	 *		<li><i>Term exists</i>: The method will locate all nodes that relate to that
	 *			term and return the array of found nodes, which will be empty if there are
	 *			no matches.
	 *		<li><i>Term is new</i>: The method will return a new node related to that term.
	 *	 </ul>
	 *	<li><i>other</i>: Any other type will be interpreted as the term's native
	 *		identifier: the method will locate all nodes that relate to that term and return
	 *		the array of found nodes, which will be empty if there are no matches.
	 * </ul>
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()} and if
	 * the provided parameter is <tt>NULL</tt>.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 *
	 * @access public
	 * @return mixed				New node, found node or nodes list.
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
					if( ! $theIdentifier->_IsCommitted() )
					{
						//
						// Instantiate new term.
						//
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
				
				//
				// Resolve container.
				//
				$container = COntologyNode::ResolveClassContainer
								( $this->Connection(), TRUE );
				
				//
				// Create query.
				//
				$query = $container->NewQuery();
				
				//
				// Add statement.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kOFFSET_TERM, $theIdentifier, kTYPE_BINARY ) );
						
				//
				// Perform query.
				//
				$rs = $container->Query( $query );
				if( $rs->count() )
				{
					//
					// Return list of nodes.
					//
					$list = Array();
					foreach( $rs as $document )
						$list[] = CPersistentObject::DocumentObject( $document );
					
					return $list;													// ==>
				
				} // Found at least one node.
				
				return NULL;														// ==>
				
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
 *								PUBLIC RESOLUTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ResolveTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Find a term</h4>
	 *
	 * This method can be used to locate a term given the attributes that comprise its
	 * identifier.
	 *
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: This parameter can be the term native or global
	 *		identifier, if the namespace is not provided, or the local identifier if the
	 *		namespace is provided:
	 *	 <ul>
	 *		<li><i>Namespace provided:</i> The method will try to resolve the namespace and
	 *			combine the namespace global identifier with the provided local identifier
	 *			to locate the term.
	 *		<li><i>Namespace not provided:</i> If the namespace was not provided, the
	 *			method will perform the following queries in order:
	 *		 <ul>
	 *			<li><i>Native identifier:</i> The method will use the parameter as the
	 *				native identifier.
	 *			<li><i>Global identifier:</i> The method will use the term's
	 *				{@link COntologyTerm::_id()} method to convert the global identifier
	 *				into a native identifier.
	 *		 </ul>
	 *	 </ul>
	 *	<li><tt>$theNamespace</tt>: The term namespace:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This indicates that either the term has no namespace, which
	 *			means that the first parameter must either be the native or global
	 *			identifier, or that the first parameter is all that is needed to locate the
	 *			term.
	 *		<li><tt>{@link COntologyTerm}</tt>: This type is expected to be the namespace
	 *			term object:
	 *		 <ul>
	 *			<li><i>Object is committed:</i> The method will use the namespace's global
	 *				identifier and concatenate it to the first parameter.
	 *			<li><i>Object is not committed:</i> The method will use the namespace's
	 *				global identifier; if that is missing, the method will either raise an
	 *				exception, or return <tt>NULL</tt>, depending on the third parameter.
	 *		 </ul>
	 *		<li><i>other</i>: Any other type is interpreted as the term native identifier;
	 *			if the namespace term cannot be found, the method will either raise an
	 *			exception, or return <tt>NULL</tt>, depending on the third parameter.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If <tt>TRUE</tt>, any failure to resolve the term or its
	 *			namespace, will raise an exception.
	 * </ul>
	 *
	 * The method will return the found term, <tt>NULL</tt> if not found, or raise an
	 * exception if the third parameter is <tt>TRUE</tt>.
	 *
	 * @param string				$theIdentifier		Term local identifier.
	 * @param mixed					$theNamespace		Namespace term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @access public
	 * @return COntologyTerm		New or found term.
	 *
	 * @throws Exception
	 */
	public function ResolveTerm( $theIdentifier, $theNamespace = NULL, $doThrow = FALSE )
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
				// Handle namespace.
				//
				if( $theNamespace !== NULL )
				{
					//
					// Locate namespace.
					//
					if( ! ($theNamespace instanceof CPersistentObject) )
					{
						//
						// Locate namespace.
						//
						$theNamespace = $this->ResolveTerm( $theNamespace, NULL, $doThrow );
						if( $theNamespace === NULL )
							return NULL;											// ==>
					
					} // Provided namespace identifier.
				
					//
					// Handle missing namespace identifier.
					//
					if( ! $theNamespace->offsetExists( kOFFSET_GID ) )
					{
						if( $doThrow )
							throw new Exception
								( "Missing term namespace identifier",
								  kERROR_PARAMETER );							// !@! ==>
						
						return NULL;												// ==>
					
					} // Missing namespace identifier.

					//
					// Build term identifier.
					//
					$id = COntologyTerm::_id( ($theNamespace->offsetGet( kOFFSET_GID )
											  .kTOKEN_NAMESPACE_SEPARATOR
											  .(string) $theIdentifier),
											  $this->Connection() );
					
					//
					// Locate term.
					//
					$term = COntologyTerm::NewObject( $this->Connection(), $id );
					if( $term !== NULL )
						return $term;												// ==>
					
					if( $doThrow )
						throw new Exception
							( "Term not found",
							  kERROR_NOT_FOUND );								// !@! ==>
					
					return NULL;													// ==>
				
				} // Provided namespace.
				
				//
				// Try native identifier.
				//
				$term = COntologyTerm::NewObject( $this->Connection(), $theIdentifier );
				if( $term !== NULL )
					return $term;													// ==>
				
				//
				// Try global identifier.
				//
				$term = COntologyTerm::NewObject
							( $this->Connection(),
							  COntologyTerm::_id( $theIdentifier,
												  $this->Connection() ) );
				if( $term !== NULL )
					return $term;													// ==>
				
				if( $doThrow )
					throw new Exception
						( "Term not found",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				return NULL;														// ==>
			
			} // Provided local or global identifier.
			
			throw new Exception
				( "Missing term identifier",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // ResolveTerm.

	 
	/*===================================================================================
	 *	ResolveNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Find a node</h4>
	 *
	 * This method can be used to retrieve an existing node by identifier, or retrieve all
	 * nodes matching a term.
	 *
	 * The method expects a single parameter that may represent either the node identifier,
	 * or the term reference:
	 *
	 * <ul>
	 *	<li><tt>integer</tt>: In this case the method assumes that the parameter represents
	 *		the node identifier: it will attempt to retrieve the node, if it is not found,
	 *		the method will return <tt>NULL</tt>.
	 *	<li><tt>{@link COntologyTerm}</tt>: In this case the method locate all nodes that
	 *		refer to the provided term. If the term is not {@link _IsCommitted()}, the
	 *		method will return <tt>NULL</tt>.
	 *	<li><i>other</i>: Any other type will be interpreted either the term's native
	 *		identifier, or as the term's global identifier: the method will return all nodes
	 *		that refer to that term.
	 * </ul>
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()} and if
	 * the provided parameter is <tt>NULL</tt>.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @access public
	 * @return mixed				New node, found node or nodes list.
	 *
	 * @throws Exception
	 */
	public function ResolveNode( $theIdentifier, $doThrow = FALSE )
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
				// Resolve container.
				//
				$container = COntologyNode::ResolveClassContainer
								( $this->Connection(), TRUE );
				
				//
				// Handle node identifier.
				//
				if( is_integer( $theIdentifier ) )
				{
					//
					// Get node.
					//
					$node = COntologyNode::NewObject
								( $this->Connection(), $theIdentifier );
					
					//
					// Handle missing node.
					//
					if( ($node === NULL)
					 && $doThrow )
						throw new Exception
							( "Node not found",
							  kERROR_NOT_FOUND );								// !@! ==>
					
					return $node;													// ==>
				
				} // Provided node identifier.
							
				//
				// Handle term object.
				//
				if( $theIdentifier instanceof COntologyTerm )
				{
					//
					// Handle new term.
					//
					if( ! $theIdentifier->_IsCommitted() )
					{
						//
						// Raise exception.
						//
						if( $doThrow )
							throw new Exception
								( "Node not found: term is not committed",
								  kERROR_NOT_FOUND );							// !@! ==>
						
						return NULL;												// ==>
					
					} // New term.
					
					//
					// Get term identifier.
					//
					$theIdentifier = $theIdentifier->offsetGet( kOFFSET_NID );
					
					//
					// Make query.
					//
					$query = $container->NewQuery();
					$query->AppendStatement(
						CQueryStatement::Equals(
							kOFFSET_TERM, $theIdentifier, kTYPE_BINARY ) );
					$rs = $container->Query( $query );
					
					//
					// Handle found nodes.
					//
					if( $rs->count() )
					{
						//
						// Return list of nodes.
						//
						$list = Array();
						foreach( $rs as $document )
							$list[] = CPersistentObject::DocumentObject( $document );
						
						return $list;												// ==>
					
					} // Found at least one node.

					//
					// Raise exception.
					//
					if( $doThrow )
						throw new Exception
							( "Node not found",
							  kERROR_NOT_FOUND );								// !@! ==>
					
					return NULL;													// ==>
				
				} // Provided term object.
				
				//
				// Resolve term.
				//
				$term = $this->ResolveTerm( $theIdentifier, $doThrow );
				
				//
				// Get term identifier.
				//
				$theIdentifier = $theIdentifier->offsetGet( kOFFSET_NID );
				
				//
				// Make query.
				//
				$query = $container->NewQuery();
				$query->AppendStatement(
					CQueryStatement::Equals(
						kOFFSET_TERM, $theIdentifier, kTYPE_BINARY ) );
				$rs = $container->Query( $query );
				
				//
				// Handle found nodes.
				//
				if( $rs->count() )
				{
					//
					// Return list of nodes.
					//
					$list = Array();
					foreach( $rs as $document )
						$list[] = CPersistentObject::DocumentObject( $document );
					
					return $list;													// ==>
				
				} // Found at least one node.

				//
				// Raise exception.
				//
				if( $doThrow )
					throw new Exception
						( "Node not found",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				return NULL;													// ==>
				
			} // Provided local or global identifier.
			
			throw new Exception
				( "Missing node identifier or term",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // ResolveNode.

	 

} // class COntology.


?>
