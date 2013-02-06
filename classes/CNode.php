<?php

/**
 * <i>CNode</i> class definition.
 *
 * This file contains the class definition of <b>CNode</b> which represents the ancestor of
 * all node classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/09/2012
 */

/*=======================================================================================
 *																						*
 *										CNode.php										*
 *																						*
 *======================================================================================*/

/**
 * Category trait.
 *
 * This includes the category trait definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/TCategory.php" );

/**
 * Representation trait.
 *
 * This includes the representation trait definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/TRepresentation.php" );

/**
 * Authorship trait.
 *
 * This includes the authorship trait definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/TAuthorship.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentObject.php" );

/**
 * <h4>Node object ancestor</h4>
 *
 * A node is an element of a tree or graph which is connected to other nodes through
 * edges, a node is a vertex of a relationship. This class concentrates in the core
 * features of the node, without taking into consideration the connections to other nodes.
 *
 * The class features the following default properties:
 *
 * <ul>
 *	<li><i>Term</i>: The term, <tt>{@link Term()}</tt> or the <tt>{@link kTAG_TERM}</tt>
 *		tag, is a reference to a {@link CTerm} instance which holds the static attributes
 *		of the current node. This attribute is constituted by the {@link kTAG_NID} of the
 *		referenced term and is required.
 *	<li><i>Category</i>: The category, <tt>{@link Category()}</tt> or the
 *		<tt>{@link kTAG_CATEGORY}</tt> tag, is an enumerated set of values that constitute
 *		the category or classification to which the object referred by the current node
 *		belongs to. This attribute is optional.
 *	<li><i>Kind</i>: The kind, <tt>{@link Kind()}</tt> or the <tt>{@link kTAG_KIND}</tt>
 *		tag, is an enumerated set of values that define the function of the node. This
 *		attribute is optional.
 *	<li><i>Type</i>: The type, <tt>{@link Type()}</tt> or the <tt>{@link kTAG_TYPE}</tt>
 *		tag, is an enumerated set of values that represent the type of the object defined by
 *		the current node. This attribute will be in general a combination of elements
 *		describing two main attribute categories: the data type and the cardinality. This
 *		attribute is optional.
 *	<li><i>Description</i>: The description, <tt>{@link Description()}</tt> or the
 *		<tt>{@link kTAG_DESCRIPTION}</tt> tag, represents the description or long label
 *		of the node. This attribute is constituted by an array of elements in which the
 *		value of the element represents the description string and the element key is the
 *		language code in which the description is expressed in. This attribute is optional.
 * </ul>
 *
 * The node's main property is the term, {@link kTAG_TERM}, which defines the abstract
 * concept that the node represents: a term taken by itself is an abstract concept, when it
 * is referenced from a node which is related to other nodes through predicates, this term
 * takes a different meaning, it becomes a term in context. Terms are like vocabulary, taken
 * out of context they have a generalised meaning; put in context, they take a different
 * meaning depending in what position of a term chain they are positioned. In this class,
 * terms may hold any value.
 *
 * The node also features a {@link kTAG_KIND} property which is an enumerated set
 * describing the specific type, or the specific function of the node in its chain or
 * path.
 *
 * Finally, the class features the {@link kTAG_TYPE} property which defines the data type
 * of the node or the data unit it represents, this offset is an enumerated set in which
 * two elements can reside: the data type or unit, which is required, and optionally one or
 * both {@link kTYPE_REQUIRED} and {@link kTYPE_ARRAY} which respectively indicate
 * whether the node represents a required attribute and whether the data type indicated in
 * the first element of the offset is a list or not.
 *
 * This class does not feature attributes that can represent the unique identifier of the
 * object, this means that the container is responsible of providing the primary key of the
 * object.
 *
 * Nodes can be considered {@link _IsInited()} when they have the  {@link kTAG_TERM}
 * offset set. This and the other properties can be changed at any time, none are locked
 * once the object has been committed: it is the responsibility of the caller or of derived
 * classes to implement a locking rule.
 *
 * The class features member accessor methods for the default offsets:
 *
 * <ul>
 *	<li>{@link Term()}: This method manages the node's term, {@link kTAG_TERM}.
 *	<li>{@link Kind()}: This method manages the node's kind, {@link kTAG_KIND}.
 *	<li>{@link Type()}: This method manages the node's type, {@link kTAG_TYPE}.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CNode extends CPersistentObject
{
		

/*=======================================================================================
 *																						*
 *											TRAITS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	TCategory																		*
	 *==================================================================================*/

	/**
	 * <h4>Category traits</h4>
	 *
	 * This trait provides accessor methods for the category properties of the object:
	 *
	 * <ul>
	 *	<li><tt>{@link Category()}</tt>: The <i>categories</i>, {@link kTAG_CATEGORY},
	 *		represent a set of values that constitute the category of the hosting object.
	 *	<li><tt>{@link Kind()}</tt>: The <i>kinds</i>, {@link kTAG_KIND}, represent a set of
	 *		enumerations that represent the kind of of the hosting object.
	 *	<li><tt>{@link Type()}</tt>: The <i>types</i>, {@link kTAG_TYPE}, represent a set of
	 *		enumerations that represent the type of of the hosting object.
	 * </ul>
	 */
	use TCategory;

	 
	/*===================================================================================
	 *	TRepresentation																	*
	 *==================================================================================*/

	/**
	 * <h4>Representation traits</h4>
	 *
	 * This trait provides accessor methods for the attributes that define how a property
	 * is displayed and how this property is validated, this set of accessor methods should
	 * only be used by nodes which represent a measurable property and have a data type:
	 *
	 * <ul>
	 *	<li><tt>{@link Input()}</tt>: The <i>input</i>, {@link kTAG_INPUT}, represents a set
	 *		of values which list the suggested or preferred control types that should be
	 *		used to display and modify an object property.
	 *	<li><tt>{@link Pattern()}</tt>: The <i>pattern</i>, {@link kTAG_PATTERN},
	 *		represents a regular expression that can be used to validate the input of an
	 *		attribute's value.
	 *	<li><tt>{@link Length()}</tt>: The <i>length</i>, {@link kTAG_LENGTH}, represents
	 *		the maximum number of characters a value may hold.
	 *	<li><tt>{@link LowerBound()}</tt>: The <i>lower bound</i>, {@link kTAG_MIN_VAL},
	 *		represents the lowest limit a range value may take.
	 *	<li><tt>{@link UpperBound()}</tt>: The <i>upper bound</i>, {@link kTAG_MAX_VAL},
	 *		represents the highest limit a range value may take.
	 *	<li><tt>{@link Example()}</tt>: The <i>examples</i>, {@link kTAG_EXAMPLES},
	 *		represents a list of values that can be used as examples which follow a set of
	 *		validation rules.
	 * </ul>
	 */
	use TRepresentation;

	 
	/*===================================================================================
	 *	TAuthorship																		*
	 *==================================================================================*/

	/**
	 * <h4>Authorship traits</h4>
	 *
	 * This trait implements a collection of accessor methods covering the set of
	 * qualification attributes which illustrate authorship and other general information:
	 *
	 * <ul>
	 *	<li><tt>{@link Author()}</tt>: The <i>authors</i>, {@link kTAG_AUTHORS}, represents
	 *		a list of author names.
	 *	<li><tt>{@link Acknowledgments()}</tt>: The <i>acknowledgments</i>,
	 *		{@link kTAG_ACKNOWLEDGMENTS}, is a string containing acknowledgments.
	 *	<li><tt>{@link Bibliography()}</tt>: The <i>bibliography</i>,
	 *		{@link kTAG_BIBLIOGRAPHY}, is a string containing bibliographic references.
	 *	<li><tt>{@link Notes()}</tt>: The <i>notes</i>, {@link kTAG_NOTES}, is an array of
	 *		strings expressed in different languages.
	 * </ul>
	 */
	use TAuthorship;
		


