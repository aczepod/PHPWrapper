<?php

/*=======================================================================================
 *																						*
 *									Tags.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 * Default attribute tags.
 *
 * This file contains the tag definitions for all default attributes, these tags are used
 * as the object's attribute keys and are related to the default attribute terms.
 *
 * <ul>
 *	<li><i>Identification attributes</i>: These attributes are used to identify objects:
 *	 <ul>
 *		<li><tt>{@link kTAG_NID}</tt>: <i>Native identifier</i>. This attribute contains the
 *			native unique identifier of the object. This identifier is used as the default
 *			unique key for all objects and can have any scalar data type. 
 *		<li><tt>{@link kTAG_LID}</tt>: <i>Local identifier</i>. This attribute contains the
 *			local unique identifier. This value represents the value that uniquely
 *			identifies an object within a specific domain or namespace. It is by definition
 *			a string constituting the suffix of the global identifier, {@link kTAG_GID}. 
 *		<li><tt>{@link kTAG_GID}</tt>: <i>Global identifier</i>. This attribute contains
 *			the global unique identifier. This value represents the value that uniquely
 *			identifies the object across domains and namespaces. This value is by definition
 *			a string and will generally constitute the object's primary key
 *			({@link kTAG_NID}) in full or hashed form. 
 *		<li><tt>{@link kTAG_UID}</tt>: <i>Unique identifier</i>. This attribute contains
 *			the hashed unique identifier of an object in which its {@link kTAG_NID} is not
 *			related to the {@link kTAG_GID}. This is generally used when the
 *			{@link kTAG_NID} is a sequence number.
 *		<li><tt>{@link kTAG_SYNONYMS}</tt>: <i>Synonyms</i>. This attribute contains a list
 *			of strings that represent alternate identifiers for the hosting object.
 *			Synonyms do not have any relation to the namespace.
 *	 </ul>
 *	<li><i>Classification attributes</i>: These attributes are used to classify objects:
 *	 <ul>
 *		<li><tt>{@link kTAG_CATEGORY}</tt>: <i>Category</i>. This attribute is an
 *			enumerated set that contains all the categories to which the hosting object
 *			belongs to. 
 *		<li><tt>{@link kTAG_KIND}</tt>: <i>Kind</i>. This attribute is an enumerated set
 *			that defines the kind of the hosting object. 
 *		<li><tt>{@link kTAG_TYPE}</tt>: <i>Type</i>. This attribute is an enumerated set
 *			that contains a combination of data type and cardinality indicators which,
 *			combined, represet the data type of the hosting object.
 *		<li><tt>{@link kTAG_CLASS}</tt>: <i>Class</i>. This attribute is a string that
 *			represets the referenced object's class. This attribute is used to instantiate
 *			the correct class once an object has been retrieved from its container.
 *		<li><tt>{@link kTAG_NAMESPACE}</tt>: <i>Namespace</i>. This attribute is a
 *			reference to a term which represents the namespace of the current object. The
 *			object local identifiers must be unique within the scope of the namespace.
 *	 </ul>
 *	<li><i>Description attributes</i>: These attributes are used to describe objects:
 *	 <ul>
 *		<li><tt>{@link kTAG_LABEL}</tt>: <i>Label</i>. This attribute represents the label,
 *			name or short description of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the label can be expressed in several
 *			languages. 
 *		<li><tt>{@link kTAG_DESCRIPTION}</tt>: <i>Description</i>. This attribute
 *			represents the description or definition of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the description can be expressed in
 *			several languages. 
 *		<li><tt>{@link kTAG_NOTES}</tt>: <i>Notes</i>. This attribute represents the notes
 *			or comments of the referenced object. It is a {@link kTYPE_LSTRING} structure in
 *			which the description can be expressed in several languages. 
 *		<li><tt>{@link kTAG_EXAMPLES}</tt>: <i>Examples</i>. This attribute represents the
 *			examples or templates of the referenced object. It is a list of strings where
 *			each string represents an example or template. 
 *	 </ul>
 *	<li><i>Authorship attributes</i>: These attributes are used to describe authorship:
 *	 <ul>
 *		<li><tt>{@link kTAG_AUTHORS}</tt>: <i>Authors</i>. This attribute represents a list
 *			of authors, it is an array of author names.
 *		<li><tt>{@link kTAG_ACKNOWLEDGMENTS}</tt>: <i>Acknowledgments</i>. This attribute
 *			represents a list of generic acknowledgments, it is an array of strings.
 *		<li><tt>{@link kTAG_BIBLIOGRAPHY}</tt>: <i>Bibliography</i>. This attribute
 *			represents a list of bibliographic references, it is an array of strings.
 *	 </ul>
 *	<li><i>Reference attributes</i>: These attributes are used to reference other objects
 *		and contain the native identifier of the referenced object:
 *	 <ul>
 *		<li><tt>{@link kTAG_TERM}</tt>: <i>Term</i>. This attribute contains a reference to
 *			an object that represents the term of the attribute host.
 *		<li><tt>{@link kTAG_NODE}</tt>: <i>Node</i>. This attribute contains a reference to
 *			an object that represents the node of the attribute host.
 *		<li><tt>{@link kTAG_SUBJECT}</tt>: <i>Subject</i>. This attribute contains a
 *			reference to an object that represents the start, origin or subject vertex of a
 *			<tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTAG_OBJECT}</tt>: <i>Object</i>. This attribute contains a
 *			reference to an object that represents the end, destination or object vertex of
 *			a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTAG_PREDICATE}</tt>: <i>Predicate</i>. This attribute contains a
 *			reference to an object that represents the predicate term of a
 *			<tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTAG_PATH}</tt>: <i>Path</i>. This attribute represents a sequence
 *			of <tt>vertex</tt>, <tt>predicate</tt>, <tt>vertex</tt> elements whose
 *			concatenation represents a path between an origin vertex and a destination
 *			vertex.
 *	 </ul>
 *	<li><i>Reference collections</i>: These attributes are used as collections of references
 *		to other objects and contain a list whose elements are the native identifier of the
 *		referenced object:
 *	 <ul>
 *		<li><tt>{@link kTAG_NAMESPACE_REFS}</tt>: <i>Namespace references count</i>. This
 *			integer attribute counts how many times external objects have referenced the
 *			current one as a namespace.
 *		<li><tt>{@link kTAG_NODES}</tt>: <i>Nodes</i>. This attribute is a collection of
 *			node references, it is an array of node object native identifiers who reference
 *			the current object.
 *		<li><tt>{@link kTAG_EDGES}</tt>: <i>Edges</i>. This attribute is a collection of
 *			edge references, it is an array of edge object native identifiers who reference
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
 *	 </ul>
 *	<li><i>Local tags</i>: This set of tags is local and is managed internally:
 *	 <ul>
 *		<li><i>Custom type sub-attributes</i>: These attributes are used by the standard
 *			data type structures for recording the type and value:
 *		 <ul>
 *			<li><tt>{@link kTAG_CUSTOM_TYPE}</tt>: <i>Custom data object type</i>. This tag
 *				is used as the default offset for indicating a custom data type, in general
 *				it is used in a structure in conjunction with the {@link kTAG_CUSTOM_DATA}
 *				offset to indicate the data type of the item.
 *			<li><tt>{@link kTAG_CUSTOM_DATA}</tt>: <i>Custom data object data</i>. This tag
 *				is used as the default offset for indicating a custom data type content, in
 *				general this tag is used in conjunction with the {@link kTAG_CUSTOM_TYPE} to
 *				wrap a custom data type in a standard structure.
 *		 </ul>
 *		<li><i>Custom timestamp sub-attributes</i>: These attributes are used by the
 *			standard data type structures for recording sub-elements of time-stamps:
 *		 <ul>
 *			<li><tt>{@link kTAG_STAMP_SEC}</tt>: <i>Seconds</i>. This tag defines the number
 *				of seconds since January 1st, 1970.
 *			<li><tt>{@link kTAG_STAMP_USEC}</tt>: <i>Microseconds</i>. This tag defines
 *				microseconds.
 *		 </ul>
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 25/11/2012
 */

