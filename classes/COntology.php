<?php

/**
 * <i>COntology</i> class definition.
 *
 * This file contains the class definition of <b>COntology</b> which represents a high
 * level ontology wrapper.
 *
 * This class derives from {@link CConnection} and expects a {@link CDatabase} instance
 * in its constructor. This class features methods that will create the default ontology,
 * which is the set of elements with which the actual ontology is built.
 *
 *
 * The ontology is made of four main collections:
 *
 * <ul>
 *	<li><b>Terms</b>: These elements are represented in this library by the instances of the
 *		{@link COntologyTerm} class, they represent concepts whose meaning is independent
 *		from their context. These objects may carry any number or type of attributes, the
 *		default ones which are managed by this library are the following:
 *	 <ul>
 *		<li><tt>{@link kTAG_LID}</tt>: <i>Local identifier</i>. This attribute contains the
 *			local unique identifier. This value represents the value that uniquely
 *			identifies an object within a specific domain or namespace. It is by definition
 *			a string constituting the suffix of the global identifier, {@link kTAG_GID}. 
 *		<li><tt>{@link kTAG_GID}</tt>: <i>Global identifier</i>. This attribute contains
 *			the global unique identifier. This value represents the value that uniquely
 *			identifies the object across domains and namespaces. This value is by definition
 *			a string and will generally constitute the object's primary key
 *			({@link kTAG_NID}) in full or hashed form. 
 *		<li><tt>{@link kTAG_NAMESPACE}</tt>: <i>Namespace</i>. This attribute is a
 *			reference to a term which represents the namespace of the current object. The
 *			object local identifiers must be unique within the scope of the namespace.
 *		<li><tt>{@link kTAG_SYNONYMS}</tt>: <i>Synonyms</i>. This attribute contains a list
 *			of strings that represent alternate identifiers for the hosting object.
 *			Synonyms do not have any relation to the namespace.
 *		<li><tt>{@link kTAG_TERM}</tt>: <i>Term</i>. This attribute contains a reference to
 *			an object that represents the term of the attribute host.
 *		<li><tt>{@link kTAG_KIND}</tt>: <i>Kind</i>. This attribute is an enumerated set
 *			that defines the kind of the hosting object. 
 *		<li><tt>{@link kTAG_LABEL}</tt>: <i>Label</i>. This attribute represents the label,
 *			name or short description of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the label can be expressed in several
 *			languages. 
 *		<li><tt>{@link kTAG_DEFINITION}</tt>: <i>Definition</i>. This attribute represents
 *			the definition of the referenced object. It is an {@link kTYPE_LSTRING}
 *			structure in which the definition can be expressed in several languages. This
 *			attribute is similar to a description, except that the latter depends on the
 *			context, which is why it belongs to nodes, while the definition does not
 *			depend on the context, which is why it belongs to terms.
 *		<li><tt>{@link kTAG_NODES}</tt>: <i>Nodes</i>. This attribute is a collection of
 *			node references, it is an array of node object native identifiers who reference
 *			the current object.
 *		<li><tt>{@link kTAG_FEATURES}</tt>: <i>Features</i>. This attribute is a collection
 *			of feature references, it is an array of object native identifiers that
 *			reference the current object as a feature or trait.
 *		<li><tt>{@link kTAG_METHODS}</tt>: <i>Methods</i>. This attribute is a collection
 *			of method references, it is an array of object native identifiers that
 *			reference the current object as a method or modifier.
 *		<li><tt>{@link kTAG_SCALES}</tt>: <i>Scales</i>. This attribute is a collection
 *			of scale references, it is an array of object native identifiers that
 *			reference the current object as a scale or unit.
 *		<li><tt>{@link kTAG_NAMESPACE_REFS}</tt>: <i>Namespace references count</i>. This
 *			integer attribute counts how many times external objects have referenced the
 *			current one as a namespace.
 *	 </ul>
 *	<li><b>Nodes</b>: These elements are represented in this library by the instances of the
 *		{@link COntologyNode} class, they represent concepts whose meaning is dependant
 *		from their context and require a reference to a term object. In a sense, nodes
 *		represent terms in context. These objects may carry any number or type of
 *		attributes, the default ones which are managed by this library are the following:
 *	 <ul>
 *		<li><tt>{@link kTAG_TERM}</tt>: <i>Term</i>. This attribute contains a reference to
 *			an object that represents the term of the attribute host.
 *		<li><tt>{@link kTAG_NODE}</tt>: <i>Node</i>. This attribute contains a reference to
 *			an object that represents the node of the attribute host.
 *		<li><tt>{@link kTAG_CATEGORY}</tt>: <i>Category</i>. This attribute is an
 *			enumerated set that contains all the categories to which the hosting object
 *			belongs to. 
 *		<li><tt>{@link kTAG_KIND}</tt>: <i>Kind</i>. This attribute is an enumerated set
 *			that defines the kind of the hosting object. 
 *		<li><tt>{@link kTAG_TYPE}</tt>: <i>Type</i>. This attribute is an enumerated set
 *			that contains a combination of data type and cardinality indicators which,
 *			combined, represet the data type of the hosting object.
 *		<li><tt>{@link kTAG_DESCRIPTION}</tt>: <i>Description</i>. This attribute represents
 *			the description of the referenced object. It is an {@link kTYPE_LSTRING}
 *			structure in which the description can be expressed in several languages. This
 *			attribute is similar to a definition, except that the latter does not depend on
 *			the context, which is why it belongs to nodes, while the description depends on
 *			the context, which is why it belongs to nodes.
 *		<li><tt>{@link kTAG_NODES}</tt>: <i>Nodes</i>. This attribute is a collection of
 *			node references, it is an array of node object native identifiers who reference
 *			the current object.
 *		<li><tt>{@link kTAG_EDGES}</tt>: <i>Edges</i>. This attribute is a collection of
 *			edge references, it is an array of edge object native identifiers who reference
 *			the current object.
 *	 </ul>
 *	<li><b>Edges</b>: These elements are represented in this library by the instances of the
 *		{@link COntologyEdge} class, they represent relationships between node objects
 *		connected by a predicate term. They represent a subject/predicate/object triplet
 *		which connects all elements of the graph. These objects may carry any number or type
 *		of attributes, the default ones which are managed by this library are the following:
 *	 <ul>
 *		<li><tt>{@link kTAG_GID}</tt>: <i>Global identifier</i>. This attribute contains
 *			the global unique identifier. This value represents the value that uniquely
 *			identifies the object across domains and namespaces. This value is by definition
 *			a string and will generally constitute the object's primary key
 *			({@link kTAG_NID}) in full or hashed form. 
 *		<li><tt>{@link kTAG_UID}</tt>: <i>Unique identifier</i>. This attribute contains
 *			the hashed unique identifier of an object in which its {@link kTAG_NID} is not
 *			related to the {@link kTAG_GID}. This is generally used when the
 *			{@link kTAG_NID} is a sequence number.
 *		<li><tt>{@link kTAG_SUBJECT}</tt>: <i>Subject</i>. This attribute contains a
 *			reference to an object that represents the start, origin or subject vertex of a
 *			<tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTAG_OBJECT}</tt>: <i>Object</i>. This attribute contains a
 *			reference to an object that represents the end, destination or object vertex of
 *			a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTAG_PREDICATE}</tt>: <i>Predicate</i>. This attribute contains a
 *			reference to an object that represents the predicate term of a
 *			<tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *	 </ul>
 *	<li><b>Tags</b>: These elements are represented in this library by the instances of the
 *		{@link COntologyTag} class, they represent paths between a starting node called
 *		<i>feature</i>, which represents the feature or trait to be tagged, and an ending
 *		node called <i>scale</i> which represents the scale or unit in which the feature is
 *		measured or described. Tags are the objects used to tie the ontology to data, these
 *		objects are literally used to tag datasets. These objects may carry any number or
 *		type of attributes, the default ones which are managed by this library are the
 *		following:
 *	 <ul>
 *		<li><tt>{@link kTAG_GID}</tt>: <i>Global identifier</i>. This attribute contains
 *			the global unique identifier. This value represents the value that uniquely
 *			identifies the object across domains and namespaces. This value is by definition
 *			a string and will generally constitute the object's primary key
 *			({@link kTAG_NID}) in full or hashed form. 
 *		<li><tt>{@link kTAG_UID}</tt>: <i>Unique identifier</i>. This attribute contains
 *			the hashed unique identifier of an object in which its {@link kTAG_NID} is not
 *			related to the {@link kTAG_GID}. This is generally used when the
 *			{@link kTAG_NID} is a sequence number.
 *		<li><tt>{@link kTAG_PATH}</tt>: <i>Path</i>. This attribute represents a sequence
 *			of <tt>vertex</tt>, <tt>predicate</tt>, <tt>vertex</tt> elements whose
 *			concatenation represents a path between an origin vertex and a destination
 *			vertex.
 *	 </ul>
 * </ul>
 *
 * All four collections share the following two attributes:
 *
 * <ul>
 *	<li><tt>{@link kTAG_NID}</tt>: <i>Native identifier</i>. This attribute contains the
 *		native unique identifier of the object. This identifier is used as the default
 *		unique key for all objects and can have any scalar data type. 
 *	<li><tt>{@link kTAG_CLASS}</tt>: <i>Class</i>. This attribute is a string that
 *		represets the referenced object's class. This attribute is used to instantiate the
 *		correct class once an object has been retrieved from its container.
 * </ul>
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
 * Global tags.
 *
 * This include file contains common tag definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tags.inc.php" );

/**
 * Global types.
 *
 * This include file contains common type definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Types.inc.php" );

/**
 * Global attributes.
 *
 * This include file contains common attribute definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Attributes.inc.php" );

/**
 * Kinds.
 *
 * This include file contains the kind definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Kinds.inc.php" );

/**
 * Predicates.
 *
 * This include file contains the default predicate definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Predicates.inc.php" );

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
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * <h4>Ontology object</h4>
 *
 * This class represents an object whose duty is to provide a high level interface for
 * managing ontologies.
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
			// Init local storage.
			//
			$_SESSION[ kOFFSET_NODES ] = Array();
			
			//
			// Initialise containers.
			//
			$this->_InitContainers();
			
			//
			// Initialise terms.
			//
			$this->_InitNamespaceTerms();
			$this->_InitCategoryTerms();
			$this->_InitAttributeTerms();
			$this->_InitEnumerationTerms();
			$this->_InitPredicateTerms();
			
			//
			// Initialise nodes.
			//
			$this->_InitCategoryNodes();
			$this->_InitCategoryEdges();
			$this->_InitEnumerationNodes();
			$this->_InitEnumerationEdges();
			
			return;																	// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // InitOntology.

		

/*=======================================================================================
 *																						*
 *						PROTECTED ONTOLOGY INITIALISATION INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_InitContainers																	*
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
	protected function _InitContainers()
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
	//	$container->AddIndex( array( kTAG_GID => 1 ) );
	//	$container->AddIndex( array( kTAG_NAMESPACE => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_SYNONYMS => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EXAMPLES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_TERM => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_KIND => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_LABEL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_DEFINITION => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_NODES => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_FEATURES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_METHODS => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_SCALES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_NAMESPACE_REFS => 1 ), array( 'sparse' => TRUE ) );
		
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
	//	$container->AddIndex( array( kTAG_NODE => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_CATEGORY => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_KIND => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_TYPE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_DESCRIPTION => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EDGES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_NODES => 1 ), array( 'sparse' => TRUE ) );
		
		//
		// Add vertex attributes.
		//
	//	$container->AddIndex( array( kTAG_LID => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_GID => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_LABEL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_DESCRIPTION => 1 ), array( 'sparse' => TRUE ) );
		
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
	//	$container->AddIndex( array( kTAG_GID => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_SUBJECT => 1 ) );
		$container->AddIndex( array( kTAG_PREDICATE => 1 ) );
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
	//	$container->AddIndex( array( kTAG_GID => 1 ), array( 'unique' => TRUE ) );
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

	} // _InitContainers.

	 
	/*===================================================================================
	 *	_InitNamespaceTerms																*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default namespaces</h4>
	 *
	 * This method will load all default namespaces, it will read the term definitions from the
	 * <tt>namespaces.xml</tt> file placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitNamespaceTerms()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/NamespaceTerms.xml' );
		
		//
		// Iterate terms.
		//
		foreach( $xml->term as $element )
		{
			//
			// Instantiate term.
			//
			$term = new COntologyTerm();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_LID' ] !== NULL )
			{
				//
				// Set namespace kind.
				//
				$term->Kind( kKIND_TERM_NAMESPACE, TRUE );
				
				//
				// Parse and save term.
				//
				$this->_ParseTerm( $db, $element, $term );
			
			} // Has local identifier.
			
			else
				throw new Exception
					( "Term is missing local identifier",
					  kERROR_STATE );											// !@! ==>
		
		} // Iterating terms.

	} // _InitNamespaceTerms.

	 
	/*===================================================================================
	 *	_InitCategoryTerms																*
	 *==================================================================================*/

	/**
	 * <h4>Initialise category terms</h4>
	 *
	 * This method will load all default category terms, it will read the term definitions
	 * from the <tt>CategoryTerms.xml</tt> file placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitCategoryTerms()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/CategoryTerms.xml' );
		
		//
		// Iterate terms.
		//
		foreach( $xml->term as $element )
		{
			//
			// Instantiate term.
			//
			$term = new COntologyTerm();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_LID' ] !== NULL )
				$this->_ParseTerm( $db, $element, $term );
			
			else
				throw new Exception
					( "Term is missing local identifier",
					  kERROR_STATE );											// !@! ==>
		
		} // Iterating terms.

	} // _InitCategoryTerms.

	 
	/*===================================================================================
	 *	_InitAttributeTerms																*
	 *==================================================================================*/

	/**
	 * <h4>Initialise attribute terms</h4>
	 *
	 * This method will load all default attribute terms, it will read the term definitions from the
	 * <tt>AttributeTerms.xml</tt> file placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitAttributeTerms()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/AttributeTerms.xml' );
		
		//
		// Iterate terms.
		//
		foreach( $xml->term as $element )
		{
			//
			// Instantiate term.
			//
			$term = new COntologyTerm();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_LID' ] !== NULL )
				$this->_ParseTerm( $db, $element, $term );
			
			else
				throw new Exception
					( "Term is missing local identifier",
					  kERROR_STATE );											// !@! ==>
		
		} // Iterating terms.

	} // _InitAttributeTerms.

	 
	/*===================================================================================
	 *	_InitEnumerationTerms															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise enumeration terms</h4>
	 *
	 * This method will load all default enumeration terms, it will read the term
	 * definitions from the <tt>attributes.xml</tt> file placed in the library definitions
	 * directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitEnumerationTerms()
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
		// Load XML file.
		//
		$xml = simplexml_load_file
					( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/EnumerationTerms.xml' );
		
		//
		// Iterate terms.
		//
		foreach( $xml->term as $element )
		{
			//
			// Instantiate term.
			//
			$term = new COntologyTerm();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_LID' ] !== NULL )
			{
				//
				// Set namespace kind.
				//
				$term->Kind( kKIND_ENUMERATION, TRUE );
				
				//
				// Parse and save term.
				//
				$this->_ParseTerm( $db, $element, $term );
			
			} // Has local identifier.
			
			else
				throw new Exception
					( "Term is missing local identifier",
					  kERROR_STATE );											// !@! ==>
		
		} // Iterating terms.

	} // _InitEnumerationTerms.

	 
	/*===================================================================================
	 *	_InitPredicateTerms																	*
	 *==================================================================================*/

	/**
	 * <h4>Initialise predicates</h4>
	 *
	 * This method will load all default predicates, it will read the predicate definitions
	 * from the <tt>PredicateTerms.xml</tt> file placed in the library definitions
	 * directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitPredicateTerms()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/PredicateTerms.xml' );
		
		//
		// Iterate terms.
		//
		foreach( $xml->term as $element )
		{
			//
			// Instantiate term.
			//
			$term = new COntologyTerm();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_LID' ] !== NULL )
			{
				//
				// Set namespace kind.
				//
				$term->Kind( kKIND_TERM_PREDICATE, TRUE );
				
				//
				// Parse and save term.
				//
				$this->_ParseTerm( $db, $element, $term );
			
			} // Has local identifier.
			
			else
				throw new Exception
					( "Term is missing local identifier",
					  kERROR_STATE );											// !@! ==>
		
		} // Iterating terms.

	} // _InitPredicateTerms.

	 
	/*===================================================================================
	 *	_InitCategoryNodes																*
	 *==================================================================================*/

	/**
	 * <h4>Initialise category nodes</h4>
	 *
	 * This method will load all default category nodes, it will read the node definitions
	 * from the <tt>CategoryNodes.xml</tt> file placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitCategoryNodes()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/CategoryNodes.xml' );
		
		//
		// Iterate nodes.
		//
		foreach( $xml->node as $element )
		{
			//
			// Instantiate node.
			//
			$node = new COntologyMasterVertex();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_GID' ] !== NULL )
				$this->_ParseNode( $db, $element, $node );
			
			else
				throw new Exception
					( "Node is missing term global identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Cache node.
			//
			$_SESSION[ kOFFSET_NODES ][ (string) $element[ 'kTAG_GID' ] ] = $node->NID();
		
		} // Iterating nodes.

	} // _InitCategoryNodes.

	 
	/*===================================================================================
	 *	_InitCategoryEdges																*
	 *==================================================================================*/

	/**
	 * <h4>Initialise category edges</h4>
	 *
	 * This method will load all default category edges, it will read the edge definitions
	 * from the <tt>CategoryEdges.xml</tt> file placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitCategoryEdges()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE.'/CategoryEdges.xml' );
		
		//
		// Iterate edges.
		//
		foreach( $xml->edge as $element )
		{
			//
			// Instantiate node.
			//
			$edge = new COntologyEdge();
			
			//
			// Parse edge.
			//
			$this->_ParseEdge( $db, $element, $edge );
		
		} // Iterating edges.

	} // _InitCategoryEdges.

	 
	/*===================================================================================
	 *	_InitEnumerationNodes															*
	 *==================================================================================*/

	/**
	 * <h4>Initialise enumeration nodes</h4>
	 *
	 * This method will load all default enumeration nodes, it will read the node
	 * definitions from the <tt>EnumerationNodes.xml</tt> file placed in the library
	 * definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitEnumerationNodes()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE
								   .'/EnumerationNodes.xml' );
		
		//
		// Iterate nodes.
		//
		foreach( $xml->node as $element )
		{
			//
			// Instantiate node.
			//
			$node = new COntologyMasterVertex();
			
			//
			// Load local identifier.
			//
			if( $element[ 'kTAG_GID' ] !== NULL )
				$this->_ParseNode( $db, $element, $node );
			
			else
				throw new Exception
					( "Node is missing term global identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Cache node.
			//
			$_SESSION[ kOFFSET_NODES ][ (string) $element[ 'kTAG_GID' ] ] = $node->NID();
		
		} // Iterating nodes.

	} // _InitEnumerationNodes.

	 
	/*===================================================================================
	 *	_InitEnumerationEdges																*
	 *==================================================================================*/

	/**
	 * <h4>Initialise enumeration edges</h4>
	 *
	 * This method will load all default enumeration edges, it will read the edge definitions
	 * from the <tt>EnumerationEdges.xml</tt> file placed in the library definitions
	 * directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitEnumerationEdges()
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
		// Load XML file.
		//
		$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE
								   .'/EnumerationEdges.xml' );
		
		//
		// Iterate edges.
		//
		foreach( $xml->edge as $element )
		{
			//
			// Instantiate node.
			//
			$edge = new COntologyEdge();
			
			//
			// Parse edge.
			//
			$this->_ParseEdge( $db, $element, $edge );
		
		} // Iterating edges.

	} // _InitEnumerationEdges.

	 
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

		

/*=======================================================================================
 *																						*
 *							PROTECTED ONTOLOGY PARSING INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ParseTerm																		*
	 *==================================================================================*/

	/**
	 * <h4>Parse the provided term</h4>
	 *
	 * This method will parse the provided XML term and fill the provided ontology term.
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 * @param SimpleXMLElement		$theElement			XML element with term data.
	 * @param COntologyTerm			$theTerm			Receives term data.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ParseTerm( CDatabase		$theDatabase,
								   SimpleXMLElement	$theElement,
								   COntologyTerm	$theTerm )
	{
		//
		// Load local identifier.
		//
		if( $theElement[ 'kTAG_LID' ] !== NULL )
		{
			//
			// Set local identifier.
			//
			$theTerm->LID( (string) $theElement[ 'kTAG_LID' ] );
			
			//
			// Handle namespace.
			//
			if( $theElement[ 'kTAG_NAMESPACE' ] )
			{
				//
				// Resolve namespace.
				//
				$ref = COntologyTerm::Resolve(
						$theDatabase,
						(string) $theElement[ 'kTAG_NAMESPACE' ],
						NULL,
						TRUE );
				
				//
				// Set namespace.
				//
				$theTerm->NS( $ref );
			
			} // Has namespace.
			
			//
			// Get synonyms.
			//
			if( $theElement->{'kTAG_SYNONYMS'}->count() )
			{
				foreach( $theElement->{'kTAG_SYNONYMS'}->{'item'} as $item )
					$theTerm->Synonym( (string) $item, TRUE );
			
			} // Has synonyms.
			
			//
			// Handle term reference.
			//
			if( $theElement->{'kTAG_TERM'} )
			{
				//
				// Resolve term.
				//
				$ref = COntologyTerm::Resolve(
						$theDatabase,
						(string) $theElement[ 'kTAG_TERM' ],
						NULL,
						TRUE );
				
				//
				// Set namespace.
				//
				$theTerm->Term( $ref );
			
			} // Has term reference.
			
			//
			// Get kinds.
			//
			if( $theElement->{'kTAG_KIND'}->count() )
			{
				foreach( $theElement->{'kTAG_KIND'}->{'item'} as $item )
					$theTerm->Kind( (string) $item, TRUE );
			
			} // Has kind.
			
			//
			// Get label.
			//
			if( $theElement->{'kTAG_LABEL'} !== NULL )
				$theTerm->Label( (string) $theElement->{'kTAG_LABEL'}[ 'language' ],
								 (string) $theElement->{'kTAG_LABEL'} );
			
			//
			// Get definition.
			//
			if( $theElement->{'kTAG_DEFINITION'} !== NULL )
				$theTerm->Definition( (string) $theElement->{'kTAG_DEFINITION'}[ 'language' ],
									  (string) $theElement->{'kTAG_DEFINITION'} );
			
			//
			// Get examples.
			//
			if( $theElement->{'kTAG_EXAMPLES'}->count() )
			{
				foreach( $theElement->{'kTAG_EXAMPLES'}->{'item'} as $item )
					$theTerm->Example( (string) $item, TRUE );
			
			} // Has examples.
			
			//
			// Save term.
			//
			$theTerm->Insert( $theDatabase );
		
		} // Has local identifier.
		
		else
			throw new Exception
				( "Term is missing local identifier",
				  kERROR_STATE );											// !@! ==>

	} // _ParseTerm.

	 
	/*===================================================================================
	 *	_ParseNode																		*
	 *==================================================================================*/

	/**
	 * <h4>Parse the provided node</h4>
	 *
	 * This method will parse the provided XML node and fill the provided ontology node.
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 * @param SimpleXMLElement		$theElement			XML element with term data.
	 * @param COntologyNode			$theNode			Receives node data.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ParseNode( CDatabase		$theDatabase,
								   SimpleXMLElement	$theElement,
								   COntologyNode	$theNode )
	{
		//
		// Load term global identifier.
		//
		if( $theElement[ 'kTAG_GID' ] !== NULL )
		{
			//
			// Resolve term.
			//
			$term = COntologyTerm::Resolve(
						$theDatabase, (string) $theElement[ 'kTAG_GID' ], NULL, TRUE );
			
			//
			// Set term reference.
			//
			$theNode->Term( $term );
			
			//
			// Get categories.
			//
			if( $theElement->{'kTAG_CATEGORY'}->count() )
			{
				foreach( $theElement->{'kTAG_CATEGORY'}->{'item'} as $item )
					$theNode->Category( (string) $item, TRUE );
			
			} // Has categories.
			
			//
			// Get kinds.
			//
			if( $theElement->{'kTAG_KIND'}->count() )
			{
				foreach( $theElement->{'kTAG_KIND'}->{'item'} as $item )
					$theNode->Kind( (string) $item, TRUE );
			
			} // Has kinds.
			
			//
			// Get types.
			//
			if( $theElement->{'kTAG_TYPE'}->count() )
			{
				foreach( $theElement->{'kTAG_TYPE'}->{'item'} as $item )
					$theNode->Type( (string) $item, TRUE );
			
			} // Has types.
			
			//
			// Get description.
			//
			if( $theElement->{'kTAG_DESCRIPTION'}->count() )
				$theNode->Description
					( (string) $theElement->{'kTAG_DESCRIPTION'}[ 'language' ],
					  (string) $theElement->{'kTAG_DESCRIPTION'} );
			
			//
			// Save node.
			//
			$theNode->Insert( $theDatabase );
		
		} // Has global identifier.
		
		else
			throw new Exception
				( "Node is missing term global identifier",
				  kERROR_STATE );											// !@! ==>

	} // _ParseNode.

	 
	/*===================================================================================
	 *	_ParseEdge																		*
	 *==================================================================================*/

	/**
	 * <h4>Parse the provided edge</h4>
	 *
	 * This method will parse the provided XML edge and fill the provided ontology edge.
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 * @param SimpleXMLElement		$theElement			XML element with term data.
	 * @param COntologyEdge			$theEdge			Receives edge data.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ParseEdge( CDatabase		$theDatabase,
								   SimpleXMLElement	$theElement,
								   COntologyEdge	$theEdge )
	{
		//
		// Load subject.
		//
		if( $theElement->{ 'kTAG_SUBJECT' } !== NULL )
		{
			//
			// Resolve subject.
			//
			if( array_key_exists( (string) $theElement->{ 'kTAG_SUBJECT' },
								  $_SESSION[ kOFFSET_NODES ] ) )
				$theEdge->Subject( $_SESSION[ kOFFSET_NODES ]
											[ (string) $theElement->{ 'kTAG_SUBJECT' } ] );
			else
				throw new Exception
					( "Subject node not found",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Load predicate.
			//
			if( $theElement->{ 'kTAG_PREDICATE' } !== NULL )
			{
				//
				// Resolve predicate.
				//
				$term = COntologyTerm::Resolve( $theDatabase,
												(string) $theElement->{ 'kTAG_PREDICATE' },
												NULL,
												TRUE );
				
				//
				// Set subject.
				//
				$theEdge->Predicate( $term );
				
				//
				// Load object.
				//
				if( $theElement->{ 'kTAG_OBJECT' } !== NULL )
				{
					//
					// Resolve object.
					//
					if( array_key_exists(
						(string) $theElement->{ 'kTAG_OBJECT' },
						$_SESSION[ kOFFSET_NODES ] ) )
						$theEdge->Object(
							$_SESSION[ kOFFSET_NODES ]
									 [ (string) $theElement->{ 'kTAG_OBJECT' } ] );
					else
						throw new Exception
							( "Object node not found",
							  kERROR_STATE );											// !@! ==>
					
					//
					// Save edge.
					//
					$theEdge->Insert( $theDatabase );
				
				} // Provided object.
				
				else
					throw new Exception
						( "Edge is missing object",
						  kERROR_STATE );										// !@! ==>
			
			} // Provided predicate.
			
			else
				throw new Exception
					( "Edge is missing predicate",
					  kERROR_STATE );											// !@! ==>
		
		} // Provided subject.
		
		else
			throw new Exception
				( "Edge is missing subject",
				  kERROR_STATE );												// !@! ==>

	} // _ParseEdge.

	 

} // class COntology.


?>