/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return object name</h4>
	 *
	 * This method should return the current object's name which should represent the unique
	 * identifier of the object.
	 *
	 * By default we return the string representation of the term, {@link kTAG_TERM}.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()
	{
		//
		// Check term.
		//
		if( $this->offsetExists( kTAG_TERM ) )
			return (string) $this->offsetGet( kTAG_TERM );							// ==>
		
		//
		// Yes, I know...
		//
		return NULL;																// ==>
	
	} // __toString.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	PID																				*
	 *==================================================================================*/

	/**
	 * <h4>Manage persistent identifier</h4>
	 *
	 * The <i>persistent identifier</i>, {@link kTAG_PID}, holds a string value which
	 * represents the object's persistent identifier. This value should uniquely identify
	 * the object across implementations and should not change once the object has been
	 * committed.
	 *
	 * This attribute becomes necessary when the object does not have a global unique
	 * identifier and its native identifier is not persistent. In nodes this is true
	 * because the {@link Term()}, which is its global identifier, is not unique and its
	 * native identifier, {@link NID()}, is a non persistent sequence number: this
	 * attribute can be used to set a value which can be used to differentiate nodes which
	 * point to the same term and that may have different native identifiers in different
	 * implementations.
	 *
	 * The method accepts a parameter which represents either the new value or the requested
	 * operation, depending on its type:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing an existing value; if <tt>FALSE</tt>, it will return the
	 * currently set value.
	 *
	 * Note that, while this method allows the creation, modification and deletion of this
	 * property, the hosting object may prevent some of these actions, by default this
	 * attribute is locked when the object has the {@link _IsCommitted()} status.
	 *
	 * @param mixed					$theValue			Persistent identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return string				<i>New</i>, <i>old</i> value or <tt>NULL</tt>.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_PID
	 */
	public function PID( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_PID, $theValue, $getOld );					// ==>

	} // PID.

	 
	/*===================================================================================
	 *	Term																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage node term</h4>
	 *
	 * This method can be used to manage the node's term, {@link kTAG_TERM}, which
	 * represents the node abstract term.
	 *
	 * The method accepts a parameter which represents either the term, or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param mixed					$theValue			Term or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kTAG_TERM
	 */
	public function Term( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kTAG_TERM, $theValue, $getOld );				// ==>

	} // Term.

	 
	/*===================================================================================
	 *	Description																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage node description</h4>
	 *
	 * The node <i>description</i>, {@link kTAG_DESCRIPTION}, represents the node's
	 * long label or extended definition. It is an optional attribute of the object that
	 * holds an array of elements in which the index is represented by the language code and
	 * the value is the string.
	 *
	 * No two elements may share the same language code.
	 *
	 * The description depends on the context in which the object is, as opposed as the
	 * definition which does not depend on the context.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theLanguage</tt>: Language code.
	 *	<li><tt>$theValue</tt>: The description string or the operation, depending on its
	 *		value:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the string corresponding to the provided language.
	 *		<li><tt>FALSE</tt>: Delete the element corresponding to the provided language.
	 *		<li><i>other</i>: Any other value represents the description string that will be
	 *			set or replace the entry for the provided language.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: If <tt>TRUE</tt>, the method will return the description
	 *		string <i>before</i> it was eventually modified; if <tt>FALSE</tt>, the method
	 *		will return the value <i>after</i> eventual modifications.
	 * </ul>
	 *
	 * @param mixed					$theLanguage		Language code.
	 * @param mixed					$theValue			Description or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> description.
	 *
	 * @uses ManageIndexedOffset()
	 *
	 * @see kTAG_DESCRIPTION
	 */
	public function Description( $theLanguage = NULL, $theValue = NULL, $getOld = FALSE )
	{
		return ManageIndexedOffset
				( $this, kTAG_DESCRIPTION, $theLanguage, $theValue, $getOld );		// ==>

	} // Description.

	 
	/*===================================================================================
	 *	Synonym																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage term synonyms</h4>
	 *
	 * This method can be used to manage the term's synonyms, {@link kTAG_SYNONYMS},
	 * which contains a list of strings that represent alternate codes or names that can be
	 * used to identify the term.
	 *
	 * This offset collects the list of synonyms in an enumerated set that can be managed
	 * with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <tt>TRUE</tt>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the element or full list.
	 *		<li><tt>FALSE</tt>: Delete the element or full list.
	 *		<li><tt>array</tt>: This type is only considered if the <tt>$theValue</tt>
	 *			parameter is provided as an array: the method will be called for each
	 *			element of the <tt>$theValue</tt> parameter matched with the corresponding
	 *			element of this parameter, which also means that both both parameters must
	 *			share the same count.
	 *		<li><i>other</i>: Add the <tt>$theValue</tt> value to the list. If you provided
	 *			<tt>NULL</tt> in the previous parameter, the operation will be reset to
	 *			<tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> type.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_SYNONYMS
	 */
	public function Synonym( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_SYNONYMS, $theValue, $theOperation, $getOld );			// ==>

	} // Synonym.

	 