/*=======================================================================================
 *	IDENTIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * _id.
 *
 * Native identifier.
 *
 * This attribute contains the native unique identifier of the object. This identifier is
 * used as the default unique key for all objects and can have any scalar data type.
 *
 * Version 1: (kOFFSET_NID)[_id]
 */
define( "kTAG_NID",								'_id' );

/**
 * LID.
 *
 * Local identifier.
 *
 * This attribute contains the local unique identifier. This value represents the value that
 * uniquely identifies an object within a specific domain or namespace. It is by definition
 * a string constituting the suffix of the global identifier, {@link kTAG_GID}.
 *
 * Version 1: (kTAG_LID)[1]
 */
define( "kTAG_LID",								'1' );

/**
 * GID.
 *
 * Global identifier.
 *
 * This attribute contains the global unique identifier. This value represents the value
 * that uniquely identifies the object across domains and namespaces. This value is by
 * definition a string and will generally constitute the object's primary key
 * ({@link kTAG_NID}) in full or hashed form.
 *
 * Version 1: (kTAG_GID)[2]
 */
define( "kTAG_GID",								'2' );

/**
 * UID.
 *
 * Unique identifier.
 *
 * This attribute contains the hashed unique identifier of an object in which its
 * {@link kTAG_NID} is not related to the {@link kTAG_GID}. This is generally used when
 * the {@link kTAG_NID} is a sequence number.
 *
 * Version 1: (kTAG_UID)[21]
 */
