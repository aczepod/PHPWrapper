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
			$this->_InitTerms();
			
			//
			// Initialise nodes.
			//
			$this->_InitNodes();
			
			//
			// Initialise edges.
			//
			$this->_InitEdges();
			
			//
			// Initialise vertices.
			//
			$this->_InitVertices();
			
			//
			// Initialise tags.
			//
			$this->_InitTags();
			
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
	 *	_InitTerms																		*
	 *==================================================================================*/

	/**
	 * <h4>Initialise default terms</h4>
	 *
	 * This method will load all default terms, it will read the term definition files from
	 * the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitTerms()
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
		// Init local storage.
		//
		$files = array( 'NamespaceTerms', 'CategoryTerms', 'EnumerationTerms',
						'PredicateTerms', 'AttributeTerms', 'ObjectTerms' );
		
		//
		// Iterate files.
		//
		foreach( $files as $file )
		{
			//
			// Load XML file.
			//
			$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE."/$file.xml" );
			
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
		
		} // Iterating files.

	} // _InitTerms.

	 
	/*===================================================================================
	 *	_InitNodes																		*
	 *==================================================================================*/

	/**
	 * <h4>Initialise nodes</h4>
	 *
	 * This method will load all default nodes, it will read the node definitions from the
	 * files placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitNodes()
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
		// Init local storage.
		//
		$files = array( 'CategoryNodes', 'EnumerationNodes',
						'PredicateNodes', 'AttributeNodes', 'ObjectNodes' );
		
		//
		// Iterate files.
		//
		foreach( $files as $file )
		{
			//
			// Load XML file.
			//
			$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE."/$file.xml" );
			
			//
			// Iterate nodes.
			//
			foreach( $xml->node as $element )
			{
				//
				// Instantiate node.
				//
				if( $element->{ 'kTAG_CLASS' } !== NULL )
				{
					$class = (string) $element->{ 'kTAG_CLASS' };
					$node = new $class();
				}
				else
					$node = new COntologyMasterVertex();
				
				//
				// Load local identifier.
				//
				if( $element[ 'kTAG_GID' ] !== NULL )
					$this->_ParseNode( $db, $element, $node );
				
				else
					throw new Exception
						( "Node is missing term global identifier",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Cache node.
				//
				$_SESSION[ kOFFSET_NODES ]
						 [ (string) $element[ 'kTAG_GID' ] ]
						 	= $node->NID();
			
			} // Iterating nodes.
		
		} // Iterating files.

	} // _InitNodes.

	 
	/*===================================================================================
	 *	_InitEdges																		*
	 *==================================================================================*/

	/**
	 * <h4>Initialise edges</h4>
	 *
	 * This method will load all default edges, it will read the edge definitions from the
	 * files placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitEdges()
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
		// Init local storage.
		//
		$files = array( 'CategoryEdges', 'EnumerationEdges',
						'PredicateEdges', 'AttributeEdges', 'ObjectEdges' );
		
		//
		// Iterate files.
		//
		foreach( $files as $file )
		{
			//
			// Load XML file.
			//
			$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE."/$file.xml" );
			
			//
			// Iterate edges.
			//
			foreach( $xml->edge as $element )
			{
				//
				// Instantiate edge.
				//
				$edge = new COntologyEdge();
				
				//
				// Parse edge.
				//
				$this->_ParseEdge( $db, $element, $edge );
			
			} // Iterating edges.
		
		} // Iterating files.

	} // _InitEdges.

	 
	/*===================================================================================
	 *	_InitVertices																	*
	 *==================================================================================*/

	/**
	 * <h4>Initialise vertices</h4>
	 *
	 * This method will load all default vertices, it will read the vertex definitions from the
	 * files placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitVertices()
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
		// Init local storage.
		//
		$files = array( 'ObjectVertices' );
		
		//
		// Iterate files.
		//
		foreach( $files as $file )
		{
			//
			// Load XML file.
			//
			$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE."/$file.xml" );
			
			//
			// Iterate edges.
			//
			foreach( $xml->vertex as $element )
				$this->_ParseVertex( $db, $element );
		
		} // Iterating files.

	} // _InitVertices.

	 
	/*===================================================================================
	 *	_InitTags																		*
	 *==================================================================================*/

	/**
	 * <h4>Initialise tags</h4>
	 *
	 * This method will load all default tags, it will read the tag definitions from the
	 * files placed in the library definitions directory.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _InitTags()
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
		// Init local storage.
		//
		$files = array( 'AttributeTags' );
		
		//
		// Iterate files.
		//
		foreach( $files as $file )
		{
			//
			// Load XML file.
			//
			$xml = simplexml_load_file( kPATH_MYWRAPPER_LIBRARY_DEFINE."/$file.xml" );
			
			//
			// Iterate edges.
			//
			foreach( $xml->tag as $element )
			{
				//
				// Instantiate edge.
				//
				$tag = new COntologyTag();
				
				//
				// Parse edge.
				//
				$this->_ParseTag( $db, $element, $tag );
			
			} // Iterating edges.
		
		} // Iterating files.

	} // _InitTags.

		

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
			// Save identifier.
			//
			$save = (string) $theElement->{ 'kTAG_SUBJECT' };
			
			//
			// Resolve subject.
			//
			if( array_key_exists( $save, $_SESSION[ kOFFSET_NODES ] ) )
				$theEdge->Subject( $_SESSION[ kOFFSET_NODES ][ $save ] );
			else
				throw new Exception
					( "Subject node not found [$save]",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Load predicate.
			//
			if( $theElement->{ 'kTAG_PREDICATE' } !== NULL )
			{
				//
				// Save identifier.
				//
				$save = (string) $theElement->{ 'kTAG_PREDICATE' };
				
				//
				// Resolve predicate.
				//
				$term = COntologyTerm::Resolve( $theDatabase, $save, NULL, TRUE );
				
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
					// Save identifier.
					//
					$save = (string) $theElement->{ 'kTAG_OBJECT' };
					
					//
					// Resolve object.
					//
					if( array_key_exists( $save, $_SESSION[ kOFFSET_NODES ] ) )
						$theEdge->Object( $_SESSION[ kOFFSET_NODES ] [ $save ] );
					else
						throw new Exception
							( "Object node not found [$save]",
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

	 
	/*===================================================================================
	 *	_ParseVertex																		*
	 *==================================================================================*/

	/**
	 * <h4>Parse the provided edge</h4>
	 *
	 * This method will parse the provided XML vertex, create and fill the relative ontology
	 * objects.
	 *
	 * Terms and master nodes must exist.
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 * @param SimpleXMLElement		$theElement			XML element with term data.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ParseVertex( CDatabase		  $theDatabase,
									 SimpleXMLElement $theElement )
	{
		//
		// Instantiate node.
		//
		if( $theElement->{ 'kTAG_CLASS' } !== NULL )
		{
			$class = (string) $theElement->{ 'kTAG_CLASS' };
			$node = new $class();
		}
		else
			$node = new COntologyAliasVertex();
			
		//
		// Resolve term.
		//
		$term = COntologyTerm::Resolve(
					$theDatabase, (string) $theElement[ 'kTAG_GID' ], NULL, TRUE );
		
		//
		// Set term reference.
		//
		$node->Term( $term );
		
		//
		// Get categories.
		//
		if( $theElement->{'kTAG_CATEGORY'}->count() )
		{
			foreach( $theElement->{'kTAG_CATEGORY'}->{'item'} as $item )
				$node->Category( (string) $item, TRUE );
		
		} // Has categories.
		
		//
		// Get kinds.
		//
		if( $theElement->{'kTAG_KIND'}->count() )
		{
			foreach( $theElement->{'kTAG_KIND'}->{'item'} as $item )
				$node->Kind( (string) $item, TRUE );
		
		} // Has kinds.
		
		//
		// Get types.
		//
		if( $theElement->{'kTAG_TYPE'}->count() )
		{
			foreach( $theElement->{'kTAG_TYPE'}->{'item'} as $item )
				$node->Type( (string) $item, TRUE );
		
		} // Has types.
		
		//
		// Get description.
		//
		if( $theElement->{'kTAG_DESCRIPTION'}->count() )
			$node->Description
				( (string) $theElement->{'kTAG_DESCRIPTION'}[ 'language' ],
				  (string) $theElement->{'kTAG_DESCRIPTION'} );
		
		//
		// Save node.
		//
		$node->Insert( $theDatabase );
		
		//
		// Iterate edges.
		//
		foreach( $theElement->{'edges'}->{'edge'} as $element )
		{
			//
			// Instantiate edge.
			//
			$edge = new COntologyEdge();
			
			//
			// Set subject.
			//
			if( $element->{'kTAG_SUBJECT'}->count() )
			{
				//
				// Save identifier.
				//
				$save = (string) $element->{'kTAG_SUBJECT'}[ 0 ];
				
				//
				// Resolve subject.
				//
				if( array_key_exists( $save, $_SESSION[ kOFFSET_NODES ] ) )
					$edge->Subject( $_SESSION[ kOFFSET_NODES ][ $save ] );
				else
					throw new Exception
						( "Subject node not found [$save]",
						  kERROR_STATE );										// !@! ==>
			}
			else
				$edge->Subject( $node );
			
			//
			// Load predicate.
			//
			if( $element->{'kTAG_PREDICATE'}->count() )
			{
				//
				// Resolve predicate.
				//
				$term = COntologyTerm::Resolve( $theDatabase,
												(string) $element->{'kTAG_PREDICATE'}[ 0 ],
												NULL,
												TRUE );
				
				//
				// Set subject.
				//
				$edge->Predicate( $term );
			
			} // Provided predicate.
			
			else
				throw new Exception
					( "Edge is missing predicate",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Set object.
			//
			if( $element->{'kTAG_OBJECT'}->count() )
			{
				//
				// Save identifier.
				//
				$save = (string) $element->{'kTAG_OBJECT'}[ 0 ];
				
				//
				// Resolve object.
				//
				if( array_key_exists( $save, $_SESSION[ kOFFSET_NODES ] ) )
					$edge->Object( $_SESSION[ kOFFSET_NODES ][ $save ] );
				else
					throw new Exception
						( "Object node not found [$save]",
						  kERROR_STATE );										// !@! ==>
			}
			else
				$edge->Object( $node );
			
			//
			// Insert edge.
			//
			$edge->Insert( $theDatabase );
		
		} // Iterating edges.

	} // _ParseVertex.

	 
	/*===================================================================================
	 *	_ParseTag																		*
	 *==================================================================================*/

	/**
	 * <h4>Parse the provided tag</h4>
	 *
	 * This method will parse the provided XML tag and fill the provided ontology tag.
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 * @param SimpleXMLElement		$theElement			XML element with term data.
	 * @param COntologyNode			$theTag				Receives tag data.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ParseTag( CDatabase			$theDatabase,
								  SimpleXMLElement	$theElement,
								  COntologyTag		$theTag )
	{
		//
		// Load term global identifier.
		//
		if( $theElement[ 'var' ] !== NULL )
		{
			//
			// Iterate path.
			//
			foreach( $theElement->{'kTAG_PATH'}->{'item'} as $item )
			{
				//
				// Resolve term.
				//
				$term = COntologyTerm::Resolve(
							$theDatabase, (string) $item, NULL, TRUE );
				
				//
				// Add to path.
				//
				$theTag->PushItem( $term );
			
			} // Iterating path items.
			
			//
			// Save tag.
			//
			$id = $theTag->Insert( $theDatabase );
		
		} // Has global identifier.
		
		else
			throw new Exception
				( "Tag is missing its symbol",
				  kERROR_STATE );											// !@! ==>

	} // _ParseTag.

	 

} // class COntology.


?>
