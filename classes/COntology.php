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
 *		<li><tt>{@link kTAG_LABEL}</tt>: <i>Label</i>. This attribute represents the label,
 *			name or short description of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the label can be expressed in several
 *			languages. 
 *		<li><tt>{@link kTAG_DESCRIPTION}</tt>: <i>Description</i>. This attribute
 *			represents the description or definition of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the description can be expressed in
 *			several languages. 
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
 * Node kinds.
 *
 * This include file contains the node kind definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/NodeKinds.inc.php" );

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
			// Initialise containers.
			//
			$this->_InitContainers();
			
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
	//	$container->AddIndex( array( kTAG_TERM => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_LABEL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_DESCRIPTION => 1 ), array( 'sparse' => TRUE ) );
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
			array( kTERM_LID => substr( kKIND_NODE_ROOT, 1 ),
				   kTERM_LABEL => "Root node",
				   kTERM_DESCRIPTION => "This tag identifies a root or ontology node kind." ),
			array( kTERM_LID => substr( kKIND_NODE_DDICT, 1 ),
				   kTERM_LABEL => "Data dictionary node",
				   kTERM_DESCRIPTION => "This tag identifies a structure definition or data dictionary node kind, in general this will be used in conjunction to the root node kind to indicate a data structure description." ),
			array( kTERM_LID => substr( kKIND_NODE_FEATURE, 1 ),
				   kTERM_LABEL => "Trait node",
				   kTERM_DESCRIPTION => "This tag identifies a trait or measurable node kind." ),
			array( kTERM_LID => substr( kKIND_NODE_METHOD, 1 ),
				   kTERM_LABEL => "Method node",
				   kTERM_DESCRIPTION => "This tag identifies a method node kind." ),
			array( kTERM_LID => substr( kKIND_NODE_SCALE, 1 ),
				   kTERM_LABEL => "Scale node",
				   kTERM_DESCRIPTION => "This tag identifies a scale or measure node kind." ),
			array( kTERM_LID => substr( kKIND_NODE_INSTANCE, 1 ),
				   kTERM_LABEL => "Instance node",
				   kTERM_DESCRIPTION => "This tag identifies an instance node kind, it represents a definition which is also its instance." ),
			array( kTERM_LID => substr( kKIND_NODE_ENUMERATION, 1 ),
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
			array( kTERM_LID => substr( kTERM_MESSAGE, 1 ),
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
			array( kTERM_LID => substr( kTERM_SEVERITY, 1 ),
				   kTERM_NAMESPACE => $ns,
				   kTERM_LABEL => "Severity",
				   kTERM_DESCRIPTION => "Code that characterises the importance or severity of a status." ),
			array( kTERM_LID => substr( kTERM_CODE, 1 ),
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
				array( kKIND_NODE_ROOT, kKIND_NODE_DDICT ) );	// Node kind.

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
				array( kKIND_NODE_ROOT, kKIND_NODE_SCALE ),		// Node kind.
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
				array( kKIND_NODE_ROOT, kKIND_NODE_SCALE ),		// Node kind.
				kTYPE_ENUM );									// Node type.
		
		//
		// Load instance definitions.
		//
		$terms = array( kKIND_NODE_ROOT, kKIND_NODE_DDICT, kKIND_NODE_FEATURE,
						kKIND_NODE_METHOD, kKIND_NODE_SCALE, kKIND_NODE_ENUMERATION,
						kKIND_NODE_INSTANCE );
		
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
				array( kKIND_NODE_ROOT, kKIND_NODE_SCALE ),		// Node kind.
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
					$list = array( kKIND_NODE_ROOT, kKIND_NODE_DDICT,
								   kKIND_NODE_FEATURE, kKIND_NODE_METHOD,
								   kKIND_NODE_SCALE, kKIND_NODE_INSTANCE );
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