define( "kTAG_UID",								'21' );

/**
 * SYNONYMS.
 *
 * Synonyms.
 *
 * This attribute contains a list of strings that represent alternate identifiers for the
 * hosting object. Synonyms do not have any relation to the namespace.
 *
 * Version 1: (kTAG_SYNONYMS)[7]
 */
define( "kTAG_SYNONYMS",						'7' );

/*=======================================================================================
 *	CLASSIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * CATEGORY.
 *
 * Category.
 *
 * This attribute is an enumerated set that contains all the categories to which the hosting
 * object belongs to.
 *
 * Version 1: (kTAG_CATEGORY)[12]
 */
define( "kTAG_CATEGORY",						'12' );

/**
 * KIND.
 *
 * Kind.
 *
 * This attribute is an enumerated set that defines the kind of the hosting object.
 *
 * Version 1: (kTAG_KIND)[13]
 */
define( "kTAG_KIND",							'13' );

/**
 * TYPE.
 *
 * Type.
 *
 * This attribute is an enumerated set that contains a combination of data type and
 * cardinality indicators which, combined, represet the data type of the hosting object.
 *
 * Version 1: (kTAG_TYPE)[14]
 */
define( "kTAG_TYPE",							'14' );

/**
 * CLASS.
 *
 * Class.
 *
 * This attribute is a string that represets the referenced object's class. This attribute
 * is used to instantiate the correct class once an object has been retrieved from its
 * container.
 *
 * Version 1: (kTAG_CLASS)[4]
 */
define( "kTAG_CLASS",							'4' );

/**
 * NAMESPACE.
 *
 * Namespace.
 *
 * This attribute is a reference to a term which represents the namespace of the current
 * object. The object local identifiers must be unique within the scope of the namespace.
 *
 * Version 1: (kTAG_NAMESPACE)[3]
 */
define( "kTAG_NAMESPACE",						'3' );

/*=======================================================================================
 *	DESCRIPTION ATTRIBUTES																*
 *======================================================================================*/

/**
 * LABEL.
 *
 * Label.
 *
 * This attribute represents the label, name or short description of the referenced object.
 * It is a {@link kTYPE_LSTRING} structure in which the label can be expressed in several
 * languages.
 *
 * Version 1: (kTAG_LABEL)[5]
 */
define( "kTAG_LABEL",							'5' );

/**
 * DESCRIPTION.
 *
 * Description.
 *
 * This attribute represents the description or definition of the referenced object.
 * It is a {@link kTYPE_LSTRING} structure in which the description can be expressed in
 * several languages.
 *
 * Version 1: (kTAG_DESCRIPTION)[6]
 */
define( "kTAG_DESCRIPTION",						'6' );

/**
 * NOTES.
 *
 * Notes.
 *
 * This attribute represents the notes or comments of the referenced object.
 * It is a {@link kTYPE_LSTRING} structure in which the description can be expressed in
 * several languages.
 *
 * Version 1: (kTAG_NOTES)[25]
 */
define( "kTAG_NOTES",							'25' );

/**
 * EXAMPLES.
 *
 * Examples.
 *
 * This attribute represents the examples or templates of the referenced object.
 * It is a list of strings where each string represents an example or template.
 *
 * Version 1: (kTAG_EXAMPLES)[28]
 */
define( "kTAG_EXAMPLES",						'28' );

/*=======================================================================================
 *	AUTHORSHIP ATTRIBUTES																*
 *======================================================================================*/

/**
 * AUTHORS.
 *
 * Authors.
 *
 * This attribute represents a list of authors, it is an array of author names.
 *
 * Version 1: (kTAG_AUTHORS)[24]
 */
define( "kTAG_AUTHORS",							'24' );

/**
 * ACKNOWLEDGMENTS.
 *
 * Acknowledgments.
 *
 * This attribute represents a list of generic acknowledgments, it is an array of strings.
 *
 * Version 1: (kTAG_ACKNOWLEDGMENTS)[26]
 */
define( "kTAG_ACKNOWLEDGMENTS",					'26' );

/**
 * BIBLIOGRAPHY.
 *
 * Bibliography.
 *
 * This attribute represents a list of bibliographic references, it is an array of strings.
 *
 * Version 1: (kTAG_BIBLIOGRAPHY)[27]
 */
define( "kTAG_BIBLIOGRAPHY",					'27' );

/*=======================================================================================
 *	REFERENCE ATTRIBUTES																*
 *======================================================================================*/

/**
 * TERM.
 *
 * Term.
 *
 * This attribute contains a reference to an object that represents the term of the
 * attribute host.
 *
 * Version 1: (kTAG_TERM)[8]
 */
define( "kTAG_TERM",							'8' );

