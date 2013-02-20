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
 *		<li><tt>{@link kTAG_NODE}</tt>: <i>Node</i>. This attribute contains a reference
 *			to an object that represents the node of the attribute host.
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
 * File.
 *
 * This includes the file function definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION.'/file.php' );

/**
 * Parsers.
 *
 * This include file contains all parser functions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/parsing.php" );

/**
 * ISO standards includes.
 *
 * This includes the ISO standards local definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DATA."/ISOCodes.inc.php" );

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
	 *	InitContainers																	*
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
	 * @access public
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 * @uses NewTerm()
	 */
	public function InitContainers()
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
		$container->AddIndex( array( kTAG_GID => 1 ) );
	//	$container->AddIndex( array( kTAG_NAMESPACE => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_LID => 1 ) );
	//	$container->AddIndex( array( kTAG_TERM => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_SYNONYMS => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_CATEGORY => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_KIND => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_TYPE => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_LABEL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_DEFINITION => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_FEATURES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_METHODS => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_SCALES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_NAMESPACE_REFS => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_NODES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EXAMPLES => 1 ), array( 'sparse' => TRUE ) );
		
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
		$container->AddIndex( array( kTAG_PID => 1 ), array( 'unique' => TRUE,
															 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_TERM => 1 ) );
	//	$container->AddIndex( array( kTAG_NODE => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_CATEGORY => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_KIND => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_TYPE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_INPUT => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_PATTERN => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_LENGTH => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_MIN_VAL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_MAX_VAL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EXAMPLES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_DESCRIPTION => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EDGES => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_NODES => 1 ), array( 'sparse' => TRUE ) );
		
		//
		// Add vertex attributes.
		//
		$container->AddIndex( array( kTAG_LID => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_GID => 1 ), array( 'sparse' => TRUE ) );
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
	//	$container->AddIndex( array( kTAG_GID => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_UID => 1 ), array( 'unique' => TRUE ) );
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
	//	$container->AddIndex( array( kTAG_GID => 1 ), array( 'unique' => TRUE ) );
		$container->AddIndex( array( kTAG_UID => 1 ), array( 'unique' => TRUE ) );
	//	$container->AddIndex( array( kTAG_PATH => 1 ) );
		$container->AddIndex( array( kTAG_TYPE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_INPUT => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_PATTERN => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_LENGTH => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_MIN_VAL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_MAX_VAL => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_EXAMPLES => 1 ), array( 'sparse' => TRUE ) );
		
		//
		// Get users container.
		//
		$container = CUser::DefaultContainer( $db );
		if( ! ($container instanceof CContainer) )
			throw new Exception
				( "Unable to retrieve users container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Init users container.
		//
		$container->drop();
	//	$container->AddIndex( array( kTAG_GID => 1 ), array( 'unique' => TRUE ) );
	//	$container->AddIndex( array( kTAG_USER_NAME => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_USER_CODE => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_USER_PASS => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_USER_MAIL => 1 ), array( 'sparse' => TRUE ) );
		$container->AddIndex( array( kTAG_USER_ROLE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_USER_PROFILE => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_USER_DOMAIN => 1 ), array( 'sparse' => TRUE ) );
	//	$container->AddIndex( array( kTAG_USER_MANAGER => 1 ), array( 'sparse' => TRUE ) );
		
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

	} // InitContainers.

		
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
			// Get database.
			//
			$db = $this->GetDatabase();
			if( ! ($db instanceof CDatabase) )
				throw new Exception
					( "Unable to retrieve database connection",
					  kERROR_STATE );											// !@! ==>
		
			//
			// Set files list.
			//
			$dir = kPATH_MYWRAPPER_LIBRARY_DEFINE;
			$files = array( "$dir/Namespaces.xml", "$dir/Terms.xml", "$dir/Categories.xml",
							"$dir/Attributes.xml", "$dir/Predicates.xml", "$dir/Types.xml",
							"$dir/Kinds.xml", "$dir/Operators.xml", "$dir/Status.xml",
							"$dir/Inputs.xml", "$dir/Term.xml", "$dir/Node.xml",
							"$dir/Edge.xml", "$dir/Tag.xml", "$dir/User.xml" );
		
			//
			// Load files.
			//
			$this->LoadXMLOntologyFile( $files );
			
			return;																	// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Object is not initialised",
			  kERROR_STATE );													// !@! ==>

	} // InitOntology.

		

