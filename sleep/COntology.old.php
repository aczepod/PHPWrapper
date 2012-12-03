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
 * Global attributes.
 *
 * This include file contains common offset definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Attributes.inc.php" );

/**
 * Terms.
 *
 * This includes the term class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTerm.php" );

/**
 * Vertices.
 *
 * This includes the node class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyVertex.php" );

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
 * <h4>Ontology object</h4>
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

	 
	/*===================================================================================
	 *	GetDatabase																		*
	 *==================================================================================*/

	/**
	 * <h4>Return database connection</h4>
	 *
	 * This method should return the database connection, <tt>FALSE<tt> if no connection
	 * is set and <tt>NULL</tt>, if the database cannot be inferred..
	 *
	 * @access public
	 * @return mixed				Database connection, <tt>NULL<7tt> or <tt>FALSE</tt>.
	 */
	public function GetDatabase( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check connection
		//
		if( ($connection = $this->Connection()) !== NULL )
		{
			//
			// Check for server.
			//
			if( $connection instanceof CServer )
				$connection = $connection->Database();
			
			//
			// Check for database.
			//
			if( $connection instanceof Cdatabase )
				return $connection;													// ==>
			
			return NULL;															// ==>
		
		} // Has connection.
		
		return FALSE;																// ==>

	} // GetDatabase.

		

/*=======================================================================================
 *																						*
 *						PUBLIC ONTOLOGY INITIALISATION INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	InitOntology																	*
	 *==================================================================================*/

	/**
	 * <h4>Initialise the ontology</h4>
	 *
	 * This method will clear the current database and initialise it with the default
	 * ontology elements.
	 *
	 * This method can be used to create a new ontology, so you should be aware that the
	 * method will erase any existing data.
	 *
	 * The curent object must be {@link _IsInited()} and the method does not return any
	 * value.
	 *
	 * @access public
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 * @uses ResolveTerm()
	 * @uses _NewTerm()
	 * @uses Connection()
	 */
	public function InitOntology()
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Initialise containers.
			//
			$this->_InitOntologyContainers();
			
			//
			// Create namespace term.
			//
			$this->_InitDefaultNamespace();
			
			//
			// Create default type terms.
			//
			$this->_InitDefaultTypeTerms();
			
			//
			// Create default attribute terms.
			//
			$this->_InitDefaultAttributeTerms();
			
			//
			// Create default instances.
			//
			$this->_InitDefaultPredicates();
			$this->_InitDefaultNodeKinds();
			$this->_InitDefaultDataTypes();
			
			//
			// Create default data dictionaries.
			//
			$this->_InitDefaultDataDictionaries();
			
			//
			// Load default data dictionaries.
			//
			$this->_LoadTermDataDictionary();
			$this->_LoadNodeDataDictionary();
			$this->_LoadEdgeDataDictionary();
			$this->_LoadTagDataDictionary();
			$this->_LoadAttributesDataDictionary();
			
			return;																	// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // InitOntology.

		