/**
 * NODE.
 *
 * Node.
 *
 * This attribute contains a reference to an object that represents the master node of the
 * attribute host.
 *
 * Version 1: (kTAG_NODE)[??]
 */
define( "kTAG_NODE",							'1002' );

/**
 * SUBJECT.
 *
 * Subject.
 *
 * This attribute contains a reference to an object that represents the start, origin or
 * subject vertex of a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kTAG_VERTEX_SUBJECT)[18]
 */
define( "kTAG_SUBJECT",							'18' );

/**
 * OBJECT.
 *
 * Object.
 *
 * This attribute contains a reference to an object that represents the end, destination or
 * object vertex of a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kTAG_VERTEX_OBJECT)[20]
 */
define( "kTAG_OBJECT",							'20' );

/**
 * PREDICATE.
 *
 * Predicate.
 *
 * This attribute contains a reference to an object that represents the predicate term of a
 * <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kTAG_PREDICATE)[19]
 */
define( "kTAG_PREDICATE",						'19' );

/**
 * PATH.
 *
 * Path.
 *
 * This attribute represents a sequence of <tt>vertex</tt>, <tt>predicate</tt>,
 * <tt>vertex</tt> elements whose concatenation represents a path between an origin vertex
 * and a destination vertex.
 *
 * Version 1: (kTAG_TAG_PATH)[22]
 */
define( "kTAG_PATH",							'22' );

/*=======================================================================================
 *	REFERENCE COLLECTIONS																*
 *======================================================================================*/

/**
 * NAMESPACE-REFS.
 *
 * Namespace references count.
 *
 * This integer attribute counts how many times external objects have referenced the current
 * one as a namespace.
 *
 * Version 1: (kTAG_REFS_NAMESPACE)[9]
 */
define( "kTAG_NAMESPACE_REFS",					'9' );

/**
 * NODES.
 *
 * Nodes.
 *
 * This attribute is a collection of node references, it is an array of node object native
 * identifiers who reference the current object.
 *
 * Version 1: (kTAG_REFS_NODE)[10]
 */
define( "kTAG_NODES",							'10' );

/**
 * EDGES.
 *
 * Edges.
 *
 * This attribute is a collection of edge references, it is an array of edge object native
 * identifiers who reference the current object.
 *
 * Version 1: (kTAG_REFS_EDGE)[17]
 */
define( "kTAG_EDGES",							'17' );

/**
 * FEATURES.
 *
 * Features.
 *
 * This attribute is a collection of feature references, it is an array of object native
 * identifiers that reference the current object as a feature or trait.
 *
 * Version 1: (kTAG_REFS_TAG_FEATURE)[15]
 */
define( "kTAG_FEATURES",						'15' );

/**
 * METHODS.
 *
 * Methods.
 *
 * This attribute is a collection of method references, it is an array of object native
 * identifiers that reference the current object as a method or modifier.
 *
 * Version 1: (kTAG_REFS_TAG_METHOD)[??]
 */
define( "kTAG_METHODS",							'1001' );

/**
 * SCALES.
 *
 * Scales.
 *
 * This attribute is a collection of scale references, it is an array of object native
 * identifiers that reference the current object as a scale or unit.
 *
 * Version 1: (kTAG_REFS_TAG_SCALE)[16]
 */
define( "kTAG_SCALES",							'16' );

/*=======================================================================================
 *	CUSTOM TYPE SUB ATTRIBUTES															*
 *======================================================================================*/

/**
 * type.
 *
 * Custom data object type.
 *
 * This tag is used as the default offset for indicating a custom data type, in general it
 * is used in a structure in conjunction with the {@link kTAG_CUSTOM_DATA} offset to indicate the
 * data type of the item.
 *
 * Version 1: (kTAG_CUSTOM_TYPE)[type]
 */
define( "kTAG_CUSTOM_TYPE",						'type' );

/**
 * data.
 *
 * Custom data object data.
 *
 * This tag is used as the default offset for indicating a custom data type content, in
 * general this tag is used in conjunction with the {@link kTAG_CUSTOM_TYPE} to wrap a custom data
 * type in a standard structure.
 *
 * Version 1: (kTAG_CUSTOM_DATA)[data]
 */
define( "kTAG_CUSTOM_DATA",						'data' );

/*=======================================================================================
 *	CUSTOM TIMESTAMP SUB-ATTRIBUTES														*
 *======================================================================================*/

/**
 * sec.
 *
 * Seconds.
 *
 * This tag defines the number of seconds since January 1st, 1970.
 *
 * Version 1: (kTYPE_STAMP_SEC)[sec]
 */
define( "kTAG_STAMP_SEC",						'sec' );

/**
 * usec.
 *
 * Microseconds.
 *
 * This tag defines microseconds.
 *
 * Version 1: (kTYPE_STAMP_USEC)[usec]
 */
define( "kTAG_STAMP_USEC",						'usec' );


?>