/*=======================================================================================
 *																						*
 *							PUBLIC ONTOLOGY PARSING INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadXMLOntologyFile																*
	 *==================================================================================*/

	/**
	 * <h4>Load the provided XML ontology file</h4>
	 *
	 * This method will parse and load the provided XML file loading the container terms,
	 * nodes, edges and tags.
	 *
	 * The expected XML structure can be consulted in the {@link Ontology.xsd} schema.
	 *
	 * The file path parameter may be either a string or a list of strings.
	 *
	 * @param mixed					$theFilePath		Path to the XML file(s).
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadXMLOntologyFile( $theFilePath )
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
		// Normalise single file.
		//
		if( ! is_array( $theFilePath ) )
			$theFilePath = array( $theFilePath );
		
		//
		// Cycle files.
		//
		foreach( $theFilePath as $file )
		{
			//
			// Load XML file.
			//
			$xml = simplexml_load_file( $file );
			if( $xml instanceof SimpleXMLElement )
			{
				//
				// Check root.
				//
				if( $xml->getName() == 'ONTOLOGY' )
				{
					//
					// Iterate units.
					//
					foreach( $xml->{'UNIT'} as $unit )
						$this->LoadXMLOntologyUnit( $db, $unit );
				
				} // Ontology root.
			
			} // Parsed successfully the file.
			
			else
				throw new Exception
					( "Unable to parse provided XML file [$file]",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // Iterating files.

	} // LoadXMLOntologyFile.

	 
	/*===================================================================================
	 *	LoadXMLOntologyUnit																*
	 *==================================================================================*/

	/**
	 * <h4>Load the provided XML unit element</h4>
	 *
	 * This method will parse and load the provided XML <tt>UNIT</tt> element.
	 *
	 * The expected XML structure can be consulted in the {@link Ontology.xsd} schema.
	 *
	 * @param CDatabase				$theDatabase		Database instance.
	 * @param SimpleXMLElement		$theUnit			XML unit element.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadXMLOntologyUnit( CDatabase $theDatabase, SimpleXMLElement $theUnit )
	{
		//
		// Init cache.
		//
		$cache = Array();
		
		//
		// Start transaction.
		//
		
		//
		// Iterate terms.
		//
		foreach( $theUnit->{'TERM'} as $element )
			$this->LoadXMLOntologyTerm( $cache, $theDatabase, $element );
		
		//
		// Iterate nodes.
		//
		foreach( $theUnit->{'NODE'} as $element )
			$this->LoadXMLOntologyNode( $cache, $theDatabase, $element );
		
		//
		// Iterate edges.
		//
		foreach( $theUnit->{'EDGE'} as $element )
			$this->LoadXMLOntologyEdge( $cache, $theDatabase, $element );
		
		//
		// Iterate tags.
		//
		foreach( $theUnit->{'TAG'} as $element )
			$this->LoadXMLOntologyTag( $cache, $theDatabase, $element );

		//
		// Commit transaction.
		//

	} // LoadXMLOntologyUnit.

	 
	/*===================================================================================
	 *	LoadXMLOntologyTerm																*
	 *==================================================================================*/

	/**
	 * <h4>Load the provided XML ontology term element</h4>
	 *
	 * This method will parse and load the provided ontology XML <tt>TERM</tt> element.
	 *
	 * The expected XML structure can be consulted in the {@link Ontology.xsd} schema.
	 *
	 * @param Reference			   &$theCache			Unit cache.
	 * @param CDatabase				$theDatabase		Database instance.
	 * @param SimpleXMLElement		$theElement			XML term element.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadXMLOntologyTerm(				 &$theCache,
										 CDatabase		  $theDatabase,
										 SimpleXMLElement $theElement )
	{
		//
		// Handle modification.
		//
		if( $theElement[ 'modify' ] !== NULL )
		{
			//
			// Check identifier.
			//
			$id
				= COntologyTerm::Resolve(
					$theDatabase, (string) $theElement[ 'modify' ], NULL, TRUE )
						->NID();
			
			//
			// Instantiate term.
			//
			$object = new COntologyTerm();
		
		} // Modify.
		
		//
		// Handle insert.
		//
		else
		{
			//
			// Instantiate term.
			//
			$object = new COntologyTerm();
		
			//
			// Handle namespace.
			//
			if( $theElement[ 'NS' ] !== NULL )
				$object->NS(
					COntologyTerm::Resolve(
						$theDatabase, (string) $theElement[ 'NS' ], NULL, TRUE ) );
		
			//
			// Handle local identifier.
			//
			$object->LID( (string) $theElement[ 'LID' ] );
		
		} // Insert.
		
		//
		// Handle other elements.
		//
		foreach( $theElement->{'element'} as $element )
		{
			//
			// Handle by tag.
			//
			if( $element[ 'tag' ] !== NULL )
			{
				//
				// Parse by tag.
				//
				switch( $tag = (string) $element[ 'tag' ] )
				{
					case kTAG_NAMESPACE:
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The namespace cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->NS(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE ) );
						else
							throw new Exception
								( "Unable to set namespace: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_LID:
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The local identifier cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->LID( $data );
						else
							throw new Exception
								( "Unable to set local identifier: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_TERM:
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The master term cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->Term(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE ) );
						else
							throw new Exception
								( "Unable to set master term reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_SYNONYMS:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Synonym( $data, TRUE );
						}
						break;
				
					case kTAG_CATEGORY:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Category( $data, TRUE );
						}
						break;
				
					case kTAG_KIND:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Kind( $data, TRUE );
						}
						break;
				
					case kTAG_TYPE:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Type( $data, TRUE );
						}
						break;
				
					case kTAG_LABEL:
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Label( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Label( NULL, $data );
						break;
				
					case kTAG_DEFINITION:
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Definition( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Definition( NULL, $data );
						break;
					
					default:
						if( $element->{'item'}->count() )
						{
							$list = Array();
							foreach( $element->{'item'} as $item )
							{
								if( $item[ 'key' ] !== NULL )
								{
									if( strlen( $data = (string) $item ) )
										$list[ (string) $item[ 'key' ] ] = $data;
								}
								else
								{
									if( strlen( $data = (string) $item ) )
										$list[] = $data;
								}
							}
							if( count( $list ) )
								$object->offsetSet( $tag, $list );
						}
						elseif( strlen( $data = (string) $element ) )
							$object->offsetSet( $tag, $data );
						break;
				
				} // Parsing by tag.
			
			} // Provided tag.
			
			//
			// Handle by variable.
			//
			elseif( $element[ 'variable' ] !== NULL )
			{
				//
				// Parse by tag symbol.
				//
				switch( $variable = (string) $element[ 'variable' ] )
				{
					case 'kTAG_NAMESPACE':
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The namespace cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->NS(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE )
										->NS() );
						else
							throw new Exception
								( "Unable to set namespace: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_LID':
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The local identifier cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->LID( $data );
						else
							throw new Exception
								( "Unable to set local identifier: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_TERM':
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The master term cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->Term(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE )
										->Term() );
						else
							throw new Exception
								( "Unable to set master term reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_SYNONYMS':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Synonym( $data, TRUE );
						}
						break;
				
					case 'kTAG_CATEGORY':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Category( $data, TRUE );
						}
						break;
				
					case 'kTAG_KIND':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Kind( $data, TRUE );
						}
						break;
				
					case 'kTAG_TYPE':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Type( $data, TRUE );
						}
						break;
				
					case 'kTAG_LABEL':
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Label( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Label( NULL, $data );
						break;
				
					case 'kTAG_DEFINITION':
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Definition( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Definition( NULL, $data );
						break;
					
					default:
						throw new Exception
							( "Unable to set attribute: unknown variable [$variable]",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Parsing by variable.
			
			} // Provided tag.
		
		} // Iterating object elements.
		
		//
		// Handle modification.
		//
		if( $theElement[ 'modify' ] !== NULL )
		{
			//
			// Extract array.
			//
			$object = $object->getArrayCopy();
			
			//
			// Modify object.
			//
			$theDatabase->Container( COntologyTerm::DefaultContainerName() )
				->ManageObject( $object, $id, kFLAG_PERSIST_MODIFY );
		
		} // Modify.
		
		//
		// Insert.
		//
		else
		{
			//
			// Save term.
			//
			$object->Insert( $theDatabase );
		
			//
			// Load cache.
			//
			$theCache[ 'term' ][] = $object;
		
		} // Insert.

	} // LoadXMLOntologyTerm.

	 
	/*===================================================================================
	 *	LoadXMLOntologyNode																*
	 *==================================================================================*/

	/**
	 * <h4>Load the provided XML ontology node element</h4>
	 *
	 * This method will parse and load the provided ontology XML <tt>NODE</tt> element.
	 *
	 * The expected XML structure can be consulted in the {@link Ontology.xsd} schema.
	 *
	 * @param Reference			   &$theCache			Unit cache.
	 * @param CDatabase				$theDatabase		Database instance.
	 * @param SimpleXMLElement		$theElement			XML node element.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadXMLOntologyNode(				 &$theCache,
										 CDatabase		  $theDatabase,
										 SimpleXMLElement $theElement )
	{
		//
		// Handle modification.
		//
		if( $theElement[ 'modify' ] !== NULL )
		{
			//
			// Get node native identifier.
			//
			$object
				= COntologyNode::NewObject(
					$theDatabase, (string) $theElement[ 'modify' ] );
			if( $object === NULL )
				$id
					= COntologyNode::ResolvePID(
						$theDatabase, (string) $theElement[ 'modify' ], TRUE );
			else
				$id = $object->NID();
			
			//
			// Check identifier.
			//
			if( $id === NULL )
				throw new Exception
					( ("Node not found [".(string) $theElement[ 'modify' ]."]"),
					  kERROR_NOT_FOUND );										// !@! ==>
			
			//
			// Instantiate term.
			//
			$object = new COntologyNode();
		
		} // Modify.
		
		//
		// Handle insert.
		//
		else
		{
			//
			// Get node class.
			//
			$class = ( $theElement[ 'class' ] !== NULL )
				   ? (string) $theElement[ 'class' ]
				   : 'COntologyMasterVertex';
		
			//
			// Instantiate node.
			//
			$object = new $class();
		
			//
			// Handle term.
			//
			if( $theElement[ 'term' ] !== NULL )
				$object->Term(
					COntologyTerm::Resolve(
						$theDatabase, (string) $theElement[ 'term' ], NULL, TRUE ) );
		
		} // Insert.
		
		//
		// Handle other elements.
		//
		foreach( $theElement->{'element'} as $element )
		{
			//
			// Resolve element PID.
			//
			$this->ResolveOntologyNode( $theDatabase, $element );
			
			//
			// Handle by tag.
			//
			if( $element[ 'tag' ] !== NULL )
			{
				//
				// Parse by tag.
				//
				switch( $tag = (string) $element[ 'tag' ] )
				{
					case kTAG_TERM:
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The term reference cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->Term(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE ) );
						else
							throw new Exception
								( "Unable to set master term reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_NODE:
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The master node reference cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->Node(
								COntologyNode::NewObject(
									$theDatabase, (int) $data, TRUE ) );
						else
							throw new Exception
								( "Unable to set master node reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_PID:
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The node persistent identifier cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->PID( $data );
						else
							throw new Exception
								( "Unable to set persistent identifier: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_SYNONYMS:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Synonym( $data, TRUE );
						}
						break;
				
					case kTAG_CATEGORY:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Category( $data, TRUE );
						}
						break;
				
					case kTAG_KIND:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Kind( $data, TRUE );
						}
						break;
				
					case kTAG_TYPE:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Type( $data, TRUE );
						}
						break;
				
					case kTAG_INPUT:
						if( strlen( $data = (string) $element ) )
							$object->Input( $data );
						else
						{
							foreach( $element->{'item'} as $item )
							{
								if( strlen( $data = (string) $item ) )
									$object->Input( $data );
							}
						}
						break;
				
					case kTAG_PATTERN:
						if( strlen( $data = (string) $element ) )
							$object->Pattern( $data );
						break;
				
					case kTAG_LENGTH:
						if( strlen( $data = (string) $element ) )
							$object->Length( $data );
						break;
				
					case kTAG_MIN_VAL:
						if( strlen( $data = (string) $element ) )
							$object->LowerBound( $data );
						break;
				
					case kTAG_MAX_VAL:
						if( strlen( $data = (string) $element ) )
							$object->UpperBound( $data );
						break;
				
					case kTAG_EXAMPLES:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Example( $data, TRUE );
						}
						break;
				
					case kTAG_DESCRIPTION:
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Description( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Description( NULL, $data );
						break;
						
					case kTAG_AUTHORS:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Author( $data, TRUE );
						}
						break;
						
					case kTAG_ACKNOWLEDGMENTS:
						if( strlen( $data = (string) $element ) )
							$object->Acknowledgments( $data );
						break;
						
					case kTAG_BIBLIOGRAPHY:
						if( strlen( $data = (string) $element ) )
							$object->Bibliography( $data );
						break;
						
					case kTAG_NOTES:
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Notes( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Notes( NULL, $data );
						break;
					
					default:
						if( $element->{'item'}->count() )
						{
							$list = Array();
							foreach( $element->{'item'} as $item )
							{
								if( $item[ 'key' ] !== NULL )
								{
									if( strlen( $data = (string) $item ) )
										$list[ (string) $item[ 'key' ] ] = $data;
								}
								else
								{
									if( strlen( $data = (string) $item ) )
										$list[] = $data;
								}
							}
							if( count( $list ) )
								$object->offsetSet( $tag, $list );
						}
						elseif( strlen( $data = (string) $element ) )
							$object->offsetSet( $tag, $data );
						break;
				
				} // Parsing by tag.
			
			} // Provided tag.
			
			//
			// Handle by variable.
			//
			elseif( $element[ 'variable' ] !== NULL )
			{
				//
				// Parse by tag symbol.
				//
				switch( $variable = (string) $element[ 'variable' ] )
				{
					case 'kTAG_TERM':
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The term reference cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->Term(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE ) );
						else
							throw new Exception
								( "Unable to set master term reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_NODE':
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The master node reference cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->Node(
								COntologyNode::NewObject(
									$theDatabase, (int) $data, TRUE ) );
						else
							throw new Exception
								( "Unable to set master node reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_PID':
						if( $theElement[ 'modify' ] !== NULL )
							throw new Exception
								( "The node persistent identifier cannot be modified",
								  kERROR_PARAMETER );							// !@! ==>
						if( strlen( $data = (string) $element ) )
							$object->PID( $data );
						else
							throw new Exception
								( "Unable to set persistent identifier: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_SYNONYMS':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Synonym( $data, TRUE );
						}
						break;
				
					case 'kTAG_CATEGORY':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Category( $data, TRUE );
						}
						break;
				
					case 'kTAG_KIND':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Kind( $data, TRUE );
						}
						break;
				
					case 'kTAG_TYPE':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Type( $data, TRUE );
						}
						break;
				
					case 'kTAG_INPUT':
						if( strlen( $data = (string) $element ) )
							$object->Input( $data );
						else
						{
							foreach( $element->{'item'} as $item )
							{
								if( strlen( $data = (string) $item ) )
									$object->Input( $data );
							}
						}
						break;
				
					case 'kTAG_PATTERN':
						if( strlen( $data = (string) $element ) )
							$object->Pattern( $data );
						break;
				
					case 'kTAG_LENGTH':
						if( strlen( $data = (string) $element ) )
							$object->Length( $data );
						break;
				
					case 'kTAG_MIN_VAL':
						if( strlen( $data = (string) $element ) )
							$object->LowerBound( $data );
						break;
				
					case 'kTAG_MAX_VAL':
						if( strlen( $data = (string) $element ) )
							$object->UpperBound( $data );
						break;
				
					case 'kTAG_EXAMPLES':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Example( $data, TRUE );
						}
						break;
				
					case 'kTAG_DESCRIPTION':
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Description( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Description( NULL, $data );
						break;
						
					case 'kTAG_AUTHORS':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Author( $data, TRUE );
						}
						break;
						
					case 'kTAG_ACKNOWLEDGMENTS':
						if( strlen( $data = (string) $element ) )
							$object->Acknowledgments( $data );
						break;
						
					case 'kTAG_BIBLIOGRAPHY':
						if( strlen( $data = (string) $element ) )
							$object->Bibliography( $data );
						break;
						
					case 'kTAG_NOTES':
						if( $element->{'item'}->count() )
						{
							foreach( $element->{'item'} as $item )
							{
								$key = ( $item[ 'key' ] !== NULL )
									 ? (string) $item[ 'key' ]
									 : NULL;
								if( strlen( $data = (string) $item ) )
									$object->Notes( $key, $data );
							}
						}
						elseif( strlen( $data = (string) $element ) )
							$object->Notes( NULL, $data );
						break;
					
					default:
						throw new Exception
							( "Unable to set attribute: unknown variable [$variable]",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Parsing by variable.
			
			} // Provided tag.
		
		} // Iterating object elements.
		
		//
		// Handle modification.
		//
		if( $theElement[ 'modify' ] !== NULL )
		{
			//
			// Extract array.
			//
			$object = $object->getArrayCopy();
			
			//
			// Modify object.
			//
			$theDatabase->Container( COntologyNode::DefaultContainerName() )
				->ManageObject( $object, $id, kFLAG_PERSIST_MODIFY );
		
		} // Modify.
		
		//
		// Insert.
		//
		else
		{
			//
			// Assume term.
			//
			if( $object->Term() === NULL )
				$object->Term( $theCache[ 'term' ][ 0 ] );
		
			//
			// Save node.
			//
			$object->Insert( $theDatabase );
		
			//
			// Load cache.
			//
			$theCache[ 'node' ][] = $object;
		
		} // Insert.

	} // LoadXMLOntologyNode.

	 
	/*===================================================================================
	 *	LoadXMLOntologyEdge																*
	 *==================================================================================*/

	/**
	 * <h4>Load the provided XML ontology edge element</h4>
	 *
	 * This method will parse and load the provided ontology XML <tt>EDGE</tt> element.
	 *
	 * The expected XML structure can be consulted in the {@link Ontology.xsd} schema.
	 *
	 * @param Reference			   &$theCache			Unit cache.
	 * @param CDatabase				$theDatabase		Database instance.
	 * @param SimpleXMLElement		$theElement			XML edge element.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadXMLOntologyEdge(				 &$theCache,
										 CDatabase		  $theDatabase,
										 SimpleXMLElement $theElement )
	{
		//
		// Instantiate node.
		//
		$object = new COntologyEdge();
		
		//
		// Handle other elements.
		//
		foreach( $theElement->{'element'} as $element )
		{
			//
			// Resolve element PID.
			//
			$this->ResolveOntologyNode( $theDatabase, $element );

			//
			// Handle by tag.
			//
			if( $element[ 'tag' ] !== NULL )
			{
				//
				// Resolve tag.
				//
				$tag
					= COntologyTag::Resolve(
						$theDatabase, (string) $element[ 'tag' ], TRUE )
							->NID();
				
				//
				// Parse by tag.
				//
				switch( $tag )
				{
					case kTAG_SUBJECT:
						if( strlen( $data = (string) $element ) )
						{
							if( $element[ 'node' ] !== NULL )
								$object->Subject(
									COntologyNode::NewObject(
										$theDatabase, (int) $data, TRUE ) );
							else
								$object->Subject(
									COntologyMasterNode::Resolve(
										$theDatabase, (string) $data, TRUE ) );
						}
						
						else
							throw new Exception
								( "Unable to set subject reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_PREDICATE:
						if( strlen( $data = (string) $element ) )
							$object->Predicate(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE ) );
						else
							throw new Exception
								( "Unable to set predicate reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case kTAG_OBJECT:
						if( strlen( $data = (string) $element ) )
						{
							if( $element[ 'node' ] !== NULL )
								$object->Object(
									COntologyNode::NewObject(
										$theDatabase, (int) $data, TRUE ) );
							else
								$object->Object(
									COntologyMasterNode::Resolve(
										$theDatabase, (string) $data, TRUE ) );
						}
						
						else
							throw new Exception
								( "Unable to set object reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
					
					default:
						if( $element->{'item'}->count() )
						{
							$list = Array();
							foreach( $element->{'item'} as $item )
							{
								if( $item[ 'key' ] !== NULL )
								{
									if( strlen( $data = (string) $item ) )
										$list[ (string) $item[ 'key' ] ] = $data;
								}
								else
								{
									if( strlen( $data = (string) $item ) )
										$list[] = $data;
								}
							}
							if( count( $list ) )
								$object->offsetSet( $tag, $list );
						}
						elseif( strlen( $data = (string) $element ) )
							$object->offsetSet( $tag, $data );
						break;
				
				} // Parsing by tag.
			
			} // Provided tag.
			
			//
			// Handle by variable.
			//
			elseif( $element[ 'variable' ] !== NULL )
			{
				//
				// Parse by tag symbol.
				//
				switch( $variable = (string) $element[ 'variable' ] )
				{
					case 'kTAG_SUBJECT':
						if( strlen( $data = (string) $element ) )
						{
							if( $element[ 'node' ] !== NULL )
								$object->Subject(
									COntologyNode::NewObject(
										$theDatabase, (int) $data, TRUE ) );
							else
								$object->Subject(
									COntologyMasterNode::Resolve(
										$theDatabase, (string) $data, TRUE ) );
						}
						
						else
							throw new Exception
								( "Unable to set subject reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_PREDICATE':
						if( strlen( $data = (string) $element ) )
							$object->Predicate(
								COntologyTerm::Resolve(
									$theDatabase, (string) $data, NULL, TRUE ) );
						else
							throw new Exception
								( "Unable to set predicate reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
				
					case 'kTAG_OBJECT':
						if( strlen( $data = (string) $element ) )
						{
							if( $element[ 'node' ] !== NULL )
								$object->Object(
									COntologyNode::NewObject(
										$theDatabase, (int) $data, TRUE ) );
							else
								$object->Object(
									COntologyMasterNode::Resolve(
										$theDatabase, (string) $data, TRUE ) );
						}
						
						else
							throw new Exception
								( "Unable to set object reference: it cannot be empty",
								  kERROR_PARAMETER );							// !@! ==>
						break;
					
					default:
						throw new Exception
							( "Unable to set attribute: unknown variable [$variable]",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Parsing by variable.
			
			} // Provided tag.
		
		} // Iterating object elements.
		
		//
		// Assume subject.
		//
		if( $object->Subject() === NULL )
			$object->Subject( $theCache[ 'node' ][ 0 ] );
		
		//
		// Assume predicate.
		//
		if( $object->Predicate() === NULL )
			$object->Predicate( $theCache[ 'term' ][ 0 ] );
		
		//
		// Assume object.
		//
		if( $object->Object() === NULL )
			$object->Object( $theCache[ 'node' ][ 0 ] );
		
		//
		// Resolve subject.
		//
		$subject = $object->Subject();
		if( ! ($subject instanceof COntologyNode) )
			$subject
				= COntologyNode::NewObject(
					$theDatabase, (int) $subject, TRUE );
		
		//
		// Save edge.
		//
		if( ($theElement[ 'master' ] !== NULL)
		 && (strtolower( (string) $theElement[ 'master' ] ) == 'false') )
			$subject
				->RelateTo(
					$object->Predicate(), $object->Object(), $theDatabase, FALSE );
		else
			$subject
				->RelateTo(
					$object->Predicate(), $object->Object(), $theDatabase, TRUE );

	} // LoadXMLOntologyEdge.

	 
	/*===================================================================================
	 *	LoadXMLOntologyTag																*
	 *==================================================================================*/

	/**
	 * <h4>Load the provided XML ontology tag element</h4>
	 *
	 * This method will parse and load the provided ontology XML <tt>TAG</tt> element.
	 *
	 * The expected XML structure can be consulted in the {@link Ontology.xsd} schema.
	 *
	 * @param Reference			   &$theCache			Unit cache.
	 * @param CDatabase				$theDatabase		Database instance.
	 * @param SimpleXMLElement		$theElement			XML tag element.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadXMLOntologyTag(					&$theCache,
										CDatabase		 $theDatabase,
										SimpleXMLElement $theElement )
	{
		//
		// Instantiate term.
		//
		$object = new COntologyTag();
		
		//
		// Handle other elements.
		//
		foreach( $theElement->{'element'} as $element )
		{
			//
			// Resolve element PID.
			//
			$this->ResolveOntologyNode( $theDatabase, $element );

			//
			// Handle by tag.
			//
			if( $element[ 'tag' ] !== NULL )
			{
				//
				// Parse by tag.
				//
				switch( $tag = (string) $element[ 'tag' ] )
				{
					case kTAG_PATH:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
							{
								if( $item[ 'node' ] !== NULL )
									$object->PushItem(
										COntologyNode::NewObject(
											$theDatabase, (int) $data, TRUE ) );
								else
									$object->PushItem(
										COntologyTerm::Resolve(
											$theDatabase, (string) $data, NULL, TRUE ) );
							}
							else
								throw new Exception
									( "Unable to set tag path item: it cannot be empty",
									  kERROR_PARAMETER );						// !@! ==>
						}
						break;
				
					case kTAG_TYPE:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Type( $data, TRUE );
						}
						break;
				
					case kTAG_SYNONYMS:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Synonym( $data, TRUE );
						}
						break;
				
					case kTAG_INPUT:
						if( strlen( $data = (string) $element ) )
							$object->Input( $data );
						else
						{
							foreach( $element->{'item'} as $item )
							{
								if( strlen( $data = (string) $item ) )
									$object->Input( $data );
							}
						}
						break;
				
					case kTAG_PATTERN:
						if( strlen( $data = (string) $element ) )
							$object->Pattern( $data );
						break;
				
					case kTAG_LENGTH:
						if( strlen( $data = (string) $element ) )
							$object->Length( $data );
						break;
				
					case kTAG_MIN_VAL:
						if( strlen( $data = (string) $element ) )
							$object->LowerBound( $data );
						break;
				
					case kTAG_MAX_VAL:
						if( strlen( $data = (string) $element ) )
							$object->UpperBound( $data );
						break;
				
					case kTAG_EXAMPLES:
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Example( $data, TRUE );
						}
						break;
					
					default:
						if( $element->{'item'}->count() )
						{
							$list = Array();
							foreach( $element->{'item'} as $item )
							{
								if( $item[ 'key' ] !== NULL )
								{
									if( strlen( $data = (string) $item ) )
										$list[ (string) $item[ 'key' ] ] = $data;
								}
								else
								{
									if( strlen( $data = (string) $item ) )
										$list[] = $data;
								}
							}
							if( count( $list ) )
								$object->offsetSet( $tag, $list );
						}
						elseif( strlen( $data = (string) $element ) )
							$object->offsetSet( $tag, $data );
						break;
				
				} // Parsing by tag.
			
			} // Provided tag.
			
			//
			// Handle by variable.
			//
			elseif( $element[ 'variable' ] !== NULL )
			{
				//
				// Parse by tag symbol.
				//
				switch( $variable = (string) $element[ 'variable' ] )
				{
					case 'kTAG_PATH':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
							{
								if( $item[ 'node' ] !== NULL )
									$object->PushItem(
										COntologyNode::NewObject(
											$theDatabase, (int) $data, TRUE ) );
								else
									$object->PushItem(
										COntologyTerm::Resolve(
											$theDatabase, (string) $data, NULL, TRUE ) );
							}
							else
								throw new Exception
									( "Unable to set tag path item: it cannot be empty",
									  kERROR_PARAMETER );						// !@! ==>
						}
						break;
				
					case 'kTAG_TYPE':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Type( $data, TRUE );
						}
						break;
				
					case 'kTAG_SYNONYMS':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Synonym( $data, TRUE );
						}
						break;
				
					case 'kTAG_INPUT':
						if( strlen( $data = (string) $element ) )
							$object->Input( $data );
						else
						{
							foreach( $element->{'item'} as $item )
							{
								if( strlen( $data = (string) $item ) )
									$object->Input( $data );
							}
						}
						break;
				
					case 'kTAG_PATTERN':
						if( strlen( $data = (string) $element ) )
							$object->Pattern( $data );
						break;
				
					case 'kTAG_LENGTH':
						if( strlen( $data = (string) $element ) )
							$object->Length( $data );
						break;
				
					case 'kTAG_MIN_VAL':
						if( strlen( $data = (string) $element ) )
							$object->LowerBound( $data );
						break;
				
					case 'kTAG_MAX_VAL':
						if( strlen( $data = (string) $element ) )
							$object->UpperBound( $data );
						break;
				
					case 'kTAG_EXAMPLES':
						foreach( $element->{'item'} as $item )
						{
							if( strlen( $data = (string) $item ) )
								$object->Example( $data, TRUE );
						}
						break;
					
					default:
						throw new Exception
							( "Unable to set attribute: unknown variable [$variable]",
							  kERROR_PARAMETER );								// !@! ==>
				
				} // Parsing by variable.
			
			} // Provided tag.
		
		} // Iterating object elements.
		
		//
		// Save tag.
		//
		$object->Insert( $theDatabase );
		
		//
		// Load cache.
		//
		$theCache[ 'tag' ][] = $object;

	} // LoadXMLOntologyTag.

	 
	/*===================================================================================
	 *	ResolveOntologyNode																*
	 *==================================================================================*/

	/**
	 * <h4>Resolve ontology node</h4>
	 *
	 * This method will parse all elements and items intercepting <tt>node</tt> attributes,
	 * depending on the value of that attribute the method will do the following:
	 *
	 * <ul>
	 *	<li><tt>term</tt>: The value of the element is supposed to be a term global
	 *		identifier, the method will resolve the master node that is related to that
	 *		term, replace the attribute value with <tt>node</tt> and replace the current
	 *		element value with the native identifier of the resolved master node.
	 *	<li><tt>node</tt>: The method will do nothing, assuming the element's value is a
	 *		node native identifier.
	 *	<li><tt>pid</tt>: The value of the element is supposed to be a node persistent
	 *		identifier, the method will resolve the node, replace the attribute value with
	 *		<tt>node</tt> and replace the current element value with the native identifier
	 *		of the resolved node.
	 * </ul>
	 *
	 * If any node is not resolved, the method will raise an exception.
	 *
	 * @param CDatabase				$theDatabase		Database instance.
	 * @param SimpleXMLElement		$theElement			XML element.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function ResolveOntologyNode( CDatabase		  $theDatabase,
										 SimpleXMLElement $theElement )
	{
		//
		// Check element's node attribute.
		//
		if( $theElement[ 'node' ] !== NULL )
		{
			//
			// Parse by reference type.
			//
			switch( $type = (string) $theElement[ 'node' ] )
			{
				//
				// Node native identifier.
				//
				case 'node':
					break;
			
				//
				// Node persistent identifier.
				//
				case 'pid':
					$theElement[ 0 ]
						= (string) COntologyNode::ResolvePID(
										$theDatabase, (string) $theElement, TRUE );
					break;
			
				//
				// Term global identifier.
				//
				case 'term':
					$theElement[ 0 ]
						= COntologyMasterVertex::Resolve(
							$theDatabase, (string) $theElement, TRUE )
								->NID();
					break;
				
				default:
					throw new Exception
						( "Unable to set resolve node: "
						 ."provided unsupported element reference type [$type]",
						  kERROR_PARAMETER );									// !@! ==>
			
			} // Parsing by reference type.
			
			//
			// Set reference type.
			//
			$theElement[ 'node' ] = 'node';
		
		} // Is a node reference.
		
		//
		// Check element items.
		//
		elseif( $theElement->{'item'}->count() )
		{
			//
			// Iterate element items.
			//
			foreach( $theElement->{'item'} as $item )
			{
				//
				// Check element's node attribute.
				//
				if( $item[ 'node' ] !== NULL )
				{
					//
					// Parse by reference type.
					//
					switch( $type = (string) $item[ 'node' ] )
					{
						//
						// Node native identifier.
						//
						case 'node':
							break;
			
						//
						// Node persistent identifier.
						//
						case 'pid':
							$item[ 0 ]
								= (string) COntologyNode::ResolvePID(
												$theDatabase, (string) $item, TRUE );
							break;
			
						//
						// Term global identifier.
						//
						case 'term':
							$item[ 0 ]
								= COntologyMasterVertex::Resolve(
									$theDatabase, (string) $item, TRUE )
										->NID();
							break;
				
						default:
							throw new Exception
								( "Unable to set resolve node: "
								 ."provided unsupported item reference type [$type]",
								  kERROR_PARAMETER );							// !@! ==>
			
					} // Parsing by reference type.
			
					//
					// Set reference type.
					//
					$item[ 'node' ] = 'node';
		
				} // Is a node reference.
			
			} // Iterating items.
		
		} // Has items.

	} // ResolveOntologyNode.

		

/*=======================================================================================
 *																						*
 *							PUBLIC CUSTOM ONTOLOGY INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	LoadISOPOFiles																	*
	 *==================================================================================*/

	/**
	 * <h4>Load the standard ISO ontology</h4>
	 *
	 * This method will load the ISO standards into the ontology, it takes the information
	 * from the {@link http://pkg-isocodes.alioth.debian.org} web page project.
	 *
	 * The method requires the path to the unit XML file containing the ISO categories, it
	 * will then decode the PO files and load the information.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function LoadISOPOFiles()
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
		// Decode PO files.
		//
		$this->_ISODecodePOFiles();
		
		//
		// Parse ISO XMLfiles.
		//
		$this->_ISOParseXMLFiles( $db );

	} // LoadISOPOFiles.

	 
	/*===================================================================================
	 *	SetAllCountries																	*
	 *==================================================================================*/

	/**
	 * <h4>Set all countries to provided element</h4>
	 *
	 * This method will connect all ISO 3166-1 and ISO 3166-3 countries to the provided
	 * enumeration.
	 *
	 * @param string				$theEnumeration		GID of enumeration.
	 * @param string				$theEnumeration		GID of enumeration.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function SetAllCountries( $theEnumeration )
	{
		//
		// Handle enumerations list.
		//
		if( is_array( $theEnumeration ) )
		{
			foreach( $theEnumeration as $enum )
				$this->SetAllCountries( $enum );
		}
		
		//
		// Handle single enumeration.
		//
		else
		{
			//
			// Get database.
			//
			$db = $this->GetDatabase();
			if( ! ($db instanceof CDatabase) )
				throw new Exception
					( "Unable to retrieve database connection",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Get container.
			//
			$container = COntologyEdge::DefaultContainer( $db );
		
			//
			// Resolve references.
			//
			$node = COntologyMasterNode::Resolve( $db, $theEnumeration, TRUE );
			$actual = COntologyMasterNode::Resolve( $db, 'ISO:3166:1:alpha-3', TRUE );
			$obsolete = COntologyMasterNode::Resolve( $db, 'ISO:3166:3:alpha-3', TRUE );
			$predicate = COntologyTerm::Resolve( $db, kPREDICATE_ENUM_OF, NULL, TRUE );
			
			//
			// Load actual elements.
			//
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_OBJECT, $actual->NID() ) );
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_PREDICATE, $predicate->NID(), kTYPE_BINARY_STRING ) );
			$rs = $container-> Query( $query, array( kTAG_SUBJECT ) );
			foreach( $rs as $object )
			{
				$edge = new COntologyEdge();
				$edge->Subject( $object[ kTAG_SUBJECT ] );
				$edge->Predicate( $predicate );
				$edge->Object( $node );
				$edge->Insert( $container );
			}
			
			//
			// Load obsolete elements.
			//
			$query = $container->NewQuery();
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_OBJECT, $obsolete->NID() ) );
			$query->AppendStatement(
				CQueryStatement::Equals(
					kTAG_PREDICATE, $predicate->NID(), kTYPE_BINARY_STRING ) );
			$rs = $container-> Query( $query, array( kTAG_SUBJECT ) );
			foreach( $rs as $object )
			{
				$edge = new COntologyEdge();
				$edge->Subject( $object[ kTAG_SUBJECT ] );
				$edge->Predicate( $predicate );
				$edge->Object( $node );
				$edge->Insert( $container );
			}
		}

	} // SetAllCountries.

		

/*=======================================================================================
 *																						*
 *							PROTECTED ISO ONTOLOGY INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ISODecodePOFiles																*
	 *==================================================================================*/

	/**
	 * <h4>Decode PO files</h4>
	 *
	 * This method will parse all MO files, decode them into PO files and write to the
	 * {@link kISO_FILE_PO_DIR} directory the PHP serialised decode array.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISODecodePOFiles()
	{
		//
		// Init local storage.
		//
		$_SESSION[ kISO_LANGUAGES ] = Array();
		
		//
		// Init files list.
		// The order is important!!!
		//
		$_SESSION[ kISO_FILES ]
			= array( kISO_FILE_639_3, kISO_FILE_639, kISO_FILE_3166,
					 kISO_FILE_3166_2, kISO_FILE_4217, kISO_FILE_15924 );
		
		//
		// Point to MO files.
		//
		$_SESSION[ kISO_FILE_MO_DIR ] = kISO_CODES_PATH.kISO_CODES_PATH_LOCALE;
		$moditer = new DirectoryIterator( $_SESSION[ kISO_FILE_MO_DIR ] );

		//
		// Create temporary directory.
		//
		if( kOPTION_VERBOSE )
			echo( "    - Decoding PO files\n" );
		$_SESSION[ kISO_FILE_PO_DIR ] = tempnam( sys_get_temp_dir(), '' );
		if( file_exists( $_SESSION[ kISO_FILE_PO_DIR ] ) )
			unlink( $_SESSION[ kISO_FILE_PO_DIR ] );
		mkdir( $_SESSION[ kISO_FILE_PO_DIR ] );
		if( ! is_dir( $_SESSION[ kISO_FILE_PO_DIR ] ) )
			throw new Exception
				( "Unable to create temporary PO directory",
				  kERROR_STATE );												// !@! ==>
		$_SESSION[ kISO_FILE_PO_DIR ]
			= realpath( $_SESSION[ kISO_FILE_PO_DIR ] );
		
		//
		// Iterate languages.
		//
		foreach( $moditer as $language )
		{
			//
			// Handle valid directories.
			//
			if( $language->isDir()
			 && (! $language->isDot()) )
			{
				//
				// Save language code.
				//
				$code = $language->getBasename();
				$_SESSION[ kISO_LANGUAGES ][] = $code;
				if( kOPTION_VERBOSE )
					echo( "      $code\n" );
				
				//
				// Create language directory.
				//
				$dir = $_SESSION[ kISO_FILE_PO_DIR ]."/$code";
				DeleteFileDir( $dir );
				mkdir( $dir );
				if( ! is_dir( $dir ) )
					throw new Exception
						( "Unable to create temporary language directory",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Iterate files.
				//
				$mofiter = new DirectoryIterator
					( $language->getRealPath().kISO_CODES_PATH_MSG );
				foreach( $mofiter as $file )
				{
					//
					// Skip invisible files.
					//
					$name = $file->getBasename( '.mo' );
					if( ! $file->isDot()
					 && in_array( $name, $_SESSION[ kISO_FILES ] ) )
					{
						//
						// Create filenames.
						//
						$filename_po = realpath( $dir )."/$name.po";
						$filename_key = realpath( $dir )."/$name.serial";
						
						//
						// Convert to PO.
						//
						$source = $file->getRealPath();
						exec( "msgunfmt -o \"$filename_po\" \"$source\"" );
						
						//
						// Convert to key.
						//
						file_put_contents(
							$filename_key,
							serialize( PO2Array( $filename_po ) ) );
					
					} // Workable file.
				
				} // Iterating files.
			
			} // Valid directory.
		
		} // Iterating languages.
		
	} // _ISODecodePOFiles.

	 
	/*===================================================================================
	 *	_ISOParseXMLFiles																*
	 *==================================================================================*/

	/**
	 * <h4>Parse XML files</h4>
	 *
	 * This method will parse the XML files and store the data in the database.
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParseXMLFiles( CDatabase $theDatabase )
	{
		//
		// Iterate known fiels.
		//
		if( kOPTION_VERBOSE )
			echo( "    - Parsing XML files\n" );
		foreach( $_SESSION[ kISO_FILES ] as $file )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "      $file\n" );
				
			//
			// Parse by file.
			//
			switch( $file )
			{
				case kISO_FILE_639_3:
					$this->_ISOParse6393XML( $theDatabase );
					break;
					
				case kISO_FILE_639:
					$this->_ISOParse639XML( $theDatabase );
					break;
					
				case kISO_FILE_3166:
					$this->_ISOParse31661XML( $theDatabase );
					$this->_ISOParse31663XML( $theDatabase );
					break;
					
				case kISO_FILE_3166_2:
					$this->_ISOParse31662XML( $theDatabase );
					break;
					
				case kISO_FILE_4217:
					$this->_ISOParse4217XML( $theDatabase );
					break;
					
				case kISO_FILE_15924:
					$this->_ISOParse15924XML( $theDatabase );
					break;
			}
		
		} // Iterating the files.
		
	} // _ISOParseXMLFiles.

	 
	/*===================================================================================
	 *	_ISOParse6393XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 639-3 XML files</h4>
	 *
	 * This method will parse the XML ISO 639-3 files.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:639:1</tt>: Part 1 code [<tt>part1_code</tt>].
	 *	<li><tt>ISO:639:2</tt>: Part 2 code [<tt>part2_code</tt>].
	 *	<li><tt>ISO:639:3</tt>: Part 3 code [<tt>id</tt>].
	 *	<li><tt>ISO:639:status</tt>: Status [<tt>status</tt>].
	 *	<li><tt>ISO:639:scope</tt>: Scope [<tt>scope</tt>].
	 *	<li><tt>ISO:639:type</tt>: Type [<tt>type</tt>].
	 *	<li><tt>ISO:639:inverted_name</tt>: Inverted name [<tt>inverted_name</tt>].
	 *	<li><tt>ISO:639:common_name</tt>: Common name [<tt>common_name</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: Label <tt>name</tt> [<tt>name</tt>].
	 *	<li><tt>{@link kTAG_DEFINITION}/tt>: Definition [<tt>reference_name</tt>].
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse6393XML( CDatabase $theDatabase )
	{
		//
		// Load XML file.
		//
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_639_3.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 639 1, 2, 3\n" );
			
			//
			// Resolve namespaces.
			//
			$ns1 = COntologyTerm::Resolve( $theDatabase, '1', 'ISO:639', TRUE );
			$ns2 = COntologyTerm::Resolve( $theDatabase, '2', 'ISO:639', TRUE );
			$ns3 = COntologyTerm::Resolve( $theDatabase, '3', 'ISO:639', TRUE );
			
			//
			// Resolve tags.
			//
			$tag_status =
				COntologyTag::Resolve( $theDatabase, 'ISO:639:status', TRUE );
			$tag_scope =
				COntologyTag::Resolve( $theDatabase, 'ISO:639:scope', TRUE );
			$tag_type =
				COntologyTag::Resolve( $theDatabase, 'ISO:639:type', TRUE );
			$tag_inverted_name =
				COntologyTag::Resolve( $theDatabase, 'ISO:639:inverted_name', TRUE );
			$tag_common_name
				= COntologyTag::Resolve( $theDatabase, 'ISO:639:common_name', TRUE );
			
			//
			// Resolve Parents.
			//
			$par1 = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:639:1', TRUE );
			$par2 = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:639:2', TRUE );
			$par3 = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:639:3', TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_639_3_entry'} as $record )
			{
				//
				// Check identifier.
				//
				if( $record[ 'id' ] !== NULL )
				{
					//
					// Save local identifier.
					//
					$id = (string) $record[ 'id' ];
					
					//
					// Resolve term.
					//
					if( COntologyTerm::Resolve( $theDatabase, $id, $ns3 ) === NULL )
					{
						//
						// Instantiate part 3 term.
						//
						$term3 = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$term3->NS( $ns3 );
						$term3->LID( $id );
						$term3->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'name' ] !== NULL )
							$term3->Label( 'en',
										   (string) $record[ 'name' ] );
						if( $record[ 'reference_name' ] !== NULL )
							$term3->Definition( 'en',
												(string) $record[ 'reference_name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$term3,
							kISO_FILE_639_3,
							array( kTAG_LABEL, kTAG_DEFINITION ) );
						
						//
						// Save term.
						//
						$term3->Insert( $theDatabase );
						
						//
						// Create node.
						//
						$node3 = new COntologyMasterVertex();
						$node3->Kind( kKIND_ENUMERATION, TRUE );
						$node3->Term( $term3 );
						
						//
						// Load custom language string attributes.
						//
						if( $record[ 'inverted_name' ] !== NULL )
							$node3[ $tag_inverted_name->NID() ]
								= array( 'en' => (string) $record[ 'inverted_name' ] );
						if( $record[ 'common_name' ] !== NULL )
							$node3[ $tag_common_name->NID() ]
								= array( 'en' => (string) $record[ 'common_name' ] );
						
						//
						// Load status.
						//
						if( ($record[ 'status' ] !== NULL)
						 && strlen( $en = trim( (string) $record[ 'status' ] ) ) )
							$node3[ $tag_status->NID() ] = $en;
						
						//
						// Load custom enumerations.
						//
						if( ($record[ 'scope' ] !== NULL)
						 && strlen( $en = trim( (string) $record[ 'scope' ] ) ) )
						{
							//
							// Handle the "L" scope.
							//
							if( $en == 'L' )
								$en = 'R';
							
							//
							// Check enumeration.
							//
							if( COntologyTerm::Resolve(
									$theDatabase, $en, $tag_scope->GID() ) !== NULL )
								$node3[ $tag_scope->NID() ]
									= $tag_scope->GID().kTOKEN_NAMESPACE_SEPARATOR.$en;
							elseif( kOPTION_VERBOSE )
								echo( "          ! $id - scope - $en\n" );
						}
						if( ($record[ 'type' ] !== NULL)
						 && strlen( $en = trim( (string) $record[ 'type' ] ) ) )
						{
							//
							// Handle Genetic, Ancient.
							//
							if( $en == 'Genetic, Ancient' )
								$node3[ $tag_type->NID() ]
									= array( ($tag_type->GID()
											 .kTOKEN_NAMESPACE_SEPARATOR
											 .'Genetic'),
											($tag_type->GID()
											 .kTOKEN_NAMESPACE_SEPARATOR
											 .'A') );
							//
							// Check enumeration.
							//
							else
							{
								if( COntologyTerm::Resolve(
										$theDatabase, $en, $tag_type->GID() ) !== NULL )
									$node3[ $tag_type->NID() ]
										= $tag_type->GID().kTOKEN_NAMESPACE_SEPARATOR.$en;
								elseif( kOPTION_VERBOSE )
									echo( "          ! $id - type - $en\n" );
							}
						}
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$node3,
							kISO_FILE_639_3,
							array( (string) $tag_inverted_name->NID(),
								   (string) $tag_common_name->NID() ) );

						//
						// Save node.
						//
						$node3->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node3 );
						$edge->Predicate( $enum_of );
						$edge->Object( $par3 );
						$edge->Insert( $theDatabase );
						
						//
						// Handle part 1.
						//
						if( $record[ 'part1_code' ] !== NULL )
						{
							//
							// Check part 1 term.
							//
							if( ($term1 = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'part1_code' ], $ns1 ))
										=== NULL )
							{
								//
								// Instantiate part 1 term.
								//
								$term1 = new COntologyTerm();
								$term1->NS( $ns1 );
								$term1->LID( (string) $record[ 'part1_code' ] );
								if( $term3->offsetExists( kTAG_LABEL ) )
									$term1->offsetSet( kTAG_LABEL,
													   $term3->offsetGet( kTAG_LABEL ) );
								$term1->Kind( kKIND_ENUMERATION, TRUE );
								$term1->Term( $term3 );
								$term1->Insert( $theDatabase );
								
								//
								// Instantiate part 1 node.
								//
								$node1 = new COntologyMasterVertex();
								$node1->Kind( kKIND_ENUMERATION, TRUE );
								$node1->Term( $term1 );
								$node1->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $node1 );
								$edge->Predicate( $enum_of );
								$edge->Object( $par1 );
								$edge->Insert( $theDatabase );
							
							} // New part 1.
							
							//
							// Resolve part 1 node.
							//
							else
								$node1
									= COntologyMasterVertex::Resolve(
										$theDatabase, $term1->NID() );
							
							//
							// Relate to part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node1 );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node3 );
							$edge->Insert( $theDatabase );
							
						} // Provided part 1.
						
						else
							$node1 = NULL;
						
						//
						// Handle part 2.
						//
						if( $record[ 'part2_code' ] !== NULL )
						{
							//
							// Check part 2 term.
							//
							if( ($term2 = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'part2_code' ], $ns2 ))
										=== NULL )
							{
								//
								// Instantiate part 1 term.
								//
								$term2 = new COntologyTerm();
								$term2->NS( $ns2 );
								$term2->LID( (string) $record[ 'part2_code' ] );
								if( $term3->offsetExists( kTAG_LABEL ) )
									$term2->offsetSet( kTAG_LABEL,
													   $term3->offsetGet( kTAG_LABEL ) );
								$term2->Kind( kKIND_ENUMERATION, TRUE );
								$term2->Term( $term3 );
								$term2->Insert( $theDatabase );
								
								//
								// Instantiate part 1 node.
								//
								$node2 = new COntologyMasterVertex();
								$node2->Kind( kKIND_ENUMERATION, TRUE );
								$node2->Term( $term2 );
								$node2->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $node2 );
								$edge->Predicate( $enum_of );
								$edge->Object( $par2 );
								$edge->Insert( $theDatabase );
							
							} // New part 2.
							
							//
							// Resolve part 2 node.
							//
							else
								$node2
									= COntologyMasterVertex::Resolve(
										$theDatabase, $term2->NID() );
							
							//
							// Relate to part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node2 );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node3 );
							$edge->Insert( $theDatabase );
							
						} // Provided part 2.
						
						else
							$node2 = NULL;
						
						//
						// Handle part 1 cross references.
						//
						if( $node1 !== NULL )
						{
							//
							// Cross reference part 1 from part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node3 );
							$edge->Predicate( $xref );
							$edge->Object( $node1 );
							$edge->Insert( $theDatabase );
						
							//
							// Cross reference part 1 from part 2.
							//
							if( $node2 !== NULL )
							{
								$edge = new COntologyEdge();
								$edge->Subject( $node2 );
								$edge->Predicate( $xref );
								$edge->Object( $node1 );
								$edge->Insert( $theDatabase );
							
							} // Has part 2 code.
						
						} // Has part 1 code.
						
						//
						// Handle part 2 cross references.
						//
						if( $node2 !== NULL )
						{
							//
							// Cross reference part 2 from part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node3 );
							$edge->Predicate( $xref );
							$edge->Object( $node2 );
							$edge->Insert( $theDatabase );
						
							//
							// Cross reference part 2 from part 1.
							//
							if( $node1 !== NULL )
							{
								$edge = new COntologyEdge();
								$edge->Subject( $node1 );
								$edge->Predicate( $xref );
								$edge->Object( $node2 );
								$edge->Insert( $theDatabase );
							
							} // Has part 1 code.
						
						} // Has part 2 code.
					
					} // New record.
					
					elseif( kOPTION_VERBOSE )
						echo( "          ! $id\n" );
				
				} // Has record identifier.
			
			} // Iterating entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );												// !@! ==>
		
	} // _ISOParse6393XML.

	 
	/*===================================================================================
	 *	_ISOParse639XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 639 XML files</h4>
	 *
	 * This method will parse the XML ISO 639 files.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:639:1</tt>: Part 1 code [<tt>iso_639_1_code</tt>] (as reference).
	 *	<li><tt>ISO:639:2B</tt>: Part 2B code [<tt>iso_639_2B_code</tt>].
	 *	<li><tt>ISO:639:2T</tt>: Part 2T code [<tt>iso_639_2T_code</tt>].
	 *	<li><tt>ISO:639:inverted_name</tt>: Inverted name [<tt>inverted_name</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: Label <tt>name</tt> [<tt>name</tt>]. This is used
	 *		only if the part 1 code is not found.
	 *	<li><tt>{@link kTAG_DEFINITION}/tt>: Definition [<tt>reference_name</tt>]. This is used
	 *		only if the part 1 code is not found.
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse639XML( CDatabase $theDatabase )
	{
		//
		// Load XML file.
		//
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_639.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 639 2B, 2T\n" );
			
			//
			// Resolve namespaces.
			//
			$ns1 = COntologyTerm::Resolve( $theDatabase, '1', 'ISO:639', TRUE );
			$ns2b = COntologyTerm::Resolve( $theDatabase, '2B', 'ISO:639', TRUE );
			$ns2t = COntologyTerm::Resolve( $theDatabase, '2T', 'ISO:639', TRUE );
			
			//
			// Resolve Parents.
			//
			$par1 = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:639:1', TRUE );
			$par2b = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:639:2B', TRUE );
			$par2t = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:639:2T', TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_639_entry'} as $record )
			{
				//
				// Init local storage.
				//
				$node1 = $node2B = $node2T = $node3 = NULL;
				
				//
				// Handle part 1.
				//
				if( $record[ 'iso_639_1_code' ] !== NULL )
				{
					//
					// Check part 1 term.
					//
					if( ($term1 = COntologyTerm::Resolve(
							$theDatabase, (string) $record[ 'iso_639_1_code' ], $ns1 ))
								=== NULL )
					{
						//
						// Instantiate part 1 term.
						//
						$term1 = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$term1->NS( $ns1 );
						$term1->LID( (string) $record[ 'iso_639_1_code' ] );
						$term1->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'name' ] !== NULL )
							$term1->Label( 'en',
										   (string) $record[ 'name' ] );
						if( $record[ 'common_name' ] !== NULL )
							$term1->Definition( 'en',
												(string) $record[ 'common_name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$term1,
							kISO_FILE_639,
							array( kTAG_LABEL, kTAG_DEFINITION ) );
						
						//
						// Save term.
						//
						$term1->Insert( $theDatabase );
						
						//
						// Instantiate part 1 node.
						//
						$node1 = new COntologyMasterVertex();
						$node1->Kind( kKIND_ENUMERATION, TRUE );
						$node1->Term( $term1 );
						$node1->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node1 );
						$edge->Predicate( $enum_of );
						$edge->Object( $par1 );
						$edge->Insert( $theDatabase );
					
					} // New part 1.
					
					//
					// Resolve part 1 node.
					//
					else
					{
						//
						// Instantiate part 1 node.
						//
						$node1
							= COntologyMasterVertex::Resolve(
								$theDatabase, $term1->NID() );
						
						//
						// Resolve eventual part 3 node.
						//
						if( ($ref = $term1->Term()) !== NULL )
							$node3
								= COntologyMasterVertex::Resolve(
									$theDatabase, $ref, TRUE );
					
					} // Existing part 1.
					
				} // Provided part 1.

				//
				// Handle part 2B.
				//
				if( $record[ 'iso_639_2B_code' ] !== NULL )
				{
					//
					// Check part 2B term.
					//
					if( ($term2b = COntologyTerm::Resolve(
							$theDatabase, (string) $record[ 'iso_639_2B_code' ], $ns2b ))
								=== NULL )
					{
						//
						// Instantiate part 2b term.
						//
						$term2b = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$term2b->NS( $ns2b );
						$term2b->LID( (string) $record[ 'iso_639_2B_code' ] );
						$term2b->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Relate term.
						//
						if( $node3 !== NULL )
						{
							$term2b->Term( $node3->Term() );
							if( $node3->offsetExists( kTAG_LABEL ) )
								$term2b->offsetSet(
									kTAG_LABEL,
									$node3->offsetGet( kTAG_LABEL ) );
						}
						elseif( $node1 !== NULL )
						{
							$term2b->Term( $node1->Term() );
							if( $node1->offsetExists( kTAG_LABEL ) )
								$term2b->offsetSet(
									kTAG_LABEL,
									$node1->offsetGet( kTAG_LABEL ) );
						}
						
						//
						// Complete term.
						//
						else
						{
							//
							// Set base names.
							//
							if( $record[ 'name' ] !== NULL )
								$term2b->Label( 'en',
												(string) $record[ 'name' ] );
							if( $record[ 'common_name' ] !== NULL )
								$term2b->Definition( 'en',
													 (string) $record[ 'common_name' ] );
							
							//
							// Collect language strings.
							//
							$this->_ISOCollectLanguageStrings(
								$term2b,
								kISO_FILE_639,
								array( kTAG_LABEL, kTAG_DEFINITION ) );
						
						} // Unrelated term.
						
						//
						// Save term.
						//
						$term2b->Insert( $theDatabase );
						
						//
						// Instantiate part 2B node.
						//
						$node2b = new COntologyMasterVertex();
						$node2b->Kind( kKIND_ENUMERATION, TRUE );
						$node2b->Term( $term2b );
						$node2b->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node2b );
						$edge->Predicate( $enum_of );
						$edge->Object( $par2b );
						$edge->Insert( $theDatabase );
					
					} // New part 2B term.
					
					//
					// Resolve part 2B node.
					//
					else
						$node2b
							= COntologyMasterVertex::Resolve(
								$theDatabase, $term2b->NID() );
					
				} // Provided part 2B.

				//
				// Handle part 2T.
				//
				if( $record[ 'iso_639_2T_code' ] !== NULL )
				{
					//
					// Check part 2T term.
					//
					if( ($term2t = COntologyTerm::Resolve(
							$theDatabase, (string) $record[ 'iso_639_2T_code' ], $ns2t ))
								=== NULL )
					{
						//
						// Instantiate part 2t term.
						//
						$term2t = new COntologyTerm();
						$term2t->NS( $ns2t );
						$term2t->LID( (string) $record[ 'iso_639_2T_code' ] );
						$term2t->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Relate term.
						//
						if( $node3 !== NULL )
						{
							$term2t->Term( $node3->Term() );
							if( $node3->offsetExists( kTAG_LABEL ) )
								$term2t->offsetSet(
									kTAG_LABEL,
									$node3->offsetGet( kTAG_LABEL ) );
						}
						elseif( $node1 !== NULL )
						{
							$term2t->Term( $node1->Term() );
							if( $node1->offsetExists( kTAG_LABEL ) )
								$term2t->offsetSet(
									kTAG_LABEL,
									$node1->offsetGet( kTAG_LABEL ) );
						}
						
						//
						// Complete term.
						//
						else
						{
							//
							// Set base names.
							//
							if( $record[ 'name' ] !== NULL )
								$term2t->Label( 'en',
												(string) $record[ 'name' ] );
							if( $record[ 'common_name' ] !== NULL )
								$term2t->Definition( 'en',
													 (string) $record[ 'common_name' ] );
							
							//
							// Collect language strings.
							//
							$this->_ISOCollectLanguageStrings(
								$term2t,
								kISO_FILE_639,
								array( kTAG_LABEL, kTAG_DEFINITION ) );
						
						} // Unrelated term.
						
						//
						// Save term.
						//
						$term2t->Insert( $theDatabase );
						
						//
						// Instantiate part 2B node.
						//
						$node2t = new COntologyMasterVertex();
						$node2t->Kind( kKIND_ENUMERATION, TRUE );
						$node2t->Term( $term2b );
						$node2t->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node2t );
						$edge->Predicate( $enum_of );
						$edge->Object( $par2t );
						$edge->Insert( $theDatabase );
					
					} // New part 2T term.
					
					//
					// Resolve part 2T node.
					//
					else
						$node2t
							= COntologyMasterVertex::Resolve(
								$theDatabase, $term2T->NID() );
					
				} // Provided part 2T.
				
				//
				// Handle part 2B.
				//
				if( $node2B !== NULL )
				{
					//
					// Relate to part 3.
					//
					if( $node3 !== NULL )
					{
						$edge = new COntologyEdge();
						$edge->Subject( $node2B );
						$edge->Predicate( $xref_ex );
						$edge->Object( $node3 );
						$edge->Insert( $theDatabase );
					}
					
					//
					// Relate to part 1.
					//
					elseif( $node1 !== NULL )
					{
						$edge = new COntologyEdge();
						$edge->Subject( $node2B );
						$edge->Predicate( $xref_ex );
						$edge->Object( $node1 );
						$edge->Insert( $theDatabase );
					}
					
					//
					// Cross reference part 2T.
					//
					if( $node2T !== NULL )
					{
						$edge = new COntologyEdge();
						$edge->Subject( $node2B );
						$edge->Predicate( $xref );
						$edge->Object( $node2T );
						$edge->Insert( $theDatabase );
					
					} // Has part 2T.
				
				} // Has part 2B.
				
				//
				// Handle part 2T.
				//
				if( $node2T !== NULL )
				{
					//
					// Relate to part 3.
					//
					if( $node3 !== NULL )
					{
						$edge = new COntologyEdge();
						$edge->Subject( $node2T );
						$edge->Predicate( $xref_ex );
						$edge->Object( $node3 );
						$edge->Insert( $theDatabase );
					}
					
					//
					// Relate to part 1.
					//
					elseif( $node1 !== NULL )
					{
						$edge = new COntologyEdge();
						$edge->Subject( $node2T );
						$edge->Predicate( $xref_ex );
						$edge->Object( $node1 );
						$edge->Insert( $theDatabase );
					}
					
					//
					// Cross reference part 2B.
					//
					if( $node2T !== NULL )
					{
						$edge = new COntologyEdge();
						$edge->Subject( $node2T );
						$edge->Predicate( $xref );
						$edge->Object( $node2B );
						$edge->Insert( $theDatabase );
					
					} // Has part 2B.
				
				} // Has part 2T.
			
			} // Iterating entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );												// !@! ==>
		
	} // _ISOParse639XML.

	 
	/*===================================================================================
	 *	_ISOParse31661XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 3166-1 XML file</h4>
	 *
	 * This method will parse the XML ISO 3166-1 file.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:3166:alpha-3</tt>: Alpha 3 code [<tt>alpha_3_code</tt>].
	 *	<li><tt>ISO:3166:alpha-2</tt>: Alpha 2 code [<tt>alpha_2_code</tt>].
	 *	<li><tt>ISO:3166:numeric</tt>: Numeric code [<tt>numeric_code</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: Label <tt>name</tt> [<tt>name</tt>].
	 *	<li><tt>{@link kTAG_DEFINITION}/tt>: Definition [<tt>official_name</tt>].
	 *	<li><tt>ISO:3166:common_name</tt>: Common name [<tt>common_name</tt>].
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse31661XML( CDatabase $theDatabase )
	{
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_3166.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 3166 1\n" );
			
			//
			// Resolve namespaces.
			//
			$ns3 = COntologyTerm::Resolve( $theDatabase, 'alpha-3', 'ISO:3166:1', TRUE );
			$ns2 = COntologyTerm::Resolve( $theDatabase, 'alpha-2', 'ISO:3166:1', TRUE );
			$nsN = COntologyTerm::Resolve( $theDatabase, 'numeric', 'ISO:3166:1', TRUE );
			
			//
			// Resolve tags.
			//
			$tag_common_name
				= COntologyTag::Resolve( $theDatabase, 'ISO:3166:common_name', TRUE );
			
			//
			// Resolve Parents.
			//
			$par3 = COntologyMasterVertex::Resolve( $theDatabase, $ns3, TRUE );
			$par2 = COntologyMasterVertex::Resolve( $theDatabase, $ns2, TRUE );
			$parN = COntologyMasterVertex::Resolve( $theDatabase, $nsN, TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_3166_entry'} as $record )
			{
				//
				// Check identifier.
				//
				if( $record[ 'alpha_3_code' ] !== NULL )
				{
					//
					// Save local identifier.
					//
					$id = (string) $record[ 'alpha_3_code' ];
					
					//
					// Resolve term.
					//
					if( COntologyTerm::Resolve( $theDatabase, $id, $ns3 ) === NULL )
					{
						//
						// Instantiate part 3 term.
						//
						$term3 = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$term3->NS( $ns3 );
						$term3->LID( $id );
						$term3->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'name' ] !== NULL )
							$term3->Label( 'en',
										   (string) $record[ 'name' ] );
						if( $record[ 'official_name' ] !== NULL )
							$term3->Definition( 'en',
												(string) $record[ 'official_name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$term3,
							kISO_FILE_3166,
							array( kTAG_LABEL, kTAG_DEFINITION,
								   (string) $tag_common_name->NID() ) );
						
						//
						// Save term.
						//
						$term3->Insert( $theDatabase );
						
						//
						// Create node.
						//
						$node3 = new COntologyMasterVertex();
						$node3->PID( $term3->GID() );
						$node3->Kind( kKIND_ENUMERATION, TRUE );
						$node3->Term( $term3 );

						//
						// Load custom language string attributes.
						//
						if( $record[ 'common_name' ] !== NULL )
							$node3[ $tag_common_name->NID() ]
								= array( 'en' => (string) $record[ 'common_name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$node3,
							kISO_FILE_3166,
							array( (string) $tag_common_name->NID() ) );
						
						//
						// Save node.
						//
						$node3->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node3 );
						$edge->Predicate( $enum_of );
						$edge->Object( $par3 );
						$edge->Insert( $theDatabase );
						
						//
						// Handle alpha-2.
						//
						if( $record[ 'alpha_2_code' ] !== NULL )
						{
							//
							// Check alpha-2 term.
							//
							if( ($term2 = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'alpha_2_code' ], $ns2 ))
										=== NULL )
							{
								//
								// Instantiate alpha-2 term.
								//
								$term2 = new COntologyTerm();
								$term2->NS( $ns2 );
								$term2->LID( (string) $record[ 'alpha_2_code' ] );
								if( $term3->offsetExists( kTAG_LABEL ) )
									$term2->offsetSet( kTAG_LABEL,
													   $term3->offsetGet( kTAG_LABEL ) );
								$term2->Kind( kKIND_ENUMERATION, TRUE );
								$term2->Term( $term3 );
								$term2->Insert( $theDatabase );
								
								//
								// Instantiate alpha-2 node.
								//
								$node2 = new COntologyMasterVertex();
								$node2->Kind( kKIND_ENUMERATION, TRUE );
								$node2->Term( $term2 );
								$node2->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $node2 );
								$edge->Predicate( $enum_of );
								$edge->Object( $par2 );
								$edge->Insert( $theDatabase );
							
							} // New alpha-2.
							
							//
							// Resolve alpha-2 node.
							//
							else
								$node2
									= COntologyMasterVertex::Resolve(
										$theDatabase, $term2->NID() );
							
							//
							// Relate to alpha-3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node2 );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node3 );
							$edge->Insert( $theDatabase );
							
						} // Provided alpha-2.
						
						else
							$node2 = NULL;
						
						//
						// Handle numeric.
						//
						if( $record[ 'numeric_code' ] !== NULL )
						{
							//
							// Check numeric term.
							//
							if( ($termN = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'numeric_code' ], $nsN ))
										=== NULL )
							{
								//
								// Instantiate numeric term.
								//
								$termN = new COntologyTerm();
								$termN->NS( $nsN );
								$termN->LID( (string) $record[ 'numeric_code' ] );
								if( $term3->offsetExists( kTAG_LABEL ) )
									$termN->offsetSet( kTAG_LABEL,
													   $term3->offsetGet( kTAG_LABEL ) );
								$termN->Kind( kKIND_ENUMERATION, TRUE );
								$termN->Term( $term3 );
								$termN->Insert( $theDatabase );
								
								//
								// Instantiate numeric node.
								//
								$nodeN = new COntologyMasterVertex();
								$nodeN->Kind( kKIND_ENUMERATION, TRUE );
								$nodeN->Term( $termN );
								$nodeN->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $enum_of );
								$edge->Object( $parN );
								$edge->Insert( $theDatabase );
							
							} // New numeric.
							
							//
							// Resolve numeric node.
							//
							else
								$nodeN
									= COntologyMasterVertex::Resolve(
										$theDatabase, $termN->NID() );
							
							//
							// Relate to alpha-3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $nodeN );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node3 );
							$edge->Insert( $theDatabase );
							
						} // Provided numeric.
						
						else
							$nodeN = NULL;
						
						//
						// Handle alpha-2 cross references.
						//
						if( $node2 !== NULL )
						{
							//
							// Cross reference alpha-2 from part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node3 );
							$edge->Predicate( $xref );
							$edge->Object( $node2 );
							$edge->Insert( $theDatabase );
						
							//
							// Cross reference alpha-2 from numeric.
							//
							if( $nodeN !== NULL )
							{
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $xref );
								$edge->Object( $node2 );
								$edge->Insert( $theDatabase );
							
							} // Has numeric code.
						
						} // Has alpha-2 code.
						
						//
						// Handle numeric cross references.
						//
						if( $nodeN !== NULL )
						{
							//
							// Cross reference numeric from part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node3 );
							$edge->Predicate( $xref );
							$edge->Object( $nodeN );
							$edge->Insert( $theDatabase );
						
							//
							// Cross reference numeric from alpha-2.
							//
							if( $node2 !== NULL )
							{
								$edge = new COntologyEdge();
								$edge->Subject( $node2 );
								$edge->Predicate( $xref );
								$edge->Object( $nodeN );
								$edge->Insert( $theDatabase );
							
							} // Has alpha-2 code.
						
						} // Has numeric code.
					
					} // New record.
					
					elseif( kOPTION_VERBOSE )
						echo( "          ! $id\n" );
				
				} // Has record identifier.
			
			} // Iterating entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );												// !@! ==>
		
	} // _ISOParse31661XML.

	 
	/*===================================================================================
	 *	_ISOParse31663XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 3166-3 XML file</h4>
	 *
	 * This method will parse the XML ISO 3166-3 file.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:3166:1:alpha-3</tt>: Alpha 3 code [<tt>alpha_3_code</tt>].
	 *	<li><tt>ISO:3166:1:alpha-4</tt>: Alpha 4 code [<tt>alpha_4_code</tt>].
	 *	<li><tt>ISO:3166:1:numeric</tt>: Numeric code [<tt>numeric_code</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: Label <tt>name</tt> [<tt>names</tt>].
	 *	<li><tt>{@link kTAG_DEFINITION}/tt>: Definition [<tt>comment</tt>].
	 *	<li><tt>ISO:attributes:date_withdrawn</tt>: Date withdrawn
	 *		[<tt>date_withdrawn</tt>].
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse31663XML( CDatabase $theDatabase )
	{
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_3166.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 3166 3\n" );
			
			//
			// Resolve namespaces.
			//
			$ns3 = COntologyTerm::Resolve( $theDatabase, 'alpha-3', 'ISO:3166:3', TRUE );
			$ns4 = COntologyTerm::Resolve( $theDatabase, 'alpha-4', 'ISO:3166:3', TRUE );
			$nsN = COntologyTerm::Resolve( $theDatabase, 'numeric', 'ISO:3166:3', TRUE );
			
			//
			// Resolve Parents.
			//
			$par3 = COntologyMasterVertex::Resolve( $theDatabase, $ns3, TRUE );
			$par4 = COntologyMasterVertex::Resolve( $theDatabase, $ns4, TRUE );
			$parN = COntologyMasterVertex::Resolve( $theDatabase, $nsN, TRUE );
			
			//
			// Resolve tags.
			//
			$tag_date_withdrawn =
				COntologyTag::Resolve( $theDatabase, 'ISO:attributes:date_withdrawn', TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_3166_3_entry'} as $record )
			{
				//
				// Check identifier.
				//
				if( $record[ 'alpha_3_code' ] !== NULL )
				{
					//
					// Save local identifier.
					//
					$id = (string) $record[ 'alpha_3_code' ];
					
					//
					// Resolve term.
					//
					if( COntologyTerm::Resolve( $theDatabase, $id, $ns3 ) === NULL )
					{
						//
						// Instantiate part 3 term.
						//
						$term3 = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$term3->NS( $ns3 );
						$term3->LID( $id );
						$term3->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'name' ] !== NULL )
							$term3->Label( 'en',
										   (string) $record[ 'name' ] );
						if( $record[ 'names' ] !== NULL )
							$term3->Label( 'en',
										   (string) $record[ 'names' ] );
						if( $record[ 'comment' ] !== NULL )
							$term3->Definition( 'en',
												(string) $record[ 'comment' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$term3,
							kISO_FILE_3166,
							array( kTAG_LABEL, kTAG_DEFINITION ) );
						
						//
						// Save term.
						//
						$term3->Insert( $theDatabase );
						
						//
						// Create node.
						//
						$node3 = new COntologyMasterVertex();
						$node3->PID( $term3->GID() );
						$node3->Kind( kKIND_ENUMERATION, TRUE );
						$node3->Term( $term3 );
						
						//
						// Set custom tags.
						//
						if( $record[ 'date_withdrawn' ] !== NULL )
							$node3[ $tag_date_withdrawn->NID() ]
								= (string) $record[ 'date_withdrawn' ];
						
						//
						// Save node.
						//
						$node3->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node3 );
						$edge->Predicate( $enum_of );
						$edge->Object( $par3 );
						$edge->Insert( $theDatabase );
						
						//
						// Handle alpha-4.
						//
						if( $record[ 'alpha_4_code' ] !== NULL )
						{
							//
							// Check alpha-4 term.
							//
							if( ($term4 = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'alpha_4_code' ], $ns4 ))
										=== NULL )
							{
								//
								// Instantiate alpha-4 term.
								//
								$term4 = new COntologyTerm();
								$term4->NS( $ns4 );
								$term4->LID( (string) $record[ 'alpha_4_code' ] );
								if( $term3->offsetExists( kTAG_LABEL ) )
									$term4->offsetSet( kTAG_LABEL,
													   $term3->offsetGet( kTAG_LABEL ) );
								$term4->Kind( kKIND_ENUMERATION, TRUE );
								$term4->Term( $term3 );
								$term4->Insert( $theDatabase );
								
								//
								// Instantiate alpha-4 node.
								//
								$node4 = new COntologyMasterVertex();
								$node4->Kind( kKIND_ENUMERATION, TRUE );
								$node4->Term( $term4 );
								$node4->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $node4 );
								$edge->Predicate( $enum_of );
								$edge->Object( $par4 );
								$edge->Insert( $theDatabase );
							
							} // New alpha-4.
							
							//
							// Resolve alpha-4 node.
							//
							else
								$node4
									= COntologyMasterVertex::Resolve(
										$theDatabase, $term4->NID() );
							
							//
							// Relate to alpha-3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node4 );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node3 );
							$edge->Insert( $theDatabase );
							
						} // Provided alpha-4.
						
						else
							$node4 = NULL;
						
						//
						// Handle numeric.
						//
						if( $record[ 'numeric_code' ] !== NULL )
						{
							//
							// Check numeric term.
							//
							if( ($termN = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'numeric_code' ], $nsN ))
										=== NULL )
							{
								//
								// Instantiate numeric term.
								//
								$termN = new COntologyTerm();
								$termN->NS( $nsN );
								$termN->LID( (string) $record[ 'numeric_code' ] );
								if( $term3->offsetExists( kTAG_LABEL ) )
									$termN->offsetSet( kTAG_LABEL,
													   $term3->offsetGet( kTAG_LABEL ) );
								$termN->Kind( kKIND_ENUMERATION, TRUE );
								$termN->Term( $term3 );
								$termN->Insert( $theDatabase );
								
								//
								// Instantiate numeric node.
								//
								$nodeN = new COntologyMasterVertex();
								$nodeN->Kind( kKIND_ENUMERATION, TRUE );
								$nodeN->Term( $termN );
								$nodeN->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $enum_of );
								$edge->Object( $parN );
								$edge->Insert( $theDatabase );
							
							} // New numeric.
							
							//
							// Resolve numeric node.
							//
							else
								$nodeN
									= COntologyMasterVertex::Resolve(
										$theDatabase, $termN->NID() );
							
							//
							// Relate to alpha-3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $nodeN );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node3 );
							$edge->Insert( $theDatabase );
							
						} // Provided numeric.
						
						else
							$nodeN = NULL;
						
						//
						// Handle alpha-4 cross references.
						//
						if( $node4 !== NULL )
						{
							//
							// Cross reference alpha-4 from part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node3 );
							$edge->Predicate( $xref );
							$edge->Object( $node4 );
							$edge->Insert( $theDatabase );
						
							//
							// Cross reference alpha-4 from numeric.
							//
							if( $nodeN !== NULL )
							{
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $xref );
								$edge->Object( $node4 );
								$edge->Insert( $theDatabase );
							
							} // Has numeric code.
						
						} // Has alpha-4 code.
						
						//
						// Handle numeric cross references.
						//
						if( $nodeN !== NULL )
						{
							//
							// Cross reference numeric from part 3.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $node3 );
							$edge->Predicate( $xref );
							$edge->Object( $nodeN );
							$edge->Insert( $theDatabase );
						
							//
							// Cross reference numeric from alpha-4.
							//
							if( $node4 !== NULL )
							{
								$edge = new COntologyEdge();
								$edge->Subject( $node4 );
								$edge->Predicate( $xref );
								$edge->Object( $nodeN );
								$edge->Insert( $theDatabase );
							
							} // Has alpha-4 code.
						
						} // Has numeric code.
					
					} // New record.
					
					elseif( kOPTION_VERBOSE )
						echo( "          ! $id\n" );
				
				} // Has record identifier.
			
			} // Iterating entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );												// !@! ==>
		
	} // _ISOParse31663XML.

	 
	/*===================================================================================
	 *	_ISOParse31662XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 3166-2 XML file</h4>
	 *
	 * This method will parse the XML ISO 3166-2 file.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:3166:1:alpha-2</tt>: Alpha 2 code [<tt>iso_3166_country[code]</tt>].
	 *	<li><tt>ISO:3166:2:type</tt>: Type [<tt>iso_3166_subset[type]</tt>].
	 *	<li><tt>ISO:3166:2</tt>: Type [<tt>iso_3166_subset[type]</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: Label <tt>name</tt> [<tt>name</tt>].
	 *	<li><tt>{@link kTAG_DEFINITION}/tt>: Definition [<tt>official_name</tt>].
	 *	<li><tt>ISO:3166:common_name</tt>: Common name [<tt>common_name</tt>].
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse31662XML( CDatabase $theDatabase )
	{
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_3166_2.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 3166 2\n" );
			
			//
			// Resolve namespaces.
			//
			$ns = COntologyTerm::Resolve( $theDatabase, '2', 'ISO:3166', TRUE );
			$ns2 = COntologyTerm::Resolve( $theDatabase, 'alpha-2', 'ISO:3166:1', TRUE );
			
			//
			// Resolve tags.
			//
			$tag_type
				= COntologyTag::Resolve( $theDatabase, 'ISO:3166:2:type', TRUE );
			
			//
			// Resolve Parents.
			//
			$par = COntologyMasterVertex::Resolve( $theDatabase, 'ISO:3166:2', TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$subset_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_SUBSET_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_3166_country'} as $rec_country )
			{
				//
				// Load country.
				//
				if( $rec_country[ 'code' ] !== NULL )
				{
					//
					// Init country cache.
					//
					$cache = Array();
					
					//
					// Save country code.
					//
					$country = (string) $rec_country[ 'code' ];
					
					//
					// Resolve master country.
					//
					$term = COntologyTerm::Resolve( $theDatabase, $country, $ns2, TRUE );
					if( $term->offsetExists( kTAG_TERM ) )
						$term = $term->offsetGet( kTAG_TERM );
					$country_node
						= COntologyMasterNode::Resolve(
							$theDatabase, $term, TRUE );
					
					//
					// Iterate subset types.
					//
					foreach( $rec_country->{'iso_3166_subset'} as $rec_subset )
					{
						//
						// Get subset type.
						//
						if( $rec_subset[ 'type' ] !== NULL )
						{
							//
							// Save subset type.
							//
							$type = (string) $rec_subset[ 'type' ];
							
							//
							// Iterate entries.
							//
							foreach( $rec_subset->{'iso_3166_2_entry'} as $rec_entry )
							{
								//
								// Get entry code.
								//
								if( $rec_entry[ 'code' ] !== NULL )
								{
									//
									// Save entry code.
									//
									$code = (string) $rec_entry[ 'code' ];
									
									//
									// Instantiate term.
									//
									$term = new COntologyTerm();
									
									//
									// Load default attributes.
									//
									$term->NS( $ns );
									$term->LID( $code );
									$term->Kind( kKIND_ENUMERATION, TRUE );
									
									//
									// Load custom language string attributes.
									//
									if( $rec_entry[ 'name' ] !== NULL )
									{
										//
										// Load label.
										//
										$term->Label( NULL, (string) $rec_entry[ 'name' ] );
										
										//
										// Collect language strings.
										//
										$this->_ISOCollectLanguageStrings(
											$term,
											kISO_FILE_3166_2,
											array( kTAG_LABEL ) );
									
									} // Has label.
									
									//
									// Save term.
									//
									$term->Insert( $theDatabase );
									
									//
									// Create node.
									//
									$node = new COntologyMasterVertex();
									$node->Kind( kKIND_ENUMERATION, TRUE );
									$node->Category( $type, TRUE );
									$node->Term( $term );
									$node->offsetSet( $tag_type->NID(), $type );
									$node->Insert( $theDatabase );
									
									//
									// Cache.
									//
									$cache[ substr( $code, 3 ) ] = $node;
									
									//
									// Determine parent.
									//
									if( $rec_entry[ 'parent' ] !== NULL )
									{
										if( array_key_exists(
											(string) $rec_entry[ 'parent' ],
											$cache ) )
										{
											//
											// Enumerate to parent.
											//
											$edge = new COntologyEdge();
											$edge->Subject( $node );
											$edge->Predicate( $enum_of );
											$edge->Object(
												$cache[ (string) $rec_entry[ 'parent' ] ] );
											$edge->Insert( $theDatabase );

											//
											// Subset to parent.
											//
											$edge = new COntologyEdge();
											$edge->Subject( $node );
											$edge->Predicate( $subset_of );
											$edge->Object(
												$cache[ (string) $rec_entry[ 'parent' ] ] );
											$edge->Insert( $theDatabase );
										}
										else
											throw new Exception
												( "Parent not found "
												 ."[$file][$country][$type][$code]",
												  kERROR_STATE );				// !@! ==>
									}
									else
									{
										//
										// Enumerate to parent.
										//
										$edge = new COntologyEdge();
										$edge->Subject( $node );
										$edge->Predicate( $enum_of );
										$edge->Object( $par );
										$edge->Insert( $theDatabase );

										//
										// Subset to parent.
										//
										$edge = new COntologyEdge();
										$edge->Subject( $node );
										$edge->Predicate( $subset_of );
										$edge->Object( $country_node );
										$edge->Insert( $theDatabase );
									}
									
								} // Has entry code.
								
								else
									throw new Exception
										( "Missing entry code [$file][$country][$type]",
										  kERROR_STATE );						// !@! ==>
							
							} // Iterating entries.
						
						} // Has subset type.
						
						else
							throw new Exception
								( "Missing type code [$file][$country]",
								  kERROR_STATE );								// !@! ==>
					
					} // Iterating subset types.
				
				} // Refers to country.
				
				else
					throw new Exception
						( "Missing country code [$file]",
						  kERROR_STATE );										// !@! ==>
			
			} // Iterating entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );												// !@! ==>
		
	} // _ISOParse31662XML.

	 
	/*===================================================================================
	 *	_ISOParse4217XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 4217 XML file</h4>
	 *
	 * This method will parse the XML ISO 4217 file.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:4217:A</tt>: Active  [<tt>letter_code</tt>].
	 *	<li><tt>ISO:4217:H</tt>: Historic  [<tt>letter_code</tt>].
	 *	<li><tt>ISO:4217:A</tt>: Active  [<tt>numeric_code</tt>].
	 *	<li><tt>ISO:4217:H</tt>: Historic  [<tt>numeric_code</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: [<tt>currency_name</tt>].
	 *	<li><tt>ISO:attributes:date_withdrawn</tt>: Date withdrawn [<tt>date_withdrawn</tt>].
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse4217XML( CDatabase $theDatabase )
	{
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_4217.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 4217\n" );
			
			//
			// Resolve namespaces.
			//
			$nsA = COntologyTerm::Resolve( $theDatabase, 'A', 'ISO:4217', TRUE );
			$nsH = COntologyTerm::Resolve( $theDatabase, 'H', 'ISO:4217', TRUE );
			
			//
			// Resolve tags.
			//
			$tag_date_withdrawn =
				COntologyTag::Resolve( $theDatabase, 'ISO:attributes:date_withdrawn', TRUE );
			
			//
			// Resolve Parents.
			//
			$parA = COntologyMasterVertex::Resolve( $theDatabase, $nsA, TRUE );
			$parH = COntologyMasterVertex::Resolve( $theDatabase, $nsH, TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate active entries.
			//
			foreach( $xml->{'iso_4217_entry'} as $record )
			{
				//
				// Check identifier.
				//
				if( $record[ 'letter_code' ] !== NULL )
				{
					//
					// Save local identifier.
					//
					$id = (string) $record[ 'letter_code' ];
					
					//
					// Resolve active letter code term.
					//
					if( COntologyTerm::Resolve( $theDatabase, $id, $nsA ) === NULL )
					{
						//
						// Instantiate letter code term.
						//
						$termL = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$termL->NS( $nsA );
						$termL->LID( $id );
						$termL->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'currency_name' ] !== NULL )
							$termL->Label( 'en',
										   (string) $record[ 'currency_name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$termL,
							kISO_FILE_4217,
							array( kTAG_LABEL ) );
						
						//
						// Save term.
						//
						$termL->Insert( $theDatabase );
						
						//
						// Create node.
						//
						$nodeL = new COntologyMasterVertex();
						$nodeL->Kind( kKIND_ENUMERATION, TRUE );
						$nodeL->Term( $termL );
						$nodeL->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $nodeL );
						$edge->Predicate( $enum_of );
						$edge->Object( $parA );
						$edge->Insert( $theDatabase );
						
						//
						// Handle numeric.
						//
						if( $record[ 'numeric_code' ] !== NULL )
						{
							//
							// Check numeric term.
							//
							if( ($termN = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'numeric_code' ], $nsA ))
										=== NULL )
							{
								//
								// Instantiate numeric term.
								//
								$termN = new COntologyTerm();
								$termN->NS( $nsA );
								$termN->LID( (string) $record[ 'numeric_code' ] );
								if( $termL->offsetExists( kTAG_LABEL ) )
									$termN->offsetSet( kTAG_LABEL,
													   $termL->offsetGet( kTAG_LABEL ) );
								$termN->Kind( kKIND_ENUMERATION, TRUE );
								$termN->Term( $termL );
								$termN->Insert( $theDatabase );
								
								//
								// Instantiate numeric node.
								//
								$nodeN = new COntologyMasterVertex();
								$nodeN->Kind( kKIND_ENUMERATION, TRUE );
								$nodeN->Term( $termN );
								$nodeN->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $enum_of );
								$edge->Object( $parA );
								$edge->Insert( $theDatabase );
							
							} // New numeric.
							
							//
							// Resolve numeric node.
							//
							else
								$nodeN
									= COntologyMasterVertex::Resolve(
										$theDatabase, $termN->NID() );
							
							//
							// Relate to letter code.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $nodeN );
							$edge->Predicate( $xref_ex );
							$edge->Object( $nodeL );
							$edge->Insert( $theDatabase );
							
						} // Provided numeric.
						
						else
							$nodeN = NULL;
					
					} // New record.
					
					elseif( kOPTION_VERBOSE )
						echo( "          ! $id\n" );
				
				} // Has record identifier.
			
			} // Iterating active entries.
			
			//
			// Iterate historic entries.
			//
			foreach( $xml->{'historic_iso_4217_entry'} as $record )
			{
				//
				// Check identifier.
				//
				if( $record[ 'letter_code' ] !== NULL )
				{
					//
					// Save local identifier.
					//
					$id = (string) $record[ 'letter_code' ];
					
					//
					// Resolve active letter code term.
					//
					if( COntologyTerm::Resolve( $theDatabase, $id, $nsH ) === NULL )
					{
						//
						// Instantiate letter code term.
						//
						$termL = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$termL->NS( $nsH );
						$termL->LID( $id );
						$termL->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'currency_name' ] !== NULL )
							$termL->Label( 'en',
										   (string) $record[ 'currency_name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$termL,
							kISO_FILE_3166,
							array( kTAG_LABEL ) );
						
						//
						// Save term.
						//
						$termL->Insert( $theDatabase );
						
						//
						// Create node.
						//
						$nodeL = new COntologyMasterVertex();
						$nodeL->Kind( kKIND_ENUMERATION, TRUE );
						$nodeL->Term( $termL );
						if( $record[ 'date_withdrawn' ] !== NULL )
							$nodeL->offsetSet( $tag_date_withdrawn->NID(),
											   (string) $record[ 'date_withdrawn' ] );
						$nodeL->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $nodeL );
						$edge->Predicate( $enum_of );
						$edge->Object( $parH );
						$edge->Insert( $theDatabase );
						
						//
						// Handle numeric.
						//
						if( $record[ 'numeric_code' ] !== NULL )
						{
							//
							// Check numeric term.
							//
							if( ($termN = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'numeric_code' ], $nsH ))
										=== NULL )
							{
								//
								// Instantiate numeric term.
								//
								$termN = new COntologyTerm();
								$termN->NS( $nsH );
								$termN->LID( (string) $record[ 'numeric_code' ] );
								if( $termL->offsetExists( kTAG_LABEL ) )
									$termN->offsetSet( kTAG_LABEL,
													   $termL->offsetGet( kTAG_LABEL ) );
								$termN->Kind( kKIND_ENUMERATION, TRUE );
								$termN->Term( $termL );
								$termN->Insert( $theDatabase );
								
								//
								// Instantiate numeric node.
								//
								$nodeN = new COntologyMasterVertex();
								$nodeN->Kind( kKIND_ENUMERATION, TRUE );
								$nodeN->Term( $termN );
								if( $record[ 'date_withdrawn' ] !== NULL )
									$nodeN->offsetSet( $tag_date_withdrawn->NID(),
													   (string) $record
													   		[ 'date_withdrawn' ] );
								$nodeN->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $enum_of );
								$edge->Object( $parH );
								$edge->Insert( $theDatabase );
							
							} // New numeric.
							
							//
							// Resolve numeric node.
							//
							else
								$nodeN
									= COntologyMasterVertex::Resolve(
										$theDatabase, $termN->NID() );
							
							//
							// Relate to letter code.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $nodeN );
							$edge->Predicate( $xref_ex );
							$edge->Object( $nodeL );
							$edge->Insert( $theDatabase );
							
						} // Provided numeric.
						
						else
							$nodeN = NULL;
					
					} // New record.
					
					elseif( kOPTION_VERBOSE )
						echo( "          ! $id\n" );
				
				} // Has record identifier.
			
			} // Iterating historic entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );											// !@! ==>
		
	} // _ISOParse4217XML.

	 
	/*===================================================================================
	 *	_ISOParse15924XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 15924 XML file</h4>
	 *
	 * This method will parse the XML ISO 15924 file.
	 *
	 * The method will load the following attributes:
	 *
	 * <ul>
	 *	<li><tt>ISO:15924:alpha-4</tt>: Alpha-4 code [<tt>alpha_4_code</tt>].
	 *	<li><tt>ISO:15924:numeric</tt>: Alpha-4 code [<tt>numeric_code</tt>].
	 *	<li><tt>{@link kTAG_LABEL}/tt>: [<tt>name</tt>].
	 * </ul>
	 *
	 * @param CDatabase				$theDatabase		Database container.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ISOParse15924XML( CDatabase $theDatabase )
	{
		$file = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_15924.'.xml';
		$xml = simplexml_load_file( $file  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "        • ISO 15924\n" );
			
			//
			// Resolve namespaces.
			//
			$ns4 = COntologyTerm::Resolve( $theDatabase, 'alpha-4', 'ISO:15924', TRUE );
			$nsN = COntologyTerm::Resolve( $theDatabase, 'numeric', 'ISO:15924', TRUE );
			
			//
			// Resolve Parents.
			//
			$par4 = COntologyMasterVertex::Resolve( $theDatabase, $ns4, TRUE );
			$parN = COntologyMasterVertex::Resolve( $theDatabase, $nsN, TRUE );
			
			//
			// Resolve predicates.
			//
			$xref
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF, NULL, TRUE );
			$enum_of
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_ENUM_OF, NULL, TRUE );
			$xref_ex
				= COntologyTerm::Resolve(
					$theDatabase, kPREDICATE_XREF_EXACT, NULL, TRUE );
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_15924_entry'} as $record )
			{
				//
				// Check identifier.
				//
				if( $record[ 'alpha_4_code' ] !== NULL )
				{
					//
					// Save local identifier.
					//
					$id = (string) $record[ 'alpha_4_code' ];
					
					//
					// Resolve term.
					//
					if( COntologyTerm::Resolve( $theDatabase, $id, $ns4 ) === NULL )
					{
						//
						// Instantiate part 3 term.
						//
						$term4 = new COntologyTerm();
						
						//
						// Load default attributes.
						//
						$term4->NS( $ns4 );
						$term4->LID( $id );
						$term4->Kind( kKIND_ENUMERATION, TRUE );
						
						//
						// Load language string attributes.
						//
						if( $record[ 'name' ] !== NULL )
							$term4->Label( 'en',
										   (string) $record[ 'name' ] );
						
						//
						// Collect language strings.
						//
						$this->_ISOCollectLanguageStrings(
							$term4,
							kISO_FILE_15924,
							array( kTAG_LABEL ) );
						
						//
						// Save term.
						//
						$term4->Insert( $theDatabase );
						
						//
						// Create node.
						//
						$node4 = new COntologyMasterVertex();
						$node4->Kind( kKIND_ENUMERATION, TRUE );
						$node4->Term( $term4 );
						$node4->Insert( $theDatabase );
						
						//
						// Relate to parent.
						//
						$edge = new COntologyEdge();
						$edge->Subject( $node4 );
						$edge->Predicate( $enum_of );
						$edge->Object( $par4 );
						$edge->Insert( $theDatabase );
						
						//
						// Handle numeric.
						//
						if( $record[ 'numeric_code' ] !== NULL )
						{
							//
							// Check numeric term.
							//
							if( ($termN = COntologyTerm::Resolve(
									$theDatabase, (string) $record[ 'numeric_code' ], $nsN ))
										=== NULL )
							{
								//
								// Instantiate numeric term.
								//
								$termN = new COntologyTerm();
								$termN->NS( $nsN );
								$termN->LID( (string) $record[ 'numeric_code' ] );
								if( $term4->offsetExists( kTAG_LABEL ) )
									$termN->offsetSet( kTAG_LABEL,
													   $term4->offsetGet( kTAG_LABEL ) );
								$termN->Kind( kKIND_ENUMERATION, TRUE );
								$termN->Term( $term4 );
								$termN->Insert( $theDatabase );
								
								//
								// Instantiate numeric node.
								//
								$nodeN = new COntologyMasterVertex();
								$nodeN->Kind( kKIND_ENUMERATION, TRUE );
								$nodeN->Term( $termN );
								$nodeN->Insert( $theDatabase );
								
								//
								// Relate to parent.
								//
								$edge = new COntologyEdge();
								$edge->Subject( $nodeN );
								$edge->Predicate( $enum_of );
								$edge->Object( $parN );
								$edge->Insert( $theDatabase );
							
							} // New numeric.
							
							//
							// Resolve numeric node.
							//
							else
								$nodeN
									= COntologyMasterVertex::Resolve(
										$theDatabase, $termN->NID() );
							
							//
							// Relate to alpha-4.
							//
							$edge = new COntologyEdge();
							$edge->Subject( $nodeN );
							$edge->Predicate( $xref_ex );
							$edge->Object( $node4 );
							$edge->Insert( $theDatabase );
							
						} // Provided numeric.
						
						else
							$nodeN = NULL;
					
					} // New record.
					
					elseif( kOPTION_VERBOSE )
						echo( "          ! $id\n" );
				
				} // Has record identifier.
			
			} // Iterating entries.
		
		} // Loaded file.
		
		else
			throw new Exception
				( "Unable to load XML file [$file]",
				  kERROR_STATE );												// !@! ==>
		
	} // _ISOParse15924XML.

	 
	/*===================================================================================
	 *	_ISOCollectLanguageStrings														*
	 *==================================================================================*/

	/**
	 * <h4>Collect language strings</h4>
	 *
	 * This method will iterate all language files and add the corresponding language
	 * strings to the provided object.
	 *
	 * The method expects two parameters: the object to be updated and an array of tags to
	 * be checked.
	 *
	 * @param CPersistentObject		$theObject			Object to be updated.
	 * @param string				$theFile			File body name.
	 * @param array					$theTags			List of tags to check.
	 *
	 * @access protected
	 */
	protected function _ISOCollectLanguageStrings( CPersistentObject $theObject,
																	 $theFile,
																	 $theTags )
	{
		//
		// Collect attribute references.
		//
		$attributes = Array();
		foreach( $theTags as $tag )
			$attributes[ $tag ] = $theObject->offsetGet( $tag );
		
		//
		// Iterate languages.
		//
		foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
		{
			//
			// Check language file.
			//
			$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/$theFile.serial";
			if( is_file( $file_path ) )
			{
				//
				// Instantiate keys array.
				//
				$keys = unserialize( file_get_contents( $file_path ) );
				
				//
				// Iterate attributes.
				//
				foreach( $theTags as $tag )
				{
					if( $attributes[ $tag ] !== NULL )
					{
						//
						// Determine key.
						//
						if( array_key_exists( 'en', $attributes[ $tag ] ) )
							$key = $attributes[ $tag ][ 'en' ];
						elseif( array_key_exists( 0, $attributes[ $tag ] ) )
							$key = $attributes[ $tag ][ 0 ];
						else
							continue;
						if( array_key_exists( $key, $keys ) )
							$attributes[ $tag ][ $language ] = $keys[ $key ];
					}
				}
			
			} // Language file exists.
		
		} // Iterating languages.
		
		//
		// Update object.
		//
		foreach( $theTags as $tag )
		{
			if( $attributes[ $tag ] !== NULL )
				$theObject->offsetSet( $tag, $attributes[ $tag ] );
		}
		
	} // _ISOCollectLanguageStrings.

	 

} // class COntology.


?>