/*=======================================================================================
 *																						*
 *								PUBLIC OPERATIONS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	RelateTo																		*
	 *==================================================================================*/

	/**
	 * <h4>Create an outgoing edge</h4>
	 *
	 * This method can be used to instantiate an outgoing edge by providing the object
	 * vertex node and edge predicate. The subject vertex is represented by the current
	 * node.
	 *
	 * Both the predicate and the object vertex node can be any type, the last parameter
	 * represents the connection, it is optional and if provided, will be used to commit the
	 * edge.
	 *
	 * The method expects the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theObject</tt>: The edge's object vertex.
	 *	<li><tt>$thePredicate</tt>: The edge's predicate.
	 *	<li><tt>$theConnection</tt>: Server, database or container.
	 *	<li><tt>$doPropagate</tt>: This boolean switch indicates whether the relationship is
	 *		to be propagated. This feature is not used in this class, but derived classes will
	 *		use it; the default value is <tt>TRUE</tt>.
	 * </ul>
	 *
	 * The method will return an instance of the {@link CEdge} class, if any error occurs,
	 * the method will raise an exception.
	 *
	 * @param mixed					$thePredicate		Relationship predicate.
	 * @param mixed					$theObject			Object vertex.
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param boolean				$doPropagate		TRUE means propagate relationships.
	 *
	 * @access public
	 * @return CEdge				Relationship edge object.
	 */
	public function RelateTo( $thePredicate, $theObject, $theConnection = NULL,
														 $doPropagate = TRUE )
	{
		//
		// Instantiate the edge
		//
		$edge = $this->_NewEdge();
		
		//
		// Set subject.
		//
		$edge->Subject( $this );
		
		//
		// Set predicate.
		//
		$edge->Predicate( $thePredicate );
		
		//
		// Set object.
		//
		$edge->Object( $theObject );
		
		//
		// Insert.
		//
		if( $theConnection !== NULL )
			$edge->Insert( $theConnection );
		
		return $edge;																// ==>

	} // RelateTo.
		


