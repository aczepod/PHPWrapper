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
 *						PUBLIC COMPONENTS INSTANTIATION INTERFACE						*
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
						return $this->_NewTerm
							( $theIdentifier, $theNamespace,
							  $theLabel, $theDescription, $theLanguage );			// ==>
					
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

					return $this->_NewTerm
						( $theIdentifier, $theNamespace,
						  $theLabel, $theDescription, $theLanguage );				// ==>
				
				} // Provided namespace.
				
				//
				// Look for term.
				//
				$term = $this->ResolveTerm( $theIdentifier );
				if( $term !== NULL )
					return $term;													// ==>

				return $this->_NewTerm
					( $theIdentifier, $theNamespace,
					  $theLabel, $theDescription, $theLanguage );					// ==>
			
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
	 * The method expects either a node identifier or a term reference. In the first case
	 * the method will return the matching node or <tt>NULL</tt>. In the second case the
	 * method will either return the list of nodes related to the provided term, or a new
	 * node related to that term.
	 *
	 * This means that when you provide data for a new term, this will be instantiated and
	 * committed in all cases.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: This parameter represents the node identifier, or the
	 *		term reference:
	 *	 <ul>
	 *		<li><tt>integer</tt>: In this case the method assumes that the parameter
	 *			represents the node identifier: it will attempt to retrieve the node, if it
	 *			is not found, the method will return <tt>NULL</tt>. With this option all
	 *			other parameter are ignored.
	 *		<li><tt>{@link COntologyTerm}</tt>: In this case the method assumes the
	 *			parameter represents the term object: if the term is not committed, the
	 *			method will return a new node, if the term is committed, the method will try
	 *			to locate all nodes related to that term: if none are found, or if the last
	 *			parameter is <tt>TRUE</tt>, the method will return a new node related to
	 *			that term; if at least one node is found, the method will return the list
	 *			of nodes related to that term.
	 *		<li><i>other</i>: In this case the parameter is expected to be the term's native
	 *			or global identifier and the method will behave as above.
	 *	 </ul>
	 *		The next four parameters have a meaning only if you are creating a new node with
	 *		a new term, in all other cases these parameters will be ignored.
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
	 *	<li><tt>$doNew</tt>: If <tt>TRUE</tt>, a new node will be instantiated in all cases,
	 *		that means that the method will not attempt to find a node related to the term.
	 *		Note that if the first parameter is an integer, this parameter is ignored.
	 * </ul>
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()} and if
	 * the first parameter is <tt>NULL</tt>.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param mixed					$theNamespace		Term namespace reference.
	 * @param string				$theLabel			Term label.
	 * @param string				$theDescription		Term description.
	 * @param string				$theLanguage		Label and description language code.
	 * @param boolean				$doNew				<tt>TRUE</tt> force new node.
	 *
	 * @access public
	 * @return mixed				New node, found node or nodes list.
	 *
	 * @throws Exception
	 */
	public function NewNode( $theIdentifier, $theNamespace = NULL,
											 $theLabel = NULL, $theDescription = NULL,
											 $theLanguage = NULL, $doNew = FALSE )
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
				// Create term.
				//
				$term = $this->NewTerm( $theIdentifier, $theNamespace,
										$theLabel, $theDescription, $theLanguage );
				
				//
				// Force new.
				//
				if( $doNew )
					return $this->_NewNode( $term );								// ==>
				
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
						kOFFSET_TERM, $term[ kOFFSET_NID ], kTYPE_BINARY ) );
						
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
				
				return $this->_NewNode( $term );									// ==>
				
			} // Provided local or global identifier.
			
			throw new Exception
				( "Missing node identifier or term",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // NewNode.

	 
	/*===================================================================================
	 *	NewRootNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a root node</h4>
	 *
	 * This method can be used to instantiate a new root node, retrieve an existing node by
	 * identifier, or retrieve the list of nodes matching a term.
	 *
	 * The method expects a single parameter that may represent either the node identifier,
	 * or the term object or identifier:
	 *
	 * <ul>
	 *	<li><tt>integer</tt>: In this case the method assumes that the parameter represents
	 *		the node identifier: it will attempt to retrieve the node, if it is not found,
	 *		the method will return <tt>NULL</tt>. With this option the second parameter is
	 *		ignored.
	 *	<li><tt>{@link COntologyTerm}</tt>: In this case the method will check if the term
	 *		exists:
	 *	 <ul>
	 *		<li><i>Term exists</i>: The method will locate all root nodes that relate to
	 *			that term and return the array of found nodes, or <tt>NULL</tt> if there are
	 *			no matches. If the second parameter is <tt>TRUE</tt>, the method will
	 *			instantiate a new root node whether or not there are matches.
	 *		<li><i>Term is new</i>: The method will return a new root node related to that
	 *			term.
	 *	 </ul>
	 *	<li><i>other</i>: Any other type will be interpreted as the term's native
	 *		identifier: the method will locate all root nodes that relate to that term and
	 *		return the array of found nodes, or a new root node if the second parameter is
	 *		<tt>TRUE</tt>.
	 * </ul>
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()}, if the
	 * provided parameter is <tt>NULL</tt>, or if the provided term identifier is not
	 * resolved.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param boolean				$doNew				<tt>TRUE</tt> force new node.
	 *
	 * @access public
	 * @return mixed				New node, found node or nodes list.
	 *
	 * @throws Exception
	 */
	public function NewRootNode( $theIdentifier, $doNew = TRUE )
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
						return $this->_NewNode( $theIdentifier, kNODE_KIND_ROOT );	// ==>
				
				} // Provided term object.
				
				//
				// Resolve term.
				//
				$theIdentifier = $this->ResolveTerm( $theIdentifier, NULL, TRUE );
				
				//
				// Force new.
				//
				if( $doNew )
					return $this->_NewNode( $theIdentifier, kNODE_KIND_ROOT );		// ==>
				
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
				// Add term reference statement.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kOFFSET_TERM, $theIdentifier[ kOFFSET_NID ], kTYPE_BINARY ) );
				
				//
				// Add root node kind statement.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kOFFSET_KIND, kNODE_KIND_ROOT, kTYPE_STRING ) );
						
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

	} // NewRootNode.

		

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
	 * This class takes advantage of the static method {@link COntologyTerm::Resolve()}.
	 *
	 * @param string				$theIdentifier		Term local identifier.
	 * @param mixed					$theNamespace		Namespace term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @access public
	 * @return COntologyTerm		New or found term.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses COntologyTerm::Resolve()
	 */
	public function ResolveTerm( $theIdentifier, $theNamespace = NULL, $doThrow = FALSE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			return COntologyTerm::Resolve(
				$this->Connection(), $theIdentifier, $theNamespace, $doThrow );		// ==>
		
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
	 * This class takes advantage of the static method {@link COntologyNode::Resolve()}.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @access public
	 * @return mixed				New node, found node or nodes list.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses COntologyNode::Resolve()
	 */
	public function ResolveNode( $theIdentifier, $doThrow = FALSE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			return COntologyNode::Resolve(
				$this->Connection(), $theIdentifier, $doThrow );					// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // ResolveNode.

		

/*=======================================================================================
 *																						*
 *								PROTECTED COMPONENTS INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_NewTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a new term</h4>
	 *
	 * This method can be used to instantiate a new term and commit it.
	 *
	 * The method will first instantiate the node from the provided parameter, then it
	 * will insert it and finally return it, if there were no errors.
	 *
	 * This method is used by the public interface to perform the actual creation of terms.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: This parameter represents the term local identifier.
	 *	<li><tt>$theNamespace</tt>: The term namespace, it can be provided both as an object
	 *		or as the term native identifier.
	 *	<li><tt>$theLabel</tt>: The term label string, this parameter is optional.
	 *	<li><tt>$theDescription</tt>: The term description string this parameter is optional.
	 *	<li><tt>$theLanguage</tt>: The language code of both the label and the description.
	 * </ul>
	 *
	 * The method will return a new committed term or raise an exception if the term is a
	 * duplicate.
	 *
	 * @param string				$theIdentifier		Term local identifier.
	 * @param mixed					$theNamespace		Term namespace reference.
	 * @param string				$theLabel			Term label.
	 * @param string				$theDescription		Term description.
	 * @param string				$theLanguage		Label and description language code.
	 *
	 * @access protected
	 * @return COntologyTerm		New committed term.
	 *
	 * @throws Exception
	 */
	protected function _NewTerm( $theIdentifier, $theNamespace,
								 $theLabel, $theDescription, $theLanguage )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Check local identifier.
			//
			if( $theIdentifier !== NULL )
			{
				//
				// Create term.
				//
				$term = new COntologyTerm();
				
				//
				// Set local identifier.
				//
				$term->LID( $theIdentifier );
				
				//
				// Set namespace.
				//
				if( $theNamespace !== NULL )
					$term->NS( $theNamespace );
				
				//
				// Set label.
				//
				if( $theLabel !== NULL )
					$term->Label( $theLanguage, $theLabel );
				
				//
				// Set description.
				//
				if( $theDescription !== NULL )
					$term->Description( $theLanguage, $theDescription );
				
				//
				// Save term.
				//
				$term->Insert( $this->Connection() );
				
				return $term;														// ==>
			
			} // Provided local identifier.
			
			throw new Exception
				( "Missing term local identifier",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // _NewTerm.

	 
	/*===================================================================================
	 *	_NewNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a new term</h4>
	 *
	 * This method can be used to instantiate a new term and commit it.
	 *
	 * The method will first instantiate the node from the provided parameter, then it
	 * will insert it and finally return it, if there were no errors.
	 *
	 * This method is used by the public interface to perform the actual creation of terms.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theTerm</tt>: This parameter represents the term reference, it can be
	 *		provided as the term object or term native identifier.
	 *	<li><tt>$theKind</tt>: This parameter represents the term kind, it can be provided
	 *		as a list of values, as a scalar value or as <tt>NULL</tt>.
	 *	<li><tt>$theType</tt>: This parameter represents the term type, it can be provided
	 *		as a scalar value or as <tt>NULL</tt>.
	 * </ul>
	 *
	 * The method will return a new committed term or raise an exception if the term is a
	 * duplicate.
	 *
	 * @param mixed					$theTerm			Term object or identifier.
	 * @param mixed					$theKind			Node kind value or values.
	 * @param mixed					$theType			Node type value.
	 *
	 * @access protected
	 * @return COntologyNode		New committed node.
	 *
	 * @throws Exception
	 */
	protected function _NewNode( $theTerm, $theKind = NULL, $theType = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Check term reference.
			//
			if( $theTerm !== NULL )
			{
				//
				// Create node.
				//
				$node = new COntologyNode();
				
				//
				// Set term reference.
				//
				$node->Term( $theTerm );
				
				//
				// Set kind.
				//
				if( $theKind !== NULL )
				{
					//
					// Handle array.
					//
					if( is_array( $theKind ) )
						$node->Kind( $theKind, array_fill( 0, count( $theKind ), TRUE ) );
					
					//
					// Handle scalar.
					//
					else
						$node->Kind( $theKind, TRUE );
				
				} // Provided kind.
				
				//
				// Set type.
				//
				if( $theType !== NULL )
					$node->Type( $theType );
				
				//
				// Save node.
				//
				$node->Insert( $this->Connection() );
				
				return $node;														// ==>
			
			} // Provided term reference.
			
			throw new Exception
				( "Missing term reference or object",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // _NewNode.

	 

} // class COntology.


?>