/*=======================================================================================
 *																						*
 *							PUBLIC TERM INSTANTIATION INTERFACE							*
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
	 *	<li><tt>$theNamespace</tt>: This parameter represents the term namespace, it must
	 *		resolve to a committed term or the method will fail. It can be provided in
	 *		several ways:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This indicates that the term has no namespace.
	 *		<li><tt>{@link COntologyTerm}</tt>: This represents the term namespace object.
	 *		<li><i>other</i>: Any other type is interpreted as the namespace native or
	 *			global identifier; if the namespace cannot be found, the method will raise
	 *			an exception.
	 *	 </ul>
	 *	<li><tt>$theLabel</tt>: The term label string, this parameter is optional.
	 *	<li><tt>$theDescription</tt>: The term description string this parameter is optional.
	 *	<li><tt>$theLanguage</tt>: The language code of both the label and the description.
	 *	<li><tt>$theAttributes</tt>: An optional list of additional key/value attributes.
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
	 * @param array					$theAttributes		Additional attributes list.
	 *
	 * @access public
	 * @return COntologyTerm		New or found term.
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 * @uses ResolveTerm()
	 * @uses _NewTerm()
	 * @uses Connection()
	 */
	public function NewTerm( $theIdentifier, $theNamespace = NULL,
											 $theLabel = NULL, $theDescription = NULL,
											 $theLanguage = NULL, $theAttributes = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Resolve namespace.
			//
			if( $theNamespace !== NULL )
			{
				//
				// Check namespace object.
				//
				if( $theNamespace instanceof COntologyTerm )
				{
					//
					// Resolve term.
					//
					if( ! $theNamespace->_IsCommitted() )
						$theNamespace = $this->ResolveTerm( $theNamespace );
				
				} // Provided namespace object.
				
				//
				// Resolve namespace.
				//
				else
					$theNamespace = $this->ResolveTerm( $theNamespace );
				
				//
				// Check namespace.
				//
				if( $theNamespace === NULL )
					throw new Exception
						( "Namespace not found",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				//
				// Normalise identifier.
				//
				if( $theIdentifier instanceof COntologyTerm )
				{
					//
					// Use local identifier.
					//
					$theIdentifier = $theIdentifier->LID();
					if( $theIdentifier === NULL )
						throw new Exception
							( "Missing term local identifier",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Provided term object copy.
				
				//
				// Cast to string.
				//
				else
					$theIdentifier = (string) $theIdentifier;
			
			} // Provided namespace.
			
			//
			// Check object.
			//
			$term = $this->ResolveTerm( $theIdentifier, $theNamespace );
			if( $term !== NULL )
				return $term;														// ==>
			
			return $this->_NewTerm( $theIdentifier, $theNamespace,
									$theLabel, $theDescription, $theLanguage,
									$theAttributes );								// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // NewTerm.

		

/*=======================================================================================
 *																						*
 *							PUBLIC NODE INSTANTIATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewNode																			*
	 *==================================================================================*/

	/**
	 * <h4>Locate or instantiate a qualified node</h4>
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
	 * The method also accepts the node qualifications through the {@link CNode::Kind()} and
	 * {@link CNode:Type()} qualifiers: when resolving nodes, these have to match or a new
	 * instance is returned; when creating new nodes, these qualifiers will be set to the
	 * provided values.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theIdentifier</tt>: This parameter represents either the node identifier,
	 *		or the term reference, depending on the value type:
	 *	 <ul>
	 *		<li><tt>integer</tt>: In this case the method assumes that the parameter
	 *			represents the node identifier: it will attempt to retrieve the node, if it
	 *			is not found, the method will return <tt>NULL</tt>. With this option all
	 *			other parameter are ignored.
	 *		<li><i>other</i>: Any other value indicates that the parameter represents a
	 *			reference to a term, either as a term object or identifier. The term will be
	 *			resolved: if the <tt>$doNew</tt> parameter is <tt>TRUE</tt>, the method will
	 *			return a new node related to the resolved term; if the <tt>$doNew</tt>
	 *			parameter is not <tt>TRUE</tt>:
	 *		 <ul>
	 *			<li><i>The term is committed</i>: The method will try to locate all nodes
	 *				related to that term, if any are found, the method will return the list
	 *				of nodes; if none are found, the method will return a new node related
	 *				to that provided term.
	 *			<li><i>The term is <i>not</i> committed</i>: The ethod will return a new
	 *				node related to that term.
	 *		 </ul>
	 *	 </ul>
	 *		The next four parameters have a meaning only if you are creating a new node with
	 *		a new term, in all other cases these parameters will be ignored.
	 *	<li><tt>$theKind</tt>: If not <tt>NULL</tt>, this parameter will serve as a filter
	 *		to locate matching nodes, or it will be set in new nodes. This parameter
	 *		represents the node's {@link CNode::Kind()}. The parameter can be provided both
	 *		as an array or as a scalar, in the first case it means that <i>all</i> elements
	 *		must match.
	 *	<li><tt>$theType</tt>: If not <tt>NULL</tt>, this parameter will serve as a filter
	 *		to locate matching nodes, or it will be set in new nodes. This parameter
	 *		represents the node's {@link CNode::Type()}. The parameter is expected to be a
	 *		scalar.
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
	 * @param mixed					$theKind			Node kind set.
	 * @param mixed					$theType			Node data type.
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
	 *
	 * @uses _IsInited()
	 * @uses Connection()
	 * @uses NewTerm()
	 * @uses _NewNode()
	 */
	public function NewNode( $theIdentifier, $theKind = NULL, $theType = NULL,
											 $theNamespace = NULL,
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
				// Normalise kind.
				//
				if( ! is_array( $theKind ) )
					$theKind = array( $theKind );
				else
					$theKind = array_unique( $theKind );
				
				//
				// Handle node identifier.
				//
				if( is_integer( $theIdentifier ) )
				{
					//
					// Resolve node.
					//
					$node = COntologyVertex::NewObject( $this->Connection(),
														$theIdentifier );
					if( $node !== NULL )
					{
						//
						// Check kind.
						//
						if( $theKind !== NULL )
						{
							//
							// Get node kind.
							//
							$match = $node->Kind();
							if( $match === NULL )
								return NULL;										// ==>
							
							//
							// Match.
							//
							if( count( array_intersect( $theKind, $match ) )
							 != count( $theKind ) )
								return NULL;										// ==>
						
						} // Provided kind.
						
						//
						// Check type.
						//
						if( $theType !== NULL )
						{
							//
							// Get node type.
							//
							$match = $node->Type();
							if( $match === NULL )
								return NULL;										// ==>
							
							//
							// Match.
							//
							if( $match != $theType )
								return NULL;										// ==>
						
						} // Provided type.
						
						return $node;												// ==>
					
					} // Node matches.
					
					return NULL;													// ==>
					
				} // Provided node identifier.
				
				//
				// Exclude arrays.
				//
				elseif( ! is_array( $theIdentifier ) )
				{
					//
					// Create term.
					//
					$term = $this->NewTerm(
								$theIdentifier, $theNamespace,
								$theLabel, $theDescription, $theLanguage );
					
					//
					// Force new.
					//
					if( $doNew )
						return $this->_NewNode( $term, $theKind, $theType );		// ==>
					
					//
					// Resolve container.
					//
					$container = COntologyVertex::ResolveClassContainer
									( $this->Connection(), TRUE );
					
					//
					// Create query.
					//
					$query = $container->NewQuery();
					
					//
					// Locate by identifier.
					//
					$query->AppendStatement(
						CQueryStatement::Equals(
							kTAG_TERM, $term[ kTAG_NID ], kTYPE_BINARY_STRING ) );
					
					//
					// Filter by kind.
					//
					if( $theKind !== NULL )
					{
						//
						// Iterate kinds.
						// Note that the parameter was normalised.
						//
						foreach( $theKind as $match )
							$query->AppendStatement(
								CQueryStatement::Member(
									kTAG_KIND, $match, kTYPE_STRING ) );
					
					} // Provided kind.
					
					//
					// Filter by type.
					//
					if( $theType !== NULL )
					{
						//
						// Handle types list.
						//
						if( is_array( $theType ) )
						{
							foreach( $theType as $type )
								$query->AppendStatement(
									CQueryStatement::Member(
										kTAG_TYPE, $type, kTYPE_STRING ) );
						
						} // List of types.
						
						//
						// Handle scalar type.
						//
						else
							$query->AppendStatement(
								CQueryStatement::Equals(
									kTAG_TYPE, $theType, kTYPE_STRING ) );
					
					} // Provided type.
							
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
						
						return $list;												// ==>
					
					} // Found at least one node.
					
					return $this->_NewNode( $term, $theKind, $theType );			// ==>
				
				} // Did not provide an array.
				
				throw new Exception
					( "Provided an array in place of the identifier",
					  kERROR_PARAMETER );										// !@! ==>
				
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
	 * This method can be used to instantiate a new root node, retrieve an existing root
	 * node by identifier, or retrieve the list of root nodes matching a term.
	 *
	 * A root node distinguishes itself from a <i>standard</i> node by having the
	 * {@link kKIND_ROOT} enumeration set in its kind ({@link COntologyVertex::Kind()})
	 * list.
	 *
	 * The method uses the same parameters as the {@link NewNode()} method, except that it
	 * forces the {@link kKIND_ROOT} enumeration as the kind, <tt>NULL</tt> as the
	 * type and omits both parameters.
	 *
	 * For more information, please consult the {@link NewNode()} method reference.
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
	 *
	 * @uses NewNode()
	 *
	 * @see kKIND_ROOT
	 */
	public function NewRootNode( $theIdentifier, $theNamespace = NULL,
												 $theLabel = NULL, $theDescription = NULL,
												 $theLanguage = NULL, $doNew = FALSE )
	{
		return $this->NewNode( $theIdentifier,
							   kKIND_ROOT, NULL,
							   $theNamespace,
							   $theLabel, $theDescription,
							   $theLanguage, $doNew );								// ==>

	} // NewRootNode.

	 
	/*===================================================================================
	 *	NewTraitNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a trait node</h4>
	 *
	 * This method can be used to instantiate a new trait node, retrieve an existing trait
	 * node by identifier, or retrieve the list of trait nodes matching a term.
	 *
	 * A trait node distinguishes itself from a <i>standard</i> node by having the
	 * {@link kKIND_FEATURE} enumeration set in its kind
	 * ({@link COntologyVertex::Kind()}) list. Also, trait nodes represent the beginning of
	 * the path used to annotate data, trait nodes always represent the first term reference
	 * in a tag path.
	 *
	 * The method uses the same parameters as the {@link NewNode()} method, except that it
	 * forces the {@link kKIND_FEATURE} enumeration as the kind, <tt>NULL</tt> as the
	 * type and omits both parameters.
	 *
	 * For more information, please consult the {@link NewNode()} method reference.
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
	 *
	 * @uses NewNode()
	 *
	 * @see kKIND_FEATURE
	 */
	public function NewTraitNode( $theIdentifier, $theNamespace = NULL,
												  $theLabel = NULL, $theDescription = NULL,
												  $theLanguage = NULL, $doNew = FALSE )
	{
		return $this->NewNode( $theIdentifier,
							   kKIND_FEATURE, NULL,
							   $theNamespace,
							   $theLabel, $theDescription,
							   $theLanguage, $doNew );								// ==>

	} // NewTraitNode.

	 
	/*===================================================================================
	 *	NewMethodNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate a method node</h4>
	 *
	 * This method can be used to instantiate a new method node, retrieve an existing method
	 * node by identifier, or retrieve the list of method nodes matching a term.
	 *
	 * A method node distinguishes itself from a <i>standard</i> node by having the
	 * {@link kKIND_METHOD} enumeration set in its kind
	 * ({@link COntologyVertex::Kind()}) list. Also, method nodes represent the intermediary
	 * elements of the path used to annotate data: method nodes will always be found after
	 * trait nodes and before scale nodes in a tag path.
	 *
	 * The method uses the same parameters as the {@link NewNode()} method, except that it
	 * forces the {@link kKIND_METHOD} enumeration as the kind, <tt>NULL</tt> as the
	 * type and omits both parameters.
	 *
	 * For more information, please consult the {@link NewNode()} method reference.
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
	 *
	 * @uses NewNode()
	 *
	 * @see kKIND_METHOD
	 */
	public function NewMethodNode( $theIdentifier, $theNamespace = NULL,
												   $theLabel = NULL, $theDescription = NULL,
												   $theLanguage = NULL, $doNew = FALSE )
	{
		return $this->NewNode( $theIdentifier,
							   kKIND_METHOD, NULL,
							   $theNamespace,
							   $theLabel, $theDescription,
							   $theLanguage, $doNew );								// ==>

	} // NewMethodNode.

	 
	/*===================================================================================
	 *	NewScaleNode																	*
	 *==================================================================================*/

	/**
	 * <h4>Locate or instantiate a scale node</h4>
	 *
	 * This method can be used to instantiate a new scale node, retrieve an existing scale
	 * node by identifier, or retrieve the list of scale nodes matching a term.
	 *
	 * A scale node distinguishes itself from a <i>standard</i> node by having the
	 * {@link kKIND_SCALE} enumeration set in its kind
	 * ({@link COntologyVertex::Kind()}) list. Also, scale nodes represent the last element
	 * of the path used to annotate data: scale nodes will always have a data type,
	 * {@link CNode::Type()}, attribute.
	 *
	 * The method uses the same parameters as the {@link NewNode()} method, except that it
	 * forces the {@link kKIND_SCALE} enumeration as the kind and expects the type
	 * attribute to either be present in the resolved node, or provided as a parameter.
	 *
	 * For more information, please consult the {@link NewNode()} method reference.
	 *
	 * @param mixed					$theIdentifier		Node identifier or term reference.
	 * @param mixed					$theType			Node type.
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
	 *
	 * @uses _IsInited()
	 * @uses Connection()
	 * @uses NewTerm()
	 * @uses _NewNode()
	 *
	 * @see kKIND_SCALE
	 */
	public function NewScaleNode( $theIdentifier, $theType = NULL,
												  $theNamespace = NULL,
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
				{
					//
					// Resolve node.
					//
					$node = COntologyVertex::NewObject( $this->Connection(),
														$theIdentifier );
					if( $node !== NULL )
					{
						//
						// Check kind.
						//
						$match = $node->Kind();
						if( $match === NULL )
							return NULL;											// ==>
						
						//
						// Match kind.
						//
						if( ! in_array( kKIND_SCALE, $match ) )
							return NULL;											// ==>
						
						//
						// Check type.
						//
						if( $node->Type() === NULL )
							return NULL;											// ==>
						
						return $node;												// ==>
					
					} // Node matches.
					
					return NULL;													// ==>
					
				} // Provided node identifier.
				
				//
				// Create term.
				//
				$term = $this->NewTerm( $theIdentifier, $theNamespace,
										$theLabel, $theDescription, $theLanguage );
				
				//
				// Force new.
				//
				if( $doNew )
				{
					//
					// Assert type.
					//
					if( $theType !== NULL )
						return $this->_NewNode
								( $term, kKIND_SCALE, $theType );				// ==>
					
					throw new Exception
						( "Missing node data type",
						  kERROR_PARAMETER );									// !@! ==>
				
				} // Force new node.
				
				//
				// Resolve container.
				//
				$container = COntologyVertex::ResolveClassContainer
								( $this->Connection(), TRUE );
				
				//
				// Create query.
				//
				$query = $container->NewQuery();
				
				//
				// Locate by identifier.
				//
				$query->AppendStatement(
					CQueryStatement::Equals(
						kTAG_TERM, $term[ kTAG_NID ], kTYPE_BINARY_STRING ) );
				
				//
				// Filter by kind.
				//
				$query->AppendStatement(
					CQueryStatement::Member(
						kTAG_KIND, kKIND_SCALE, kTYPE_STRING ) );
				
				//
				// Filter by type.
				//
				if( $theType !== NULL )
					$query->AppendStatement(
						CQueryStatement::Exists( kTAG_TYPE ) );
				else
					throw new Exception
						( "Missing node data type",
						  kERROR_PARAMETER );									// !@! ==>
						
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
				
				//
				// Assert type.
				//
				if( $theType !== NULL )
					return $this->_NewNode
							( $term, kKIND_SCALE, $theType );					// ==>
				
				throw new Exception
					( "Missing node data type",
					  kERROR_PARAMETER );										// !@! ==>
				
			} // Provided local or global identifier.
			
			throw new Exception
				( "Missing node identifier or term",
				  kERROR_PARAMETER );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // NewScaleNode.

	 
	/*===================================================================================
	 *	NewEnumerationNode																*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate an enumeration node</h4>
	 *
	 * This method can be used to instantiate a new enumeration node, retrieve an existing
	 * enumeration node by identifier, or retrieve the list of enumeration nodes matching a
	 * term.
	 *
	 * An enumeration node distinguishes itself from a <i>standard</i> node by having the
	 * {@link kKIND_INSTANCE} enumeration set in its kind
	 * ({@link COntologyVertex::Kind()}) list. Also, enumeration nodes represent elements of
	 * an enumerated set and have by default the {@link kTYPE_STRING} data type.
	 *
	 * The method uses the same parameters as the {@link NewNode()} method, except that it
	 * forces the {@link kKIND_INSTANCE} enumeration as the kind, {@link kTYPE_STRING}
	 * as the type and omits both parameters.
	 *
	 * For more information, please consult the {@link NewNode()} method reference.
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
	 *
	 * @uses NewNode()
	 *
	 * @see kKIND_INSTANCE kTYPE_STRING
	 */
	public function NewEnumerationNode( $theIdentifier, $theNamespace = NULL,
										$theLabel = NULL, $theDescription = NULL,
										$theLanguage = NULL, $doNew = FALSE )
	{
		return $this->NewNode( $theIdentifier,
							   kKIND_ENUMERATION, kTYPE_STRING,
							   $theNamespace,
							   $theLabel, $theDescription,
							   $theLanguage, $doNew );								// ==>

	} // NewEnumerationNode.

		

/*=======================================================================================
 *																						*
 *							PUBLIC TAG INSTANTIATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	AddToTag																		*
	 *==================================================================================*/

	/**
	 * <h4>Add an element to a tag</h4>
	 *
	 * This method can be used to instantiate and append elements to a {@link COntologyTag},
	 * the method will perform specific checks to ensure elements added to the tag are of
	 * the correct kind.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theTag</tt>: This parameter is a reference to a tag, if the provided
	 *		parameter is a {@link COntologyTag}, it will be used to append elements, if not,
	 *		it will be instantiated.
	 *	<li><tt>$theItem</tt>: This parameter represents either the item to be appended or
	 *		the operation:
	 *	 <ul>
	 *		<li><tt>{@link COntologyVertex}</tt>: This type will be interpreted as a node to
	 *			be added.
	 *		<li><tt>{@link COntologyTerm}</tt>: This type will be interpreted as a predicate
	 *			term to be added.
	 *		<li><tt>integer</tt>: This type will be interpreted as a node identifier.
	 *		<li><tt>TRUE</tt>: This value is interpreted as the command to commit the tag.
	 *		<li><i>other</i>: Any other type is interpreted as the predicate term
	 *			identifier (native or global).
	 *	 </ul>
	 * </ul>
	 *
	 * The method makes use of the {@link COntologyTag::PushItem()} method, please consult
	 * that method to determine what elements can be appended.
	 *
	 * Note: provided nodes must be committed, or the method will raise an exception.
	 *
	 * When appending elements, the method will return the current number of elements in the
	 * path; when committing the tag, the method will return its native identifier.
	 *
	 * If any error occurs, the method will raise an exception.
	 *
	 * @param reference			   &$theTag				Tag object reference.
	 * @param mixed					$theItem			Item to be added or commit command.
	 *
	 * @access public
	 * @return mixed				Path elements count or tag identifier.
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 * @uses Connection()
	 * @uses NewTerm()
	 * @uses _NewNode()
	 */
	public function AddToTag( &$theTag, $theItem )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Instantiate tag.
			//
			if( ! ($theTag instanceof COntologyTag) )
				$theTag = new COntologyTag();
			
			//
			// Commit tag.
			//
			if( $theItem === TRUE )
				return $theTag->Insert( $this->Connection() );						// ==>
		
			//
			// Resolve objects.
			//
			if( (! ($theItem instanceof COntologyVertex))
			 && (! ($theItem instanceof COntologyTerm)) )
			{
				//
				// Resolve node.
				//
				if( is_integer( $theItem ) )
					$theItem = $this->ResolveNode( $theItem, TRUE );
				
				//
				// Resolve term.
				//
				else
					$theItem = $this->ResolveTerm( $theItem, NULL, TRUE );
			
			} // Not an object.
		
			return $theTag->PushItem( $theItem );									// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // AddToTag.

		

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
	 * @return COntologyTerm		Found term or <tt>NULL</tt>.
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
	 * This class takes advantage of the static method {@link COntologyVertex::Resolve()}.
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
	 * @uses COntologyVertex::Resolve()
	 */
	public function ResolveNode( $theIdentifier, $doThrow = FALSE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			return COntologyVertex::Resolve(
				$this->Connection(), $theIdentifier, $doThrow );					// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // ResolveNode.

	 
	/*===================================================================================
	 *	ResolveEdge																		*
	 *==================================================================================*/

	/**
	 * <h4>Find an edge</h4>
	 *
	 * This method can be used to retrieve an existing edge by providing the elements that
	 * constitute it.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: This parameter is interpreted as the edge subject vertex
	 *		node reference:
	 *	 <ul>
	 *		<li><tt>{@link COntologyVertex}</tt>: It will be interpreted as the node object.
	 *		<li><tt>integer</tt>: It will be interpreted as the node native identifier.
	 *		<li><i>other</i>: The method will assume the value to be a term reference: in
	 *			this case the method will use the list of nodes that reference the eventual
	 *			referenced term.
	 *	 </ul>
	 *	<li><tt>$thePredicate</tt>: This parameter is interpreted as the edge predicate term
	 *		reference:
	 *	 <ul>
	 *		<li><tt>{@link COntologyTerm}</tt>: It will be interpreted as the term object.
	 *		<li><i>other</i>: The method will attempt to resolve the term by testing in turn
	 *			the value as its global and native identifier.
	 *	 </ul>
	 *	<li><tt>$theObject</tt>: This parameter is interpreted as the edge object vertex
	 *		node reference:
	 *	 <ul>
	 *		<li><tt>{@link COntologyVertex}</tt>: It will be interpreted as the node object.
	 *		<li><tt>integer</tt>: It will be interpreted as the node native identifier.
	 *		<li><i>other</i>: The method will assume the value to be a term reference: in
	 *			this case the method will use the list of nodes that reference the eventual
	 *			referenced term.
	 *	 </ul>
	 *	<li><tt>$doThrow</tt>: If this parameter is <tt>TRUE</tt> and no edge is found, the
	 *		method will raise an exception.
	 * </ul>
	 *
	 * If any of the provided parameters fail to resolve, the method will assume the edge
	 * cannot be found.
	 *
	 * The method will return an array of {@link COntologyEdge} instances, or <tt>NULL</tt>
	 * if no edge was found.
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()}.
	 *
	 * @param mixed					$theSubject			Subject vertex reference.
	 * @param mixed					$thePredicate		Predicate reference.
	 * @param mixed					$theObject			Object vertex reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @access public
	 * @return mixed				<tt>NULL</tt>, found edge or edges list.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses COntologyVertex::Resolve()
	 */
	public function ResolveEdge( $theSubject = NULL,
								 $thePredicate = NULL,
								 $theObject = NULL,
								 $doThrow = FALSE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Init local storage.
			//
			$found = NULL;
			
			//
			// Resolve subject.
			//
			if( $theSubject !== NULL )
			{
				//
				// Handle object.
				//
				if( $theSubject instanceof COntologyVertex )
					$theSubject = $theSubject[ kTAG_NID ];
				
				//
				// Handle term.
				//
				elseif( ! is_integer( $theSubject ) )
				{
					//
					// Resolve nodes.
					//
					$list = $this->ResolveNode( $theSubject );
					if( is_array( $list ) )
					{
						$theSubject = Array();
						foreach( $list as $node )
							$theSubject[] = $node[ kTAG_NID ];
					
					} // Resolved.
				
				} // Provided term reference.
				
				if( $theSubject === NULL )
				{
					if( ! $doThrow  )
						return NULL;												// ==>
					
					throw new Exception
						( "Edge not found: unable to resolve subject node vertex",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				} // Unable to resolve.
				
			} // Provided subject.
			
			//
			// Resolve predicate.
			//
			if( $thePredicate !== NULL )
			{
				//
				// Handle object.
				//
				if( $thePredicate instanceof COntologyTerm )
					$thePredicate = $thePredicate[ kTAG_NID ];
				
				//
				// Resolve term.
				//
				else
				{
					//
					// Resolve predicate.
					//
					$thePredicate = $this->ResolveTerm( $thePredicate, NULL, $doThrow );
					if( $thePredicate !== NULL )
						$thePredicate = $thePredicate[ kTAG_NID ];
				
				} // Resolved predicate.
				
				if( $thePredicate === NULL )
				{
					if( ! $doThrow  )
						return NULL;												// ==>
					
					throw new Exception
						( "Edge not found: unable to resolve predicate term",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				} // Unable to resolve.
				
			} // Provided predicate.
			
			//
			// Resolve object.
			//
			if( $theObject !== NULL )
			{
				//
				// Handle object.
				//
				if( $theObject instanceof COntologyVertex )
					$theObject = $theObject[ kTAG_NID ];
				
				//
				// Handle term.
				//
				elseif( ! is_integer( $theObject ) )
				{
					//
					// Resolve nodes.
					//
					$list = $this->ResolveNode( $theObject, $doThrow );
					if( is_array( $list ) )
					{
						$theObject = Array();
						foreach( $list as $node )
							$theObject[] = $node[ kTAG_NID ];
					
					} // Resolved.
				
				} // Provided term reference.
				
				if( $theObject === NULL )
				{
					if( ! $doThrow  )
						return NULL;												// ==>
					
					throw new Exception
						( "Edge not found: unable to resolve object node vertex",
						  kERROR_NOT_FOUND );									// !@! ==>
				
				} // Unable to resolve.
				
			} // Provided object.
			
			//
			// Prevent resolving all.
			//
			if( ($theSubject !== NULL)
			 || ($thePredicate !== NULL)
			 || ($theObject !== NULL) )
			{
				//
				// Resolve container.
				//
				$container = COntologyEdge::ResolveClassContainer
												( $this->Connection(), TRUE );
				
				//
				// Create query.
				//
				$query = $container->NewQuery();
				
				//
				// Locate by subject.
				//
				if( $theSubject !== NULL )
				{
					//
					// Set statement.
					//
					if( is_array( $theSubject ) )
						$query->AppendStatement(
							CQueryStatement::Member(
								kTAG_SUBJECT, $theSubject ) );
					else
						$query->AppendStatement(
							CQueryStatement::Equals(
								kTAG_SUBJECT, $theSubject ) );
				
				} // Selected subject.
				
				//
				// Locate by predicate.
				//
				if( $thePredicate !== NULL )
					$query->AppendStatement(
						CQueryStatement::Equals(
							kTAG_PREDICATE, $thePredicate, kTYPE_BINARY_STRING ) );
				
				//
				// Locate by object.
				//
				if( $theObject !== NULL )
				{
					//
					// Set statement.
					//
					if( is_array( $theObject ) )
						$query->AppendStatement(
							CQueryStatement::Member(
								kTAG_OBJECT, $theObject ) );
					else
						$query->AppendStatement(
							CQueryStatement::Equals(
								kTAG_OBJECT, $theObject ) );
				
				} // Selected subject.
				
				//
				// Perform query.
				//
				$rs = $container->Query( $query );
				if( $rs->count() )
				{
					//
					// Init results array.
					//
					$found = Array();
					foreach( $rs as $element )
						$found[] = CPersistentObject::DocumentObject( $element );
				
				} // Found results.
			
			} // At least one selection.
			
			//
			// Return result.
			//
			if( (! $doThrow)
			 || ($found !== NULL) )
				return $found;														// ==>
			
			throw new Exception
				( "Edge not found",
				  kERROR_NOT_FOUND );											// !@! ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // ResolveEdge.

	 
	/*===================================================================================
	 *	ResolveTag																		*
	 *==================================================================================*/

	/**
	 * <h4>Find a tag</h4>
	 *
	 * This method can be used to retrieve an existing tag by identifier, or retrieve all
	 * tags matching the provided term.
	 *
	 * The method expects a single parameter that may represent either the tag identifier,
	 * or the term reference:
	 *
	 * <ul>
	 *	<li><tt>integer</tt>: In this case the method assumes that the parameter represents
	 *		the tag identifier: it will attempt to retrieve the tag, if it is not found,
	 *		the method will return <tt>NULL</tt>.
	 *	<li><tt>{@link COntologyTerm}</tt>: In this case the method locate all tags that
	 *		refer to the provided term. If the term is not {@link _IsCommitted()}, the
	 *		method will return <tt>NULL</tt>.
	 *	<li><i>other</i>: Any other type will be interpreted as the tag's global or unique
	 *		identifier.
	 * </ul>
	 *
	 * The method will raise an exception if the object is not {@link _IsInited()} and if
	 * the provided parameter is <tt>NULL</tt>.
	 *
	 * This class takes advantage of the static method {@link COntologyTag::Resolve()}.
	 *
	 * @param mixed					$theIdentifier		Tag identifier or term reference.
	 * @param boolean				$doThrow			If <tt>TRUE</tt> raise an exception.
	 *
	 * @access public
	 * @return mixed				New tag, found tag or tags list.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses COntologyTag::Resolve()
	 */
	public function ResolveTag( $theIdentifier, $doThrow = FALSE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			return COntologyTag::Resolve(
				$this->Connection(), $theIdentifier, $doThrow );					// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // ResolveTag.

		

/*=======================================================================================
 *																						*
 *								PUBLIC OPERATIONS INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	RelateTo																		*
	 *==================================================================================*/

	/**
	 * <h4>Create an edge</h4>
	 *
	 * This method can be used to instantiate an edge by providing the subject and object
	 * vertex nodes and the edge predicate term. The method makes use of the node's
	 * {@link CNode::RelateTo()} method to perform the actual operation. This method will
	 * ensure that the subject node is committed before calling its method and eventually
	 * create a new predicate term from its provided attributes.
	 *
	 * The method expects the vertex nodes to be provided as node references, the predicate
	 * term can be created by this method by providing its attributes.
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Subject node reference.
	 *	<li><tt>$theObject</tt>: Object node reference.
	 *	<li><tt>$thePredicate</tt>: This parameter represents the predicate term reference,
	 *		object or local identifier.
	 *	<li><tt>$theNamespace</tt>: The predicate namespace, it can be provided in several
	 *		ways:
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
	 * The method will return a committed instance of the {@link COntologyEdge} class, if
	 * any error occurs, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject vertex.
	 * @param mixed					$theObject			Object vertex.
	 * @param mixed					$thePredicate		Relationship predicate reference.
	 * @param mixed					$theNamespace		Predicate namespace reference.
	 * @param string				$theLabel			Predicate label.
	 * @param string				$theDescription		Predicate description.
	 * @param string				$theLanguage		Label and description language code.
	 *
	 * @access public
	 * @return COntologyEdge		Relationship edge object.
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 * @uses _RelateTo()
	 * @uses Connection()
	 */
	public function RelateTo( $theSubject, $theObject, $thePredicate,
							  $theNamespace = NULL,
							  $theLabel = NULL, $theDescription = NULL,
							  $theLanguage = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Create edge.
			//
			$edge = $this->_RelateTo( $theSubject, $theObject, $thePredicate,
									  $theNamespace, $theLabel, $theDescription,
									  $theLanguage );
			
			//
			// Commit edge.
			//
			$status = $edge->Insert( $this->Connection() );
			
			return $edge;															// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // RelateTo.

	 
	/*===================================================================================
	 *	SubclassOf																		*
	 *==================================================================================*/

	/**
	 * <h4>Create a sub-class edge</h4>
	 *
	 * This method can be used to instantiate a {@link kPREDICATE_SUBCLASS_OF} edge by
	 * providing the subject and object vertex nodes. The predicate term is inferred to have
	 * a namespace with an empty code and a local code of {@link kPREDICATE_SUBCLASS_OF}; if
	 * the term does not exist, it will be created.
	 *
	 * The method will return an instance of the {@link COntologyEdge} class, if any error
	 * occurs, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject vertex.
	 * @param mixed					$theObject			Object vertex.
	 *
	 * @access public
	 * @return COntologyEdge		Relationship edge object.
	 *
	 * @throws Exception
	 *
	 * @uses RelateTo()
	 *
	 * @see kPREDICATE_SUBCLASS_OF
	 */
	public function SubclassOf( $theSubject, $theObject )
	{
		return $this->RelateTo( $theSubject, $theObject, kPREDICATE_SUBCLASS_OF );	// ==>

	} // SubclassOf.

	 
	/*===================================================================================
	 *	MethodOf																		*
	 *==================================================================================*/

	/**
	 * <h4>Create a method-of edge</h4>
	 *
	 * This method can be used to instantiate a {@link kPREDICATE_METHOD_OF} edge by
	 * providing the subject and object vertex nodes. The predicate term is inferred to have
	 * a namespace with an empty code and a local code of {@link kPREDICATE_METHOD_OF}; if
	 * the term does not exist, it will be created.
	 *
	 * The method will return an instance of the {@link COntologyEdge} class, if any error
	 * occurs, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject vertex.
	 * @param mixed					$theObject			Object vertex.
	 *
	 * @access public
	 * @return COntologyEdge		Relationship edge object.
	 *
	 * @throws Exception
	 *
	 * @uses RelateTo()
	 *
	 * @see kPREDICATE_METHOD_OF
	 */
	public function MethodOf( $theSubject, $theObject )
	{
		return $this->RelateTo( $theSubject, $theObject, kPREDICATE_METHOD_OF );	// ==>

	} // MethodOf.

	 
	/*===================================================================================
	 *	ScaleOf																			*
	 *==================================================================================*/

	/**
	 * <h4>Create a scale-of edge</h4>
	 *
	 * This method can be used to instantiate a {@link kPREDICATE_SCALE_OF} edge by
	 * providing the subject and object vertex nodes. The predicate term is inferred to have
	 * a namespace with an empty code and a local code of {@link kPREDICATE_SCALE_OF}; if
	 * the term does not exist, it will be created.
	 *
	 * The method will return an instance of the {@link COntologyEdge} class, if any error
	 * occurs, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject vertex.
	 * @param mixed					$theObject			Object vertex.
	 *
	 * @access public
	 * @return COntologyEdge		Relationship edge object.
	 *
	 * @throws Exception
	 *
	 * @uses RelateTo()
	 *
	 * @see kPREDICATE_SCALE_OF
	 */
	public function ScaleOf( $theSubject, $theObject )
	{
		return $this->RelateTo( $theSubject, $theObject, kPREDICATE_SCALE_OF );		// ==>

	} // ScaleOf.

	 
	/*===================================================================================
	 *	EnumOf																			*
	 *==================================================================================*/

	/**
	 * <h4>Create a enumeration-of edge</h4>
	 *
	 * This method can be used to instantiate a {@link kPREDICATE_ENUM_OF} edge by
	 * providing the subject and object vertex nodes. The predicate term is inferred to have
	 * a namespace with an empty code and a local code of {@link kPREDICATE_ENUM_OF}; if
	 * the term does not exist, it will be created.
	 *
	 * The method will return an instance of the {@link COntologyEdge} class, if any error
	 * occurs, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject vertex.
	 * @param mixed					$theObject			Object vertex.
	 *
	 * @access public
	 * @return COntologyEdge		Relationship edge object.
	 *
	 * @throws Exception
	 *
	 * @uses RelateTo()
	 *
	 * @see kPREDICATE_ENUM_OF
	 */
	public function EnumOf( $theSubject, $theObject )
	{
		return $this->RelateTo( $theSubject, $theObject, kPREDICATE_ENUM_OF );		// ==>

	} // EnumOf.

		

/*=======================================================================================
 *																						*
 *									PUBLIC EXPORT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ExportTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a term</h4>
	 *
	 * The main duty of this method is to normalise and merge the provided term's attributes
	 * and place this information in the related provided collection container.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, this collection is divided in four elements:
	 *	 <ul>
	 *		<li><tt>{@link kOFFSET_EXPORT_PREDICATE}</tt>: This element is an array that
	 *			holds the list of predicate terms, the array keys will be the term's
	 *			{@link kTAG_GID} and the value will be the attributes of the term. The
	 *			contents of this element are fed by the {@link _ExportTerm()} protected
	 *			method.
	 *		<li><tt>{@link kOFFSET_EXPORT_VERTEX}</tt>: This element is an array that holds
	 *			the list of vertex nodes, the array indexes refer to the node
	 *			{@link kTAG_NID} and the value to the node and referenced term
	 *			attributes. The contents of this element are fed by the
	 *			{@link _ExportNode()} protected method.
	 *		<li><tt>{@link kOFFSET_EXPORT_EDGE}</tt>: This element is an array that holds
	 *			the list of edges, the array keys will be the edge's {@link kTAG_GID} and
	 *			the value will be the edge's attributes. The contents of this element are
	 *			fed by the {@link ExportEdge()} public method.
	 *		<li><tt>{@link kOFFSET_EXPORT_TAG}</tt>: This element is an array that holds
	 *			the list of attribute tags, the array indexes will be the tag
	 *			{@link kTAG_NID} and the array values will be the tag attributes merged
	 *			with the referenced node attributes fed by the {@link _ExportNode()} protected method.
	 *	 </ul>
	 *	<li><tt>$theTerm</tt>: This parameter represents the term identifier, object or a
	 *		list of term identifiers:
	 *	 <ul>
	 *		<li><tt>array</tt>: A list of terms or term identifiers.
	 *		<li><tt>{@link COntologyTerm}</tt>: The term will be used as-is.
	 *		<li><i>other</i>: Any other type will be interpreted as a term reference and
	 *			resolved by {@link ResolveTerm()}.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 *	<li><tt>$doTags</tt>: If this flag is <tt>TRUE</tt>, the method will load the tags;
	 *		if <tt>FALSE</tt> no tags will be loaded.
	 * </ul>
	 *
	 * The method will generate an array containing the normalised attributes of the term
	 * and store the array in the provided collection {@link kOFFSET_EXPORT_PREDICATE}
	 * element indexed by the term's {@link kTAG_GID} tag. For more information please
	 * consult the {@link _ExportTerm()} method reference.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theTerm			Node identifier or list.
	 * @param array					$theAttributes		List of attribute tags.
	 * @param boolean				$doTags				TRUE means load tags.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function ExportTerm( &$theCollection, $theTerm, $theAttributes = NULL,
														   $doTags = TRUE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Handle terms list.
			//
			if( is_array( $theTerm ) )
			{
				//
				// Iterate list.
				//
				foreach( $theTerm as $id )
					$this->ExportTerm( $theCollection, $id, $theAttributes );
			
			} // Provided term identifiers list.
			
			//
			// Handle term identifier or object.
			//
			else
			{
				//
				// Init collection.
				//
				if( ! is_array( $theCollection ) )
					$theCollection = array( kOFFSET_EXPORT_PREDICATE => Array(),
											kOFFSET_EXPORT_VERTEX => Array(),
											kOFFSET_EXPORT_EDGE => Array(),
											kOFFSET_EXPORT_TAG  => Array() );
				
				//
				// Export term.
				//
				$theTerm = $this->_ExportTerm( $theTerm );
				
				//
				// Save identifier.
				//
				$id = $theTerm[ kTAG_GID ];
				
				//
				// Handle new term.
				//
				if( ! array_key_exists( $id, $theCollection[ kOFFSET_EXPORT_PREDICATE ] ) )
				{
					//
					// Reduce attributes.
					//
					if( is_array( $theAttributes ) )
					{
						//
						// Iterate term attributes.
						//
						foreach( $theTerm as $key => $value )
						{
							//
							// Remove excluded.
							//
							if( ! in_array( $key, $theAttributes ) )
								unset( $theTerm[ $key ] );
						
						} // Iterating term attributes.
					
					} // Provided attributes selection.
					
					//
					// Add to collection.
					//
					$theCollection[ kOFFSET_EXPORT_PREDICATE ][ $id ] = $theTerm;
					
					//
					// Get term tags.
					//
					if( $doTags )
						$this->ExportTag( $theCollection,
										  array_keys( $theTerm ),
										  $theAttributes );
				
				} // New term.
			
			} // Provided term identifier or object.
			
		} // Object is ready.
		
		else
			throw new Exception
				( "Object is not initialised",
				  kERROR_STATE );												// !@! ==>

	} // ExportTerm.

	 
	/*===================================================================================
	 *	ExportNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a node</h4>
	 *
	 * The main duty of this method is to provide a common display format for the elements
	 * of the graph, given a node identifier or identifiers list, this method will resolve
	 * all its references and return a single object that merges all its term and node
	 * attributes.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, this collection is divided in four elements:
	 *	 <ul>
	 *		<li><tt>{@link kCONTAINER_TERM_NAME}</tt>: This element is an array that holds
	 *			a list of terms, the array keys will be the term's {@link kTAG_GID} and
	 *			the value will be the attributes of the term. The contents of this element
	 *			are fed by the {@link _ExportTerm()} protected method.
	 *		<li><tt>{@link kCONTAINER_NODE_NAME}</tt>: This element is an array that holds
	 *			a list of nodes, the array indexes refer to the node {@link kTAG_NID} and
	 *			the value to the node and referenced term attributes. The contents of this
	 *			element are fed by the {@link _ExportNode()} protected method.
	 *		<li><tt>{@link kCONTAINER_EDGE_NAME}</tt>: This element is an array that holds
	 *			a list of edges, the array keys will be the edge's {@link kTAG_GID} and the
	 *			value will be the edge's attributes. The contents of this element are fed by
	 *			the {@link ExportEdge()} public method.
	 *		<li><tt>{@link kCONTAINER_TAG_NAME}</tt>: This element is an array that holds
	 *			a list of tags, the array indexes will be the tag {@link kTAG_NID} and
	 *			the array values will be the tag attributes merged with the referenced node
	 *			attributes fed by the {@link _ExportNode()} protected method.
	 *	 </ul>
	 *	<li><tt>$theNode</tt>: This parameter represents the node identifier, object or a
	 *		list of node identifiers:
	 *	 <ul>
	 *		<li><tt>array</tt>: A list of nodes or node identifiers.
	 *		<li><tt>{@link COntologyVertex}</tt>: The node will be used as-is.
	 *		<li><i>other</i>: Any other type will be interpreted as a node reference and
	 *			resolved with {@link ResolveNode()}.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 *	<li><tt>$doTags</tt>: If this flag is <tt>TRUE</tt>, the method will load the tags;
	 *		if <tt>FALSE</tt> no tags will be loaded.
	 * </ul>
	 *
	 * The method will generate an array containing the merged attributes of the node and
	 * the referenced term, this array will be set in the {@link kOFFSET_EXPORT_VERTEX} of
	 * the <tt>&$theCollection</tt> parameter with as index the node {@link kTAG_NID}.
	 * If a matching element already exists in the <tt>&$theCollection</tt> parameter, the
	 * method will do nothing.
	 *
	 * For more information please consult the {@link _ExportNode()} method reference, note
	 * that this method will remove the {@link kTAG_NID} attribute from the node, it
	 * will only use this information to index the node.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theNode			Node identifier or list.
	 * @param array					$theAttributes		List of attribute tags.
	 * @param boolean				$doTags				TRUE means load tags.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function ExportNode( &$theCollection, $theNode, $theAttributes = NULL,
														   $doTags = TRUE )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Handle nodes list.
			//
			if( is_array( $theNode ) )
			{
				//
				// Iterate list.
				//
				foreach( $theNode as $id )
					$this->ExportNode( $theCollection, $id, $theLanguage, $theAttributes );
			
			} // Provided node identifiers list.
			
			//
			// Handle node identifier or object.
			//
			else
			{
				//
				// Init collection.
				//
				if( ! is_array( $theCollection ) )
					$theCollection = array( kOFFSET_EXPORT_PREDICATE => Array(),
											kOFFSET_EXPORT_VERTEX => Array(),
											kOFFSET_EXPORT_EDGE => Array(),
											kOFFSET_EXPORT_TAG  => Array() );
				
				//
				// Export node.
				//
				$theNode = $this->_ExportNode( $theNode );
				
				//
				// Save identifier.
				//
				$id = $theNode[ kTAG_NID ];
				
				//
				// Remove from source.
				//
				unset( $theNode[ kTAG_NID ] );
				
				//
				// Handle new node.
				//
				if( ! array_key_exists( $id, $theCollection[ kOFFSET_EXPORT_VERTEX ] ) )
				{
					//
					// Reduce attributes.
					//
					if( is_array( $theAttributes ) )
					{
						//
						// Iterate term attributes.
						//
						foreach( $theNode as $key => $value )
						{
							//
							// Remove excluded.
							//
							if( ! in_array( $key, $theAttributes ) )
								unset( $theNode[ $key ] );
						
						} // Iterating node attributes.
					
					} // Provided attributes selection.
					
					//
					// Add to collection.
					//
					$theCollection[ kOFFSET_EXPORT_VERTEX ][ $id ] = $theNode;
					
					//
					// Get node tags.
					//
					if( $doTags )
						$this->ExportTag( $theCollection,
										  array_keys( $theNode ),
										  $theAttributes );
				
				} // New node.
			
			} // Provided node identifier or object.
			
		} // Object is ready.
		
		else
			throw new Exception
				( "Object is not initialised",
				  kERROR_STATE );												// !@! ==>

	} // ExportNode.

	 
	/*===================================================================================
	 *	ExportEdge																		*
	 *==================================================================================*/

	/**
	 * <h4>Export an edge</h4>
	 *
	 * The main duty of this method is to normalise the edge's attributes and store the
	 * referenced vertex and predicates in the relative elements of the provided collection.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, this collection is divided in four elements:
	 *	 <ul>
	 *		<li><tt>{@link kOFFSET_EXPORT_PREDICATE}</tt>: This element is an array that
	 *			holds the list of predicate terms, the array keys will be the term's
	 *			{@link kTAG_GID} and the value will be the attributes of the term. The
	 *			contents of this element are fed by the {@link _ExportTerm()} protected
	 *			method.
	 *		<li><tt>{@link kOFFSET_EXPORT_VERTEX}</tt>: This element is an array that holds
	 *			the list of vertex nodes, the array indexes refer to the node
	 *			{@link kTAG_NID} and the value to the node and referenced term
	 *			attributes. The contents of this element are fed by the
	 *			{@link _ExportNode()} protected method.
	 *		<li><tt>{@link kOFFSET_EXPORT_EDGE}</tt>: This element is an array that holds
	 *			the list of edges, the array keys will be the edge's {@link kTAG_GID} and
	 *			the value will be the edge's attributes. The contents of this element are
	 *			fed by the {@link ExportEdge()} public method.
	 *		<li><tt>{@link kOFFSET_EXPORT_TAG}</tt>: This element is an array that holds
	 *			the list of attribute tags, the array indexes will be the tag
	 *			{@link kTAG_NID} and the array values will be the tag attributes merged
	 *			with the referenced node attributes fed by the {@link _ExportNode()} protected method.
	 *	 </ul>
	 *	<li><tt>$theEdge</tt>: This parameter represents the edge object or a list of edges:
	 *	 <ul>
	 *		<li><tt>array</tt>: A list of edges.
	 *		<li><tt>{@link COntologyEdge}</tt>: The edge will be used as-is.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 * </ul>
	 *
	 * The method will omit the {@link kTAG_UID} and {@link kTAG_CLASS} attributes, the
	 * {@link kTAG_PREDICATE} attribute will be set to the term's {@link kTAG_GID} attribute
	 * and the two vertex references will be left untouched. The resulting array will be
	 * set into the {@link kOFFSET_EXPORT_EDGE} element of the provided collection.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theEdge			Edge or edges list.
	 * @param array					$theAttributes		List of attribute tags.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function ExportEdge( &$theCollection, $theEdge, $theAttributes = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Handle edges list.
			//
			if( is_array( $theEdge ) )
			{
				//
				// Iterate list.
				//
				foreach( $theEdge as $id )
					$this->ExportEdge( $theCollection, $id, $theAttributes );
			
			} // Provided edge identifiers list.
			
			//
			// Handle edge object.
			//
			elseif( $theEdge instanceof COntologyEdge )
			{
				//
				// Init local storage.
				//
				$export = Array();
				$exclude = array( kTAG_CLASS, kTAG_UID, kTAG_GID,
								  kTAG_SUBJECT, kTAG_PREDICATE, kTAG_OBJECT );
				
				//
				// Init collection.
				//
				if( ! is_array( $theCollection ) )
					$theCollection = array( kOFFSET_EXPORT_PREDICATE => Array(),
											kOFFSET_EXPORT_VERTEX => Array(),
											kOFFSET_EXPORT_EDGE => Array(),
											kOFFSET_EXPORT_TAG  => Array() );
				
				//
				// Save identifier.
				//
				$id = $theEdge->offsetGet( kTAG_GID );
				
				//
				// Handle new edge.
				//
				if( ! array_key_exists( $id, $theCollection[ kOFFSET_EXPORT_EDGE ] ) )
				{
					//
					// Export subject vertex.
					//
					$export[ kTAG_SUBJECT ]
						= $theEdge->offsetGet( kTAG_SUBJECT );
					$this->ExportNode( $theCollection,
									   $export[ kTAG_SUBJECT ],
									   $theAttributes );
					
					//
					// Resolve predicate.
					//
					$predicate = $this->ResolveTerm(
									$theEdge->offsetGet( kTAG_PREDICATE ), NULL, TRUE );
					$export[ kTAG_PREDICATE ] = $predicate->offsetGet( kTAG_GID );
					
					//
					// Export predicate.
					//
					$this->ExportTerm( $theCollection, $predicate, $theAttributes );
					
					//
					// Export object vertex.
					//
					$export[ kTAG_OBJECT ]
						= $theEdge->offsetGet( kTAG_OBJECT );
					$this->ExportNode( $theCollection,
									   $export[ kTAG_OBJECT ],
									   $theAttributes );
					
					//
					// Copy attributes.
					//
					foreach( $theEdge as $key => $value )
					{
						//
						// Skip excluded.
						//
						if( ! in_array( $key, $exclude ) )
						{
							//
							// Handle included.
							//
							if( (! is_array( $theAttributes ))
							 || (! in_array( $key, $theAttributes )) )
								$export[ $key ] = $theEdge->offsetGet( $key );
						
						} // Not excluded.
					
					} // Iterating edge attributes.
					
					//
					// Set edge in collection.
					//
					$theCollection[ kOFFSET_EXPORT_EDGE ][ $id ] = $export;
				
				} // New edge.
			
			} // Provided node identifier.
			
			//
			// Invalid edge reference.
			//
			else
				throw new Exception
					( "Invalid edge reference",
					  kERROR_PARAMETER );										// !@! ==>
			
		} // Object is ready.
		
		else
			throw new Exception
				( "Object is not initialised",
				  kERROR_STATE );												// !@! ==>

	} // ExportEdge.
	
	
	/*===================================================================================
	 *	ExportTag																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a tag</h4>
	 *
	 * The main duty of this method is to normalise the tag's attributes and store the
	 * referenced terms and nodes in the relative elements of the provided collection.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theCollection</tt>: This parameter is a reference to an array that will
	 *		receive the object attributes, this collection is divided in four elements:
	 *	 <ul>
	 *		<li><tt>{@link kOFFSET_EXPORT_PREDICATE}</tt>: This element is an array that
	 *			holds the list of predicate terms, the array keys will be the term's
	 *			{@link kTAG_GID} and the value will be the attributes of the term. The
	 *			contents of this element are fed by the {@link _ExportTerm()} protected
	 *			method.
	 *		<li><tt>{@link kOFFSET_EXPORT_VERTEX}</tt>: This element is an array that holds
	 *			the list of vertex nodes, the array indexes refer to the node
	 *			{@link kTAG_NID} and the value to the node and referenced term
	 *			attributes. The contents of this element are fed by the
	 *			{@link _ExportNode()} protected method.
	 *		<li><tt>{@link kOFFSET_EXPORT_EDGE}</tt>: This element is an array that holds
	 *			the list of edges, the array keys will be the edge's {@link kTAG_GID} and
	 *			the value will be the edge's attributes. The contents of this element are
	 *			fed by the {@link ExportEdge()} public method.
	 *		<li><tt>{@link kOFFSET_EXPORT_TAG}</tt>: This element is an array that holds
	 *			the list of attribute tags, the array indexes will be the tag
	 *			{@link kTAG_NID} and the array values will be the tag attributes merged
	 *			with the referenced node attributes fed by the {@link _ExportNode()} protected method.
	 *	 </ul>
	 *	<li><tt>$theTag</tt>: This parameter represents the tag identifier, object or a
	 *		list of tag identifiers:
	 *	 <ul>
	 *		<li><tt>array</tt>: A list of tag or node identifiers.
	 *		<li><tt>{@link COntologyTag}</tt>: The tag will be used as-is.
	 *		<li><i>other</i>: Any other type will be interpreted as a tag reference and
	 *			resolved with {@link ResolveTag()}.
	 *	 </ul>
	 *	<li><tt>$theAttributes</tt>: This optional parameter can be used to limit the
	 *		returned attributes to the list provided in this array.
	 * </ul>
	 *
	 * The method will generate an array containing the merged attributes of the tag and the
	 * exported attributes of the referenced nodes, generated by the {@link _ExportNode()}
	 * protected method. The method will exclude the {@link kTAG_NID}, {@link kTAG_UID},
	 * and {@link kTAG_CLASS} from the tag, but append all others
	 * to the merged node and term attributes. The predicate elements of the
	 * {@link KTAG_PATH} attribute will be set to the referenced term's {@link kTAG_GID}.
	 * The resulting array will be set in the {@link kOFFSET_EXPORT_TAG} element of the
	 * provided collection using the tag's {@link kTAG_NID} attribute as index.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param reference			   &$theCollection		Exported collection.
	 * @param mixed					$theTag				Tag identifier or list.
	 * @param array					$theAttributes		List of attribute tags.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function ExportTag( &$theCollection, $theTag, $theAttributes = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Handle tags list.
			//
			if( is_array( $theTag ) )
			{
				//
				// Iterate list.
				//
				foreach( $theTag as $id )
					$this->ExportTag( $theCollection, $id, $theAttributes );
			
			} // Provided tag identifiers list.
			
			//
			// Handle tag identifier or object.
			// Note that we exclude the native identifier.
			//
			elseif( $theTag != kTAG_NID )
			{
				//
				// Init local storage.
				//
				$export = Array();
				$exclude = array( kTAG_NID, kTAG_CLASS, kTAG_UID, kTAG_PATH );
				
				//
				// Init collection.
				//
				if( ! is_array( $theCollection ) )
					$theCollection = array( kOFFSET_EXPORT_PREDICATE => Array(),
											kOFFSET_EXPORT_VERTEX => Array(),
											kOFFSET_EXPORT_EDGE => Array(),
											kOFFSET_EXPORT_TAG  => Array() );
			
				//
				// Resolve tag.
				//
				if( ! ($theTag instanceof COntologyTag) )
					$theTag = $this->ResolveTag( $theTag, TRUE );
				
				//
				// Save identifier.
				//
				$id = $theTag->offsetGet( kTAG_NID );
				
				//
				// Check if new.
				//
				if( ! array_key_exists( $id, $theCollection[ kOFFSET_EXPORT_TAG ] ) )
				{
					//
					// Save path.
					//
					$path = $theTag->offsetGet( kTAG_PATH );
					
					//
					// Iterate path elements.
					//
					for( $i = 0; $i < count( $path ); $i++ )
					{
						//
						// Handle predicate.
						//
						if( $i % 2 )
						{
							//
							// Resolve predicate.
							//
							$predicate = $this->ResolveTerm( $path[ $i ], NULL, TRUE );
							
							//
							// Set term reference.
							//
							$path[ $i ] = $predicate->offsetGet( kTAG_GID );
							
							//
							// Export predicate.
							//
							$this->ExportTerm( $theCollection, $predicate, $theAttributes );
						
						} // Predicate term.
						
						//
						// Handle vertex.
						//
						else
							$this->ExportNode(
									$theCollection, $path[ $i ], $theAttributes );
					
					} // Iterating path elements.
					
					//
					// Store path in export.
					//
					$export[ kTAG_PATH ] = $path;
					
					//
					// Copy attributes.
					//
					foreach( $theTag as $key => $value )
					{
						//
						// Skip excluded.
						//
						if( ! in_array( $key, $exclude ) )
						{
							//
							// Handle included.
							//
							if( (! is_array( $theAttributes ))
							 || (! in_array( $key, $theAttributes )) )
								$export[ $key ] = $theTag->offsetGet( $key );
						
						} // Not excluded.
					
					} // Iterating tag attributes.
				
					//
					// Set tag in collection.
					//
					$theCollection[ kOFFSET_EXPORT_TAG ][ $id ] = $export;
				
				} // New tag.
			
			} // Provided tag identifier.
			
		} // Object is ready.
		
		else
			throw new Exception
				( "Object is not initialised",
				  kERROR_STATE );												// !@! ==>

	} // ExportTag.

		

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
	 *	<li><tt>$theAttributes</tt>: An optional list of additional key/value attributes.
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
	 * @param array					$theAttributes		Additional attributes list.
	 *
	 * @access protected
	 * @return COntologyTerm		New committed term.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 */
	protected function _NewTerm( $theIdentifier, $theNamespace,
								 $theLabel, $theDescription, $theLanguage,
								 $theAttributes )
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
				// Set additional attributes.
				//
				if( $theAttributes !== NULL )
				{
					//
					// Append attributes.
					//
					foreach( $theAttributes as $key => $value )
						$term->offsetSet( $key, $value );
				
				} // Provided additional atributes
				
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
	 * <h4>Instantiate a new node</h4>
	 *
	 * This method can be used to instantiate a new node and commit it.
	 *
	 * The method will first instantiate the node from the provided parameter, then it
	 * will insert it and finally return it, if there were no errors.
	 *
	 * This method is used by the public interface to perform the actual creation of nodes.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theTerm</tt>: This parameter represents the term reference, it can be
	 *		provided as the term object or term native identifier.
	 *	<li><tt>$theKind</tt>: This parameter represents the node kind, it can be provided
	 *		as a list of values, as a scalar value or as <tt>NULL</tt>.
	 *	<li><tt>$theType</tt>: This parameter represents the node type, it can be provided
	 *		as a list of values, as a scalar value or as <tt>NULL</tt>.
	 * </ul>
	 *
	 * The method will return a new committed node or raise an exception if the node is a
	 * duplicate.
	 *
	 * @param mixed					$theTerm			Term object or identifier.
	 * @param mixed					$theKind			Node kind value or values.
	 * @param mixed					$theType			Node type value.
	 *
	 * @access protected
	 * @return COntologyVertex		New committed node.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
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
				$node = new COntologyVertex();
				
				//
				// Set term reference.
				//
				$node->Term( $theTerm );
				
				//
				// Set kind.
				//
				if( $theKind !== NULL )
					$node->Kind( $theKind, TRUE );
				
				//
				// Set type.
				//
				if( $theType !== NULL )
					$node->Type( $theType, TRUE );
				
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

		

/*=======================================================================================
 *																						*
 *								PROTECTED OPERATIONS INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_RelateTo																		*
	 *==================================================================================*/

	/**
	 * <h4>Create an edge</h4>
	 *
	 * This method can be used to instantiate an edge by providing the subject and object
	 * vertex nodes and the edge predicate term. The method makes use of the subject node's
	 * {@link CNode::RelateTo()} method to perform the actual operation. This method will
	 * only ensure that the subject node is committed before calling its method.
	 *
	 * The method expects the vertex nodes to be provided as node references, the predicate
	 * term can be created by this method by providing its attributes.
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Subject node reference.
	 *	<li><tt>$theObject</tt>: Object node reference.
	 *	<li><tt>$thePredicate</tt>: This parameter represents the predicate term reference,
	 *		object or local identifier.
	 *	<li><tt>$theNamespace</tt>: The predicate namespace, it can be provided in several
	 *		ways:
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
	 * The method will return an instance of the {@link COntologyEdge} class, if any error
	 * occurs, the method will raise an exception.
	 *
	 * @param mixed					$theSubject			Subject vertex.
	 * @param mixed					$theObject			Object vertex.
	 * @param mixed					$thePredicate		Relationship predicate reference.
	 * @param mixed					$theNamespace		Predicate namespace reference.
	 * @param string				$theLabel			Predicate label.
	 * @param string				$theDescription		Predicate description.
	 * @param string				$theLanguage		Label and description language code.
	 *
	 * @access protected
	 * @return CEdge				Relationship edge object.
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 * @uses Connection()
	 * @uses ResolveNode()
	 * @uses NewTerm()
	 */
	protected function _RelateTo( $theSubject, $theObject, $thePredicate,
								  $theNamespace = NULL,
								  $theLabel = NULL, $theDescription = NULL,
								  $theLanguage = NULL )
	{
		//
		// Check if object is ready.
		//
		if( $this->_IsInited() )
		{
			//
			// Resolve subject.
			//
			if( ! ($theSubject instanceof COntologyVertex) )
			{
				//
				// Resolve node.
				//
				$theSubject = $this->NewNode( $theSubject );
				if( is_array( $theSubject ) )
				{
					//
					// Handle many references.
					//
					if( count( $theSubject ) > 1 )
						throw new Exception
							( "Multiple reference subject node",
							  kERROR_PARAMETER );								// !@! ==>
					
					//
					// Use first.
					//
					$theSubject = $theSubject[ 0 ];
				
				} // Found nodes.
			
			} // Provided subject reference.
			
			//
			// Resolve object.
			//
			if( ! ($theObject instanceof COntologyVertex) )
			{
				//
				// Resolve node.
				//
				$theObject = $this->NewNode( $theObject );
				if( is_array( $theObject ) )
				{
					//
					// Handle many references.
					//
					if( count( $theObject ) > 1 )
						throw new Exception
							( "Multiple reference object node",
							  kERROR_PARAMETER );								// !@! ==>
					
					//
					// Use first.
					//
					$theObject = $theObject[ 0 ];
				
				} // Found nodes.
			
			} // Provided object reference.
			
			//
			// Resolve predicate.
			//
			$thePredicate = $this->NewTerm( $thePredicate, $theNamespace,
											$theLabel, $theDescription,
											$theLanguage );
			
			return $theSubject->RelateTo( $thePredicate, $theObject );				// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // _RelateTo.

		

/*=======================================================================================
 *																						*
 *								PROTECTED EXPORT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ExportTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a term</h4>
	 *
	 * The main duty of this method is to resolve the provided term reference and return a
	 * single object that holds a merged selection of attributes.
	 *
	 * By default we include the {@link kTAG_LID}, {@link kTAG_GID} and the
	 * {@link kTAG_NAMESPACE} (resolved into its {@link kTAG_GID}) from the current term.
	 *
	 * We omit the {@link kTAG_NID}, {@link kTAG_CLASS}, {@link kTERM_TERM}, 
	 * {@link kTERM_NAMESPACE_REFS} and {@link kTERM_NODES}.
	 *
	 * All other attributes will either be included from the current term, or, if the term
	 * is related to another term through its {@link kTERM_TERM} attribute, from that
	 * term.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param integer				$theTerm			Term object or reference.
	 *
	 * @access public
	 * @return array				Exported term.
	 */
	public function _ExportTerm( $theTerm )
	{
		//
		// Init local storage.
		//
		$export = Array();
		$exclude = array( kTAG_NID, kTAG_CLASS, kTAG_TERM,
						  kTAG_NAMESPACE_REFS, kTAG_NODES,
						  kTAG_GID, kTAG_LID, kTAG_NAMESPACE, kTAG_TERM );
		
		//
		// Resolve term.
		//
		if( ! ($theTerm instanceof COntologyTerm) )
			$theTerm = $this->ResolveTerm( $theTerm, NULL, TRUE );
		
		//
		// Load default attributes.
		//
		$export[ kTAG_GID ] = $theTerm->offsetGet( kTAG_GID );
		$export[ kTAG_LID ] = $theTerm->offsetGet( kTAG_LID );
		
		//
		// Resolve namespace.
		//
		if( $theTerm->offsetExists( kTAG_NAMESPACE ) )
			$export[ kTAG_NAMESPACE ]
				= $this->ResolveTerm( $theTerm->offsetGet( kTAG_NAMESPACE ), NULL, TRUE )
					->offsetGet( kTAG_GID );
		
		//
		// Resolve term references, if necessary.
		//
		while( $theTerm->offsetExists( kTAG_TERM ) )
			$theTerm = $this->ResolveTerm( $theTerm[ kTAG_TERM ], NULL, TRUE );
		
		//
		// Copy attributes.
		//
		foreach( $theTerm as $key => $value )
		{
			//
			// Skip excluded.
			//
			if( ! in_array( $key, $exclude ) )
				$export[ $key ] = $value;
		}
		
		return $export;																// ==>

	} // _ExportTerm.

	 
	/*===================================================================================
	 *	_ExportNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Export a node</h4>
	 *
	 * The main duty of this method is to resolve the provided node reference and return a
	 * single object that merges all its term and node attributes.
	 *
	 * The method will return an array containing the merged attributes of the node and
	 * the referenced term. By default, in case of conflict, the node attributes will
	 * overwrite the term attributes, in all cases, however, the {@link kTAG_LID} and
	 * {@link kTAG_GID} will be taken from the term.
	 *
	 * We omit the {@link kTAG_CLASS}, {@link kTAG_TERM} (the term's attributes are merged
	 * with the node's attributes) and {@link kTAG_EDGES}.
	 *
	 * All other attributes will either be included from the referenced term, or will be
	 * taken by the current node; note that the node attributes will overwrite the term
	 * attributes.
	 *
	 * The method will raise an exception if any element cannot be resolved.
	 *
	 * @param integer				$theNode			Node object or reference.
	 *
	 * @access public
	 * @return array				Exported node.
	 */
	public function _ExportNode( $theNode )
	{
		//
		// Init local storage.
		//
		$export = Array();
		$exclude = array( kTAG_NID, kTAG_LID, kTAG_GID, kTAG_CLASS,
						  kTAG_TERM, kTAG_EDGES );
		
		//
		// Resolve node.
		//
		if( ! ($theNode instanceof COntologyVertex) )
			$theNode = $this->ResolveNode( $theNode, TRUE );
		
		//
		// Set node identifier.
		//
		$export[ kTAG_NID ] = $theNode[ kTAG_NID ];
		
		//
		// Export node term.
		//
		$term = $this->_ExportTerm( $theNode->offsetGet( kTAG_TERM ) );
		
		//
		// Load term attributes.
		//
		foreach( $term as $key => $value )
			$export[ $key ] = $value;
		
		//
		// Load node attributes.
		//
		foreach( $theNode as $key => $value )
		{
			//
			// Skip excluded.
			//
			if( ! in_array( $key, $exclude ) )
				$export[ $key ] = $value;
		}
		
		return $export;																// ==>

	} // _ExportNode.

		

/*=======================================================================================
 *																						*
 *						PROTECTED ONTOLOGY INITIALISATION INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_InitOntologyContainers															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise ontology containers</h4>
	 *
	 * This method will reset and create indexes for containers related to terms, nodes,
	 * edges, tags and sequences.
	 *
	 * <b>When calling this method you must be aware that all the ontology data will be
	 * erased, this method for intended to create a new ontology. This must be the first
	 * method called by the procedure that initialises the ontology.</b>
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses NewTerm()
	 */
	protected function _InitOntologyContainers()
	{
		//
		// Get database.
		//
		$db = $this->GetDatabase();
		if( ! ($db instanceof CDatabase) )
			throw new Exception
				( "Unable to retrieve database connection",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Get terms container.
		//
		$container = COntologyTerm::DefaultContainer( $db );
		if( ! ($container instanceof CContainer) )
			throw new Exception
				( "Unable to retrieve terms container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Init terms container.
		//
		$container->drop();
		$container->AddIndex( array( kTAG_LID => 1 ) );
		$container->AddIndex( array( kTAG_TERM => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_NAMESPACE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_NODES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EDGES => 1 ), array( 'sparse' => TRUE ) );
		
		//
		// Get nodes container.
		//
		$container = COntologyVertex::DefaultContainer( $db );
		if( ! ($container instanceof CContainer) )
			throw new Exception
				( "Unable to retrieve nodes container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Init nodes container.
		//
		$container->drop();
		$container->AddIndex( array( kTAG_TERM => 1 ) );
		$container->AddIndex( array( kTAG_KIND => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_TYPE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EDGES => 1 ), array( 'sparse' => TRUE ) );
		
		//
		// Get edges container.
		//
		$container = COntologyEdge::DefaultContainer( $db );
		if( ! ($container instanceof CContainer) )
			throw new Exception
				( "Unable to retrieve edges container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Init edges container.
		//
		$container->drop();
		$container->AddIndex( array( kTAG_UID => 1 ), array( 'unique' => TRUE ) );
		$container->AddIndex( array( kTAG_PREDICATE => 1 ) );
		$container->AddIndex( array( kTAG_SUBJECT => 1 ) );
		$container->AddIndex( array( kTAG_OBJECT => 1 ) );
		
		//
		// Get tags container.
		//
		$container = COntologyTag::DefaultContainer( $db );
		if( ! ($container instanceof CContainer) )
			throw new Exception
				( "Unable to retrieve tags container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Init tags container.
		//
		$container->drop();
		$container->AddIndex( array( kTAG_UID => 1 ), array( 'unique' => TRUE ) );
	//	$container->AddIndex( array( kTAG_PATH => 1 ) );
		
		//
		// Get sequences container.
		//
		$container = $db->Container( kCONTAINER_SEQUENCE_NAME );
		if( ! ($container instanceof CContainer) )
			throw new Exception
				( "Unable to retrieve sequences container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Init sequences container.
		//
		$container->drop();

	} // _InitOntologyContainers.

	 
	/*===================================================================================
	 *	_InitDefaultNamespace															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default namespaces</h4>
	 *
	 * This method will first erase the current database and then create the default
	 * namespace.
	 *
	 * The method assumed that the object is {@link _IsInited()} and that the current
	 * {@link Connection()} is a database.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses NewTerm()
	 */
	protected function _InitDefaultNamespace()
	{
		//
		// Get database.
		//
		$db = $this->GetDatabase();
		if( ! ($db instanceof CDatabase) )
			throw new Exception
				( "Unable to retrieve database connection",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Create default namespace.
		//
		$this->NewTerm(
				"", NULL,
				"Default namespace",
				"This represents the default namespace term.",
				kDEFAULT_LANGUAGE );

	} // _InitDefaultNamespace.

	 
	/*===================================================================================
	 *	_InitDefaultTypeTerms															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default data type terms</h4>
	 *
	 * This method will create all the default data type terms of the ontology.
	 *
	 * The method assumed that the object is {@link _IsInited()}, that the current
	 * {@link Connection()} is a database and that the {@link _InitDefaultNamespace()}
	 * method has been called beforehand.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 */
	protected function _InitDefaultTypeTerms()
	{
		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load term definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kTYPE_STRING, 1 ),
				   kTERM_LABEL => "String",
				   kTERM_DESCRIPTION => "Primitive string data type." ),
			array( kTERM_LID => substr( kTYPE_INT32, 1 ),
				   kTERM_LABEL => "32 bit integer",
				   kTERM_DESCRIPTION => "32 bit signed integer type." ),
			array( kTERM_LID => substr( kTYPE_INT64, 1 ),
				   kTERM_LABEL => "64 bit integer",
				   kTERM_DESCRIPTION => "64 bit signed integer type." ),
			array( kTERM_LID => substr( kTYPE_FLOAT, 1 ),
				   kTERM_LABEL => "Floating point",
				   kTERM_DESCRIPTION => "Floating point data type." ),
			array( kTERM_LID => substr( kTYPE_BOOLEAN, 1 ),
				   kTERM_LABEL => "Boolean",
				   kTERM_DESCRIPTION => "The primitive boolean data type, it is assumed that it is provided as (y/n; Yes/No; 1/0; TRUE/FALSE) and will be converted to 1/0." ),
			array( kTERM_LID => substr( kTYPE_ANY, 1 ),
				   kTERM_LABEL => "Any",
				   kTERM_DESCRIPTION => "This value represents the primitive wildcard type, itqualifies an attribute that can take any kind of value." ),
			array( kTERM_LID => substr( kTYPE_BINARY_STRING, 1 ),
				   kTERM_LABEL => "Binary string",
				   kTERM_DESCRIPTION => "The binary string data type, it differs from the {@link kTYPE_STRING} type only because it needs to be handled in a custom way to accomodate different databases." ),
			array( kTERM_LID => substr( kTYPE_DATE_STRING, 1 ),
				   kTERM_LABEL => "Date",
				   kTERM_DESCRIPTION => "A date represented as a YYYYMMDD string in which missing elements should be omitted. This means that if we don't know the day we can express that date as YYYYMM." ),
			array( kTERM_LID => substr( kTYPE_TIME_STRING, 1 ),
				   kTERM_LABEL => "Time",
				   kTERM_DESCRIPTION => "A time represented as a YYYY-MM-DD HH:MM:SS string in which you may not have missing elements." ),
			array( kTERM_LID => substr( kTYPE_REGEX_STRING, 1 ),
				   kTERM_LABEL => "Regular expression",
				   kTERM_DESCRIPTION => "This tag defines a regular expression string type." ),
			array( kTERM_LID => substr( kTYPE_LSTRING, 1 ),
				   kTERM_LABEL => "Language strings list",
				   kTERM_DESCRIPTION => "This data type represents a string attribute that can be expressed in several languages, it is implemented as an array of elements in which the index represents the language code in which the string, stored in the element data, is expressed in." ),
			array( kTERM_LID => substr( kTYPE_STAMP, 1 ),
				   kTERM_LABEL => "Time-stamp",
				   kTERM_DESCRIPTION => "This data type should be used for native time-stamps." ),
			array( kTERM_LID => substr( kTYPE_STRUCT, 1 ),
				   kTERM_LABEL => "Structure",
				   kTERM_DESCRIPTION => "This data type refers to a structure, it implies that the offset to which it refers to is a container of other offsets that will hold the actual data." ),
			array( kTERM_LID => substr( kTYPE_ENUM, 1 ),
				   kTERM_LABEL => "Enumerated scalar",
				   kTERM_DESCRIPTION => "This value represents the enumeration data type, it represents an enumeration element or container. Enumerations represent a vocabulary from which one value must be chosen, this particular data type is used in node objects: it indicates that the node refers to a controlled vocabulary scalar data type and that the enumerated set follows in the graph definition." ),
			array( kTERM_LID => substr( kTYPE_ENUM_SET, 1 ),
				   kTERM_LABEL => "Enumerated set",
				   kTERM_DESCRIPTION => "This value represents the enumerated set data type, it represents an enumerated set element or container. Sets represent a vocabulary from which one or more values must be chosen, this particular data type is used in node objects: it indicates that the node refers to a controlled vocabulary array data type and that the enumerated set follows in the graph definition." ),
			array( kTERM_LID => substr( kTYPE_PHP, 1 ),
				   kTERM_LABEL => "PHP-encoded string",
				   kTERM_DESCRIPTION => "This value represents an object or scalar serialised by PHP." ),
			array( kTERM_LID => substr( kTYPE_JSON, 1 ),
				   kTERM_LABEL => "JSON-encoded string",
				   kTERM_DESCRIPTION => "This value represents an object or scalar encoded in a JSON string." ),
			array( kTERM_LID => substr( kTYPE_XML, 1 ),
				   kTERM_LABEL => "XML-encoded string",
				   kTERM_DESCRIPTION => "This value represents an XML string." ),
			array( kTERM_LID => substr( kTYPE_SVG, 1 ),
				   kTERM_LABEL => "SVG-encoded string",
				   kTERM_DESCRIPTION => "This value represents an image encoded in an SVG string." ),
			array( kTERM_LID => substr( kTYPE_REQUIRED, 1 ),
				   kTERM_LABEL => "Required value",
				   kTERM_DESCRIPTION => "This tag indicates that the element is required, which means that the offset must be present in the object." ),
			array( kTERM_LID => substr( kTYPE_ARRAY, 1 ),
				   kTERM_LABEL => "Array value",
				   kTERM_DESCRIPTION => "This tag indicates that the element represents an array and that the data type applies to the elements of the array." ),
			array( kTERM_LID => substr( kKIND_ROOT, 1 ),
				   kTERM_LABEL => "Root node",
				   kTERM_DESCRIPTION => "This tag identifies a root or ontology node kind." ),
			array( kTERM_LID => substr( kKIND_NODE_DDICT, 1 ),
				   kTERM_LABEL => "Data dictionary node",
				   kTERM_DESCRIPTION => "This tag identifies a structure definition or data dictionary node kind, in general this will be used in conjunction to the root node kind to indicate a data structure description." ),
			array( kTERM_LID => substr( kKIND_FEATURE, 1 ),
				   kTERM_LABEL => "Trait node",
				   kTERM_DESCRIPTION => "This tag identifies a trait or measurable node kind." ),
			array( kTERM_LID => substr( kKIND_METHOD, 1 ),
				   kTERM_LABEL => "Method node",
				   kTERM_DESCRIPTION => "This tag identifies a method node kind." ),
			array( kTERM_LID => substr( kKIND_SCALE, 1 ),
				   kTERM_LABEL => "Scale node",
				   kTERM_DESCRIPTION => "This tag identifies a scale or measure node kind." ),
			array( kTERM_LID => substr( kKIND_INSTANCE, 1 ),
				   kTERM_LABEL => "Instance node",
				   kTERM_DESCRIPTION => "This tag identifies an instance node kind, it represents a definition which is also its instance." ),
			array( kTERM_LID => substr( kKIND_ENUMERATION, 1 ),
				   kTERM_LABEL => "Enumeration node",
				   kTERM_DESCRIPTION => "This tag identifies an enumerated value node kind, it represents an element of an enumerated set." ),
			array( kTERM_LID => substr( kPREDICATE_SUBCLASS_OF, 1 ),
				   kTERM_LABEL => "Subclass-of",
				   kTERM_DESCRIPTION => "This tag identifies the SUBCLASS-OF predicate term local code, this predicate indicates that the subject of the relationship is a subclass of the object of the relationship, in other words, the subject is derived from the object." ),
			array( kTERM_LID => substr( kPREDICATE_SUBSET_OF, 1 ),
				   kTERM_LABEL => "Subset-of",
				   kTERM_DESCRIPTION => "This tag identifies the SUBSET-OF predicate term local code, this predicate indicates that the subject of the relationship represents a subset of the object of the relationship, in other words, the subject is a subset of the object, or the subject is contained by the object." ),
			array( kTERM_LID => substr( kPREDICATE_METHOD_OF, 1 ),
				   kTERM_LABEL => "Method-of",
				   kTERM_DESCRIPTION => "This tag identifies the METHOD-OF predicate term local code, this predicate relates method nodes with trait nodes or other method nodes, it indicates that the subject of the relationship is a method variation of the object of the relationship." ),
			array( kTERM_LID => substr( kPREDICATE_SCALE_OF, 1 ),
				   kTERM_LABEL => "Scale-of",
				   kTERM_DESCRIPTION => "This tag identifies the SCALE-OF predicate term local code, this predicate relates scale nodes with Method or trait nodes, it indicates that the subject of the relationship represents a scale or measure that is used by a trait or method node." ),
			array( kTERM_LID => substr( kPREDICATE_ENUM_OF, 1 ),
				   kTERM_LABEL => "Enumeration-of",
				   kTERM_DESCRIPTION => "This tag identifies the ENUM-OF predicate term local code, this predicate relates enumerated set elements or controlled vocabulary elements." ),
			array( kTERM_LID => substr( kPREDICATE_PREFERRED, 1 ),
				   kTERM_LABEL => "Preferred choice",
				   kTERM_DESCRIPTION => "This tag identifies the PREFERRED predicate term local code, this predicate indicates that the object of the relationship is the preferred choice, in other words, if possible, one should use the object of the relationship in place of the subject." ),
			array( kTERM_LID => substr( kPREDICATE_VALID, 1 ),
				   kTERM_LABEL => "Valid choice",
				   kTERM_DESCRIPTION => "This tag identifies the VALID predicate term local code, this predicate indicates that the object of the relationship is the valid choice, in other words, the subject of the relationship is obsolete or not valid, and one should use the object od the relationship in its place." ),
			array( kTERM_LID => substr( kPREDICATE_LEGACY, 1 ),
				   kTERM_LABEL => "Legacy choice",
				   kTERM_DESCRIPTION => "This tag identifies the LEGACY predicate term local code, this predicate indicates that the object of the relationship is the former or legacy choice, in other words, the object of the relationship is obsolete or not valid, and one should use the subject of the relationship in its place." ),
			array( kTERM_LID => substr( kPREDICATE_XREF_EXACT, 1 ),
				   kTERM_LABEL => "Exact cross-reference",
				   kTERM_DESCRIPTION => "This tag identifies the XREF-EXACT predicate term local code, this predicate indicates that the subject and the object of the relationship represent an exact cross-reference, in other words, both elements are interchangeable." ),
			array( kTERM_LID => substr( kTYPE_MongoId, 1 ),
				   kTERM_LABEL => "MongoId",
				   kTERM_DESCRIPTION => "This tag identifies the MongoId object data type." ),
			array( kTERM_LID => substr( kTYPE_MongoCode, 1 ),
				   kTERM_LABEL => "MongoCode",
				   kTERM_DESCRIPTION => "This tag identifies the MongoCode object data type." ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			$this->NewTerm
			(
				$term[ kTERM_LID ],			// Local identifier.
				$ns,							// Namespace.
				$term[ kTERM_LABEL ],			// Label or name.
				$term[ kTERM_DESCRIPTION ],	// Description or definition.
				kDEFAULT_LANGUAGE				// Language.
			);
		}

	} // _InitDefaultTypeTerms.

	 
	/*===================================================================================
	 *	_InitDefaultAttributeTerms														*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default attribute terms</h4>
	 *
	 * This method will create all the default attribute terms of the ontology.
	 *
	 * The method assumed that the object is {@link _IsInited()}, that the current
	 * {@link Connection()} is a database and that the {@link _InitDefaultNamespace()}
	 * method has been called beforehand.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 */
	protected function _InitDefaultAttributeTerms()
	{
		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load term definitions.
		//
		$terms = array(
			array( kTERM_LID => kTAG_NID,
				   kTERM_NAMESPACE => NULL,
				   kTERM_LABEL => "Native unique identifier",
				   kTERM_DESCRIPTION => "This tag identifies the attribute that contains the native unique identifier. This value is a full or hashed representation of the object's global unique identifier optimised specifically for the container in which the object will be stored." ),
			array( kTERM_LID => substr( kTERM_LID, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Local unique identifier",
				   kTERM_DESCRIPTION => "This tag identifies the attribute that contains the local or full unique identifier. This value represents the identifier that uniquely identifies an object within a specific domain or namespace. It is by default a string constituting a portion of the global unique identifier." ),
			array( kTERM_LID => substr( kTERM_GID, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Global unique identifier",
				   kTERM_DESCRIPTION => "This tag identifies the attribute that contains the global or full unique identifier. This value will constitute the object's native key in full or hashed format." ),
			array( kTERM_LID => substr( kTERM_UID, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Unique identifier",
				   kTERM_DESCRIPTION => "This tag represents the hashed unique identifier of an object in which its native identifier is not related to the global identifier. This is generally used when the native identifier is a sequence number." ),

			array( kTERM_LID => substr( kTERM_CLASS, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Class name",
				   kTERM_DESCRIPTION => "This tag identifies the class name of the object, it can be used to instantiate a class rather than using an array when retrieving from containers." ),
			array( kTERM_LID => substr( kTERM_CATEGORY, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Object category",
				   kTERM_DESCRIPTION => "This tag identifies the object category or classification, the offset is a set of enumerations whose combination represents the classification to which the object belomngs." ),
			array( kTERM_LID => substr( kTERM_KIND, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Object kind",
				   kTERM_DESCRIPTION => "This tag identifies the object kind or type, the offset is a set of enumerations that define the kind or specific type of an object, these enumerations will be in the form of native unique identifiers of the terms that define the enumeration." ),
			array( kTERM_LID => substr( kTERM_TYPE, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Object data type",
				   kTERM_DESCRIPTION => "This tag identifies the object data type, the offset is an enumerated scalar that defines the specific data type of an object, this value will be in the form of the native unique identifier of the term that defines the enumeration." ),

			array( kTERM_LID => substr( kTERM_LABEL, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Label",
				   kTERM_DESCRIPTION => "This tag is used as the offset for the term's label, this attribute represents the term name or short description." ),
			array( kTERM_LID => substr( kTERM_DESCRIPTION, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Description",
				   kTERM_DESCRIPTION => "This tag is used as the offset for the term's description, this attribute represents the term description or definition." ),
			array( kTERM_LID => substr( kTERM_AUTHORS, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Authors",
				   kTERM_DESCRIPTION => "List of authors." ),
			array( kTERM_LID => substr( kTERM_ACKNOWLEDGMENTS, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Acknowledgments",
				   kTERM_DESCRIPTION => "General acknowledgments." ),
			array( kTERM_LID => substr( kTERM_BIBLIOGRAPHY, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Bibliography",
				   kTERM_DESCRIPTION => "List of bibliographic references." ),
			array( kTERM_LID => substr( kTERM_STATUS_MESSAGE, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Message",
				   kTERM_DESCRIPTION => "Generic message." ),
			array( kTERM_LID => substr( kTERM_NOTES, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Notes",
				   kTERM_DESCRIPTION => "Generic notes." ),
			array( kTERM_LID => substr( kTERM_EXAMPLES, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Examples",
				   kTERM_DESCRIPTION => "List of examples or templates." ),
			array( kTERM_LID => substr( kTERM_STATUS_LEVEL, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Severity",
				   kTERM_DESCRIPTION => "Code that characterises the importance or severity of a status." ),
			array( kTERM_LID => substr( kTERM_STATUS_CODE, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Code",
				   kTERM_DESCRIPTION => "Generic code." ),

			array( kTERM_LID => substr( kTERM_NAMESPACE, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Namespace",
				   kTERM_DESCRIPTION => "This tag is used as the offset for a namespace. By default this attribute contains the native unique identifier of the namespace object; if you want to refer to the namespace code, this is not the offset to use." ),
			array( kTERM_LID => substr( kTERM_TERM, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Term",
				   kTERM_DESCRIPTION => "This tag identifies a reference to a term object, its value will be the native unique identifier of the referenced term." ),
			array( kTERM_LID => substr( kTERM_SUBJECT, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Subject vertex",
				   kTERM_DESCRIPTION => "This tag identifies the reference to the subject vertex of a subject/predicate/object triplet in a graph." ),
			array( kTERM_LID => substr( kTERM_OBJECT, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Object vertex",
				   kTERM_DESCRIPTION => "This tag identifies the reference to the object vertex of a subject/predicate/object triplet in a graph." ),
			array( kTERM_LID => substr( kTERM_PREDICATE, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Predicate reference",
				   kTERM_DESCRIPTION => "This tag identifies the reference to the predicate object of a subject/predicate/object triplet in a graph." ),
			array( kTERM_LID => substr( kTERM_SYNONYMS, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Synonyms list",
				   kTERM_DESCRIPTION => "This tag identifies the synonyms offset, this attribute is a list of strings that represent alternate codes or names that identify the specific term." ),
			array( kTERM_LID => substr( kTERM_PATH, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Path",
				   kTERM_DESCRIPTION => "This tag identifies a list of items constituting a path or sequence." ),
			array( kTERM_LID => substr( kTERM_NAMESPACE_REFS, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Namespace references",
				   kTERM_DESCRIPTION => "This tag identifies namespace references, the attribute contains the count of how many times the term was referenced as a namespace." ),
			array( kTERM_LID => substr( kTERM_NODES, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Node references",
				   kTERM_DESCRIPTION => "This tag identifies node references, the attribute contains the list of identifiers of nodes that reference the current object." ),
			array( kTERM_LID => substr( kTERM_FEATURES, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Feature tag references",
				   kTERM_DESCRIPTION => "This offset identifies tag references, the attribute contains the list of tag identifiers that reference the hosting object as a feature." ),
			array( kTERM_LID => substr( kTERM_SCALES, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Scale tag references",
				   kTERM_DESCRIPTION => "This offset identifies tag references, the attribute contains the list of tag identifiers that reference the hosting object as a scale." ),
			array( kTERM_LID => substr( kTERM_EDGES, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Edge references",
				   kTERM_DESCRIPTION => "This tag identifies edge references, the attribute contains the list of identifiers of edges that reference the current node." ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			$new = new COntologyTerm();
			$new->NS( $term[ kTERM_NAMESPACE ] );
			$new->LID( $term[ kTERM_LID ] );
			$new->Label( kDEFAULT_LANGUAGE, $term[ kTERM_LABEL ] );
			$new->Description( kDEFAULT_LANGUAGE, $term[ kTERM_DESCRIPTION ] );
			$new->Insert( $this->Connection() );
		}

	} // _InitDefaultAttributeTerms.

	 
	/*===================================================================================
	 *	_InitDefaultDataDictionaries													*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default data dictionaries</h4>
	 *
	 * This method will create all the default data dictionary root nodes of the ontology.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 */
	protected function _InitDefaultDataDictionaries()
	{
		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load  definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kDDICT_ATTRIBUTES, 1 ),
				   kTERM_LABEL => "Generic attributes",
				   kTERM_DESCRIPTION => "This tag identifies the root data dictionary node of the terms object data structure, it describes the default elements comprising the term objects in this library." ),
			array( kTERM_LID => substr( kDDICT_WRAPPER, 1 ),
				   kTERM_LABEL => "Wrapper API",
				   kTERM_DESCRIPTION => "This tag identifies the root node for the wrapper web-services API." ),
			array( kTERM_LID => substr( kDDICT_TERM, 1 ),
				   kTERM_LABEL => "Ontology term",
				   kTERM_DESCRIPTION => "This tag identifies the root data dictionary node of the terms object data structure, it describes the default elements comprising the term objects in this library." ),
			array( kTERM_LID => substr( kDDICT_NODE, 1 ),
				   kTERM_LABEL => "Ontology node",
				   kTERM_DESCRIPTION => "This tag identifies the root data dictionary node of the nodes object data structure, it describes the default elements comprising the node objects in this library." ),
			array( kTERM_LID => substr( kDDICT_EDGE, 1 ),
				   kTERM_LABEL => "Ontology edge",
				   kTERM_DESCRIPTION => "This tag identifies the root data dictionary node of the edges object data structure, it describes the default elements comprising the edge objects in this library." ),
			array( kTERM_LID => substr( kDDICT_TAG, 1 ),
				   kTERM_LABEL => "Ontology tag",
				   kTERM_DESCRIPTION => "This tag identifies the root data dictionary node of the tags object data structure, it describes the default elements comprising the tag objects in this library." ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
			$this->NewNode(
				$this->NewTerm(
						$term[ kTERM_LID ],					// Local identifier.
						$ns,									// Namespace.
						$term[ kTERM_LABEL ],					// Label.
						$term[ kTERM_DESCRIPTION ],			// Description.
						kDEFAULT_LANGUAGE ),					// Language.
				array( kKIND_ROOT, kKIND_NODE_DDICT ) );	// Node kind.

	} // _InitDefaultDataDictionaries.

	 
	/*===================================================================================
	 *	_InitDefaultPredicates															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default predicate instances</h4>
	 *
	 * This method will create all the default instance root nodes of the ontology.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 */
	protected function _InitDefaultPredicates()
	{
		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Create parent term and node.
		//
		$parent_node
			= $this->NewNode(
				$this->NewTerm(
					substr( kINSTANCE_PREDICATES, 1 ),
					$ns,
					"Default predicates",
					"This tag collects all default predicate terms in this library.",
					kDEFAULT_LANGUAGE ),						// Language.
				array( kKIND_ROOT, kKIND_SCALE ),		// Node kind.
				kTYPE_ENUM );									// Node type.
		
		//
		// Load instance definitions.
		//
		$terms = array( kPREDICATE_SUBCLASS_OF, kPREDICATE_SUBSET_OF,
						kPREDICATE_METHOD_OF, kPREDICATE_SCALE_OF,
						kPREDICATE_ENUM_OF, kPREDICATE_PREFERRED,
						kPREDICATE_VALID, kPREDICATE_LEGACY,
						kPREDICATE_XREF_EXACT );
		
		//
		// Load instances.
		//
		foreach( $terms as $term )
			$this->EnumOf(
				$this->NewEnumerationNode(
					$this->ResolveTerm(
						substr( $term, 1 ),		// Local identifier.
						$ns,					// Namespace object.
						TRUE ) ),				// Raise exception on fail.
				$parent_node );

	} // _InitDefaultPredicates.

	 
	/*===================================================================================
	 *	_InitDefaultNodeKinds															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default node kind instances</h4>
	 *
	 * This method will create all the default instance root nodes of the ontology.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 */
	protected function _InitDefaultNodeKinds()
	{
		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Create parent term and node.
		//
		$parent_node
			= $this->NewNode(
				$this->NewTerm(
					substr( kINSTANCE_NODE_KINDS, 1 ),
					$ns,
					"Node kinds",
					"This tag collects all default node kind terms in this library.",
					kDEFAULT_LANGUAGE ),						// Language.
				array( kKIND_ROOT, kKIND_SCALE ),		// Node kind.
				kTYPE_ENUM );									// Node type.
		
		//
		// Load instance definitions.
		//
		$terms = array( kKIND_ROOT, kKIND_NODE_DDICT, kKIND_FEATURE,
						kKIND_METHOD, kKIND_SCALE, kKIND_ENUMERATION,
						kKIND_INSTANCE );
		
		//
		// Load instances.
		//
		foreach( $terms as $term )
			$this->EnumOf(
				$this->NewEnumerationNode(
					$this->ResolveTerm(
						substr( $term, 1 ),		// Local identifier.
						$ns,					// Namespace object.
						TRUE ) ),				// Raise exception on fail.
				$parent_node );

	} // _InitDefaultNodeKinds.

	 
	/*===================================================================================
	 *	_InitDefaultDataTypes															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default data type instances</h4>
	 *
	 * This method will create all the default instance root nodes of the ontology.
	 *
	 * <bThis method is called in the context of the ontology initialisation procedure, you
	 * should not use this method outside of that scope.</b>
	 *
	 * @access protected
	 */
	protected function _InitDefaultDataTypes()
	{
		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Create parent term and node.
		//
		$parent_node
			= $this->NewNode(
				$this->NewTerm(
					substr( kINSTANCE_DATA_TYPES, 1 ),
					$ns,
					"Data types",
					"This tag collects all default data type terms in this library.",
					kDEFAULT_LANGUAGE ),						// Language.
				array( kKIND_ROOT, kKIND_SCALE ),		// Node kind.
				kTYPE_ENUM );									// Node type.
		
		//
		// Load instance definitions.
		//
		$terms = array( kTYPE_STRING, kTYPE_INT32, kTYPE_INT64, kTYPE_FLOAT,
						kTYPE_BOOLEAN, kTYPE_ANY, kTYPE_BINARY_STRING, kTYPE_DATE_STRING,
						kTYPE_TIME_STRING, kTYPE_REGEX_STRING, kTYPE_LSTRING, kTYPE_STAMP,
						kTYPE_STRUCT, kTYPE_ENUM, kTYPE_ENUM_SET, kTYPE_PHP,
						kTYPE_JSON, kTYPE_XML, kTYPE_SVG,
						kTYPE_REQUIRED, kTYPE_ARRAY );
		
		//
		// Load instances.
		//
		foreach( $terms as $term )
			$this->EnumOf(
				$this->NewEnumerationNode(
					$this->ResolveTerm(
						substr( $term, 1 ),		// Local identifier.
						$ns,					// Namespace object.
						TRUE ) ),				// Raise exception on fail.
				$parent_node );

	} // _InitDefaultDataTypes.

	 
	/*===================================================================================
	 *	_LoadTermDataDictionary															*
	 *==================================================================================*/

	/**
	 * <h4>Load term data dictionary</h4>
	 *
	 * This method will load the ontology term, {@link COntologyTerm}, data dictionary.
	 *
	 * @access protected
	 */
	protected function _LoadTermDataDictionary()
	{
		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Loading Term data dictionary.\n" );

		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load predicate term.
		//
		$predicate
			= $this->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$ns,
				TRUE );
		
		//
		// Load data dictionary root term.
		//
		$root_node
			= $this->ResolveNode(
				$this->ResolveTerm(
					kDDICT_TERM, NULL, TRUE ),
				TRUE )[ 0 ];

		//
		// Load  definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kTERM_LID, 1 ),
				   kTERM_GID => kTERM_LID,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_GID, 1 ),
				   kTERM_GID => kTERM_GID,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_NAMESPACE, 1 ),
				   kTERM_GID => kTERM_NAMESPACE,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_BINARY_STRING ),
			array( kTERM_LID => substr( kTERM_CLASS, 1 ),
				   kTERM_GID => kTERM_CLASS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_LABEL, 1 ),
				   kTERM_GID => kTERM_LABEL,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_LSTRING ),
			array( kTERM_LID => substr( kTERM_DESCRIPTION, 1 ),
				   kTERM_GID => kTERM_DESCRIPTION,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_LSTRING ),
			array( kTERM_LID => substr( kTERM_SYNONYMS, 1 ),
				   kTERM_GID => kTERM_SYNONYMS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_ARRAY ) ),
			array( kTERM_LID => substr( kTERM_TERM, 1 ),
				   kTERM_GID => kTERM_TERM,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_BINARY_STRING ),
			array( kTERM_LID => substr( kTERM_NAMESPACE_REFS, 1 ),
				   kTERM_GID => kTERM_NAMESPACE_REFS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_INT64 ),
			array( kTERM_LID => substr( kTERM_NODES, 1 ),
				   kTERM_GID => kTERM_NODES,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_INT64, kTYPE_ARRAY ) ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			//
			// Create node and relate.
			//
			$this->SubclassOf(
				$parent_node
					= $this->NewScaleNode(
						$tmp
							= $this->ResolveTerm(
								$term[ kTERM_LID ],			// Local identifier.
								$term[ kTERM_NAMESPACE ],		// Namespace object.
								TRUE ),							// Raise exception on fail.
						$term[ kTERM_TYPE ] ),				// Data type.
				$root_node );
			
			//
			// Create tag.
			//
			$tag = NULL;
			$this->AddToTag( $tag, $parent_node );
			$this->AddToTag( $tag, TRUE );
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$tmp->GID()." ["
							  .$parent_node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		
		} // Iterating first level terms.

	} // _LoadTermDataDictionary.

	 
	/*===================================================================================
	 *	_LoadNodeDataDictionary															*
	 *==================================================================================*/

	/**
	 * <h4>Load node data dictionary</h4>
	 *
	 * This method will load the ontology node, {@link COntologyVertex}, data dictionary.
	 *
	 * @access protected
	 */
	protected function _LoadNodeDataDictionary()
	{
		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Loading Node data dictionary.\n" );

		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load predicate term.
		//
		$predicate
			= $this->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$ns,
				TRUE );
		
		//
		// Load data dictionary root term.
		//
		$root_node
			= $this->ResolveNode(
				$this->ResolveTerm(
					kDDICT_NODE, NULL, TRUE ),
				TRUE )[ 0 ];

		//
		// Load  definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kTERM_CLASS, 1 ),
				   kTERM_GID => kTERM_CLASS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_TERM, 1 ),
				   kTERM_GID => kTERM_TERM,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_BINARY_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_CATEGORY, 1 ),
				   kTERM_GID => kTERM_CATEGORY,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_ENUM_SET ),
			array( kTERM_LID => substr( kTERM_KIND, 1 ),
				   kTERM_GID => kTERM_KIND,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_ENUM_SET ),
			array( kTERM_LID => substr( kTERM_TYPE, 1 ),
				   kTERM_GID => kTERM_TYPE,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_ENUM_SET ),
			array( kTERM_LID => substr( kTERM_FEATURES, 1 ),
				   kTERM_GID => kTERM_FEATURES,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_INT64, kTYPE_ARRAY ) ),
			array( kTERM_LID => substr( kTERM_SCALES, 1 ),
				   kTERM_GID => kTERM_SCALES,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_INT64, kTYPE_ARRAY ) ),
			array( kTERM_LID => substr( kTERM_EDGES, 1 ),
				   kTERM_GID => kTERM_EDGES,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_INT64, kTYPE_ARRAY ) ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			//
			// Create node and relate.
			//
			$this->SubclassOf(
				$parent_node
					= $this->NewScaleNode(
						$tmp
							= $this->ResolveTerm(
								$term[ kTERM_LID ],			// Local identifier.
								$term[ kTERM_NAMESPACE ],		// Namespace object.
								TRUE ),							// Raise exception on fail.
						$term[ kTERM_TYPE ],					// Data type.
						NULL,									// Namespace.
						NULL,									// Label.
						NULL,									// Description.
						NULL,									// Language.
						TRUE ),									// New node flag.
				$root_node );
			
			//
			// Create tag.
			//
			$tag = $this->ResolveTag( $tmp );
			if( $tag === NULL )
			{
				$this->AddToTag( $tag, $parent_node );
				$this->AddToTag( $tag, TRUE );
			
			} if( is_array( $tag ) )
				$tag = $tag[ 0 ];
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$tmp->GID()." ["
							  .$parent_node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		
			//
			// Handle enumerations.
			// Notice we know the enumerations already exist.
			//
			switch( $term[ kTERM_GID ] )
			{
				//
				// Node kind.
				//
				case kTERM_KIND:
					// List kinds.
					$list = array( kKIND_ROOT, kKIND_NODE_DDICT,
								   kKIND_FEATURE, kKIND_METHOD,
								   kKIND_SCALE, kKIND_INSTANCE );
					// Create nodes and relate.
					foreach( $list as $item )
						$this->EnumOf(
							$this->NewEnumerationNode(
								$this->ResolveTerm(
									substr( $item, 1 ),	// Local identifier.
									$ns,				// Namespace object.
									TRUE ) )[ 0 ],		// Raise exception on fail.
							$parent_node );
					break;
				
				//
				// Node type.
				//
				case kTERM_TYPE:
					// List types.
					$list = array( kTYPE_STRING, kTYPE_INT32, kTYPE_INT64, kTYPE_FLOAT,
									kTYPE_BOOLEAN, kTYPE_ANY, kTYPE_BINARY_STRING, kTYPE_DATE_STRING,
									kTYPE_TIME_STRING, kTYPE_REGEX_STRING, kTYPE_LSTRING, kTYPE_STAMP,
									kTYPE_STRUCT, kTYPE_ENUM, kTYPE_ENUM_SET, kTYPE_PHP,
									kTYPE_JSON, kTYPE_XML, kTYPE_SVG,
									kTYPE_REQUIRED, kTYPE_ARRAY );
					// Create nodes and relate.
					foreach( $list as $item )
						$this->EnumOf(
							$this->NewEnumerationNode(
								$this->ResolveTerm(
									substr( $item, 1 ),	// Local identifier.
									$ns,				// Namespace object.
									TRUE ) )[ 0 ],		// Raise exception on fail.
							$parent_node );
					break;
			
			} // Parsing current term.
		
		} // Iterating first level terms.

	} // _LoadNodeDataDictionary.

	 
	/*===================================================================================
	 *	_LoadEdgeDataDictionary															*
	 *==================================================================================*/

	/**
	 * <h4>Load edge data dictionary</h4>
	 *
	 * This method will load the ontology edge, {@link COntologyEdge}, data dictionary.
	 *
	 * @access protected
	 */
	protected function _LoadEdgeDataDictionary()
	{
		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Loading Edge data dictionary.\n" );

		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load predicate term.
		//
		$predicate
			= $this->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$ns,
				TRUE );
		
		//
		// Load data dictionary root term.
		//
		$root_node
			= $this->ResolveNode(
				$this->ResolveTerm(
					kDDICT_EDGE, NULL, TRUE ),
				TRUE )[ 0 ];

		//
		// Load  definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kTERM_SUBJECT, 1 ),
				   kTERM_GID => kTERM_SUBJECT,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_INT64, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_PREDICATE, 1 ),
				   kTERM_GID => kTERM_PREDICATE,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_BINARY_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_OBJECT, 1 ),
				   kTERM_GID => kTERM_OBJECT,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_INT64, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_GID, 1 ),
				   kTERM_GID => kTERM_GID,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_UID, 1 ),
				   kTERM_GID => kTERM_UID,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_BINARY_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_CLASS, 1 ),
				   kTERM_GID => kTERM_CLASS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			//
			// Create node and relate.
			//
			$this->SubclassOf(
				$parent_node
					= $this->NewScaleNode(
						$tmp
							= $this->ResolveTerm(
								$term[ kTERM_LID ],			// Local identifier.
								$term[ kTERM_NAMESPACE ],		// Namespace object.
								TRUE ),							// Raise exception on fail.
						$term[ kTERM_TYPE ],					// Data type.
						NULL,									// Namespace.
						NULL,									// Label.
						NULL,									// Description.
						NULL,									// Language.
						TRUE ),									// New node flag.
				$root_node );
			
			//
			// Create tag.
			//
			$tag = $this->ResolveTag( $tmp );
			if( $tag === NULL )
			{
				$this->AddToTag( $tag, $parent_node );
				$this->AddToTag( $tag, TRUE );
			
			} if( is_array( $tag ) )
				$tag = $tag[ 0 ];
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$tmp->GID()." ["
							  .$parent_node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		
		} // Iterating first level terms.

	} // _LoadEdgeDataDictionary.

	 
	/*===================================================================================
	 *	_LoadTagDataDictionary															*
	 *==================================================================================*/

	/**
	 * <h4>Load tag data dictionary</h4>
	 *
	 * This method will load the ontology tag, {@link COntologyTag}, data dictionary.
	 *
	 * @access protected
	 */
	protected function _LoadTagDataDictionary()
	{
		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Loading Tag data dictionary.\n" );

		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load predicate term.
		//
		$predicate
			= $this->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$ns,
				TRUE );
		
		//
		// Load data dictionary root term.
		//
		$root_node
			= $this->ResolveNode(
				$this->ResolveTerm(
					kDDICT_TAG, NULL, TRUE ),
				TRUE )[ 0 ];

		//
		// Load  definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kTERM_GID, 1 ),
				   kTERM_GID => kTERM_GID,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_UID, 1 ),
				   kTERM_GID => kTERM_UID,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_BINARY_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_CLASS, 1 ),
				   kTERM_GID => kTERM_CLASS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_REQUIRED ) ),
			array( kTERM_LID => substr( kTERM_PATH, 1 ),
				   kTERM_GID => kTERM_PATH,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_ANY, kTYPE_ARRAY ) ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			//
			// Create node and relate.
			//
			$this->SubclassOf(
				$parent_node
					= $this->NewScaleNode(
						$tmp
							= $this->ResolveTerm(
								$term[ kTERM_LID ],			// Local identifier.
								$term[ kTERM_NAMESPACE ],		// Namespace object.
								TRUE ),							// Raise exception on fail.
						$term[ kTERM_TYPE ],					// Data type.
						NULL,									// Namespace.
						NULL,									// Label.
						NULL,									// Description.
						NULL,									// Language.
						TRUE ),									// New node flag.
				$root_node );
			
			//
			// Create tag.
			//
			$tag = $this->ResolveTag( $tmp );
			if( $tag === NULL )
			{
				$this->AddToTag( $tag, $parent_node );
				$this->AddToTag( $tag, TRUE );
			
			} if( is_array( $tag ) )
				$tag = $tag[ 0 ];
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$tmp->GID()." ["
							  .$parent_node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		
		} // Iterating first level terms.

	} // _LoadTagDataDictionary.

	 
	/*===================================================================================
	 *	_LoadAttributesDataDictionary													*
	 *==================================================================================*/

	/**
	 * <h4>Load attributes data dictionary</h4>
	 *
	 * This method will load the ontology default attributes data dictionary.
	 *
	 * @access protected
	 */
	protected function _LoadAttributesDataDictionary()
	{
		//
		// Inform.
		//
		if( kOPTION_VERBOSE )
			echo( "  • Loading generic attributes data dictionary.\n" );

		//
		// Load namespace term.
		//
		$ns = $this->ResolveTerm( '', NULL, TRUE );
		
		//
		// Load predicate term.
		//
		$predicate
			= $this->ResolveTerm(
				substr( kPREDICATE_SUBCLASS_OF, 1 ),
				$ns,
				TRUE );
		
		//
		// Load data dictionary root term.
		//
		$root_node
			= $this->ResolveNode(
				$this->ResolveTerm(
					kDDICT_ATTRIBUTES, NULL, TRUE ),
				TRUE )[ 0 ];

		//
		// Load  definitions.
		//
		$terms = array(
			array( kTERM_LID => substr( kTERM_AUTHORS, 1 ),
				   kTERM_GID => kTERM_AUTHORS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_ARRAY ) ),
			array( kTERM_LID => substr( kTERM_NOTES, 1 ),
				   kTERM_GID => kTERM_NOTES,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_ARRAY ) ),
			array( kTERM_LID => substr( kTERM_ACKNOWLEDGMENTS, 1 ),
				   kTERM_GID => kTERM_ACKNOWLEDGMENTS,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => kTYPE_STRING ),
			array( kTERM_LID => substr( kTERM_BIBLIOGRAPHY, 1 ),
				   kTERM_GID => kTERM_BIBLIOGRAPHY,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_ARRAY ) ),
			array( kTERM_LID => substr( kTERM_EXAMPLES, 1 ),
				   kTERM_GID => kTERM_EXAMPLES,
				   kTERM_NAMESPACE => $ns,
				   kTERM_TYPE => array( kTYPE_STRING, kTYPE_ARRAY ) ) );
		
		//
		// Iterate definitions.
		//
		foreach( $terms as $term )
		{
			//
			// Create node and relate.
			//
			$this->SubclassOf(
				$parent_node
					= $this->NewScaleNode(
						$tmp
							= $this->ResolveTerm(
								$term[ kTERM_LID ],			// Local identifier.
								$term[ kTERM_NAMESPACE ],		// Namespace object.
								TRUE ),							// Raise exception on fail.
						$term[ kTERM_TYPE ],					// Data type.
						NULL,									// Namespace.
						NULL,									// Label.
						NULL,									// Description.
						NULL,									// Language.
						TRUE ),									// New node flag.
				$root_node );
			
			//
			// Create tag.
			//
			$tag = $this->ResolveTag( $tmp );
			if( $tag === NULL )
			{
				$this->AddToTag( $tag, $parent_node );
				$this->AddToTag( $tag, TRUE );
			
			} if( is_array( $tag ) )
				$tag = $tag[ 0 ];
			
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "    - ".$tmp->GID()." ["
							  .$parent_node[ kTAG_NID ]."] ("
							  .$tag[ kTAG_NID ].")\n" );
		
		} // Iterating first level terms.

	} // _LoadAttributesDataDictionary.

	 

} // class COntology.


?>