/*=======================================================================================
 *																						*
 *								PROTECTED OFFSET INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Preset																			*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before setting it</h4>
	 *
	 * In this class we ensure that the {@link kTAG_KIND} and {@link kTAG_DESCRIPTION}
	 * offsets are an arrays, ArrayObject instances are not counted as an array.
	 *
	 * We also ensure that the persistent identifier, {@link kTAG_PID}, is not modified if
	 * the object is committed.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @see kTAG_KIND
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kTAG_PID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
				( "You cannot modify the [$theOffset] offset: "
				 ."the object is committed",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Ensure kind and description are arrays.
		//
		$offsets = array( kTAG_KIND, kTAG_DESCRIPTION );
		if( in_array( $theOffset, $offsets )
		 && ($theValue !== NULL)
		 && (! is_array( $theValue )) )
			throw new Exception
				( "You cannot set the [$theOffset] offset: "
				 ."invalid value, expecting an array",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preset.

	 
	/*===================================================================================
	 *	_Preunset																		*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before unsetting it</h4>
	 *
	 * In this class we prevent the modification of persistent attributes, in this class:
	 * {@link kTAG_PID}.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsCommitted()
	 *
	 * @see kTAG_PID
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Intercept identifiers.
		//
		$offsets = array( kTAG_PID );
		if( $this->_IsCommitted()
		 && in_array( $theOffset, $offsets ) )
			throw new Exception
				( "You cannot modify the [$theOffset] offset: "
				 ."the object is committed",
				  kERROR_LOCKED );												// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_Preunset( $theOffset );
	
	} // _Preunset.
		


/*=======================================================================================
 *																						*
 *								PROTECTED EDGE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_NewEdge																		*
	 *==================================================================================*/

	/**
	 * <h4>Return a new edge instance</h4>
	 *
	 * This method should return a new edge instance, its goal is to instantiate the correct
	 * edge type.
	 *
	 * In this class we return a {@link CEdge} instance.
	 *
	 * @access protected
	 * @return CEdge
	 */
	protected function _NewEdge()									{	return new CEdge();	}
		


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
	 * {@link kTAG_TERM} offset.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
	 *
	 * @see kTAG_TERM
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return $this->offsetExists( kTAG_TERM );								// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class CNode.


?>
