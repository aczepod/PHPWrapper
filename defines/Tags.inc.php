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
 *		<li><tt>{@link kTAG_DEFINITION}</tt>: <i>Definition</i>. This attribute
 *			represents the definition of the referenced object. It is an
 *			{@link kTYPE_LSTRING} structure in which the definition can be expressed in
 *			several languages. A definition is independent of the context.
 *		<li><tt>{@link kTAG_DESCRIPTION}</tt>: <i>Description</i>. This attribute
 *			represents the description of the referenced object. It is an
 *			{@link kTYPE_LSTRING} structure in which the description can be expressed in
 *			several languages. A description depends on the context.
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
 * To convert this file to javascript use the following grep pattern:
 * <code>
 * search:  ^define\( "(.+)",.+(\'.+\').*;
 * replace: var \1 = \2;
 * </code>
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
define( "kTAG_UID",								'3' );

/**
 * PID.
 *
 * Persistent identifier.
 *
 * This attribute is used when an object needs a persistent identifier and it does not have
 * a global or native identifier which is either unique or persistent. This attribute is
 * set whenever a persistent identifier is needed to identify an object across
 * implementations and this is not possible using other object attributes.
 *
 * Version 1: (kTAG_PID)[4]
 */
define( "kTAG_PID",								'4' );

/**
 * SYNONYMS.
 *
 * Synonyms.
 *
 * This attribute contains a list of strings that represent alternate identifiers for the
 * hosting object. Synonyms do not have any relation to the namespace.
 *
 * Version 1: (kTAG_SYNONYMS)[7]
 * Version 2: (kTAG_SYNONYMS)[4]
 */
define( "kTAG_SYNONYMS",						'5' );

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
 * Version 2: (kTAG_CATEGORY)[5]
 */
define( "kTAG_CATEGORY",						'6' );

/**
 * KIND.
 *
 * Kind.
 *
 * This attribute is an enumerated set that defines the kind of the hosting object.
 *
 * Version 1: (kTAG_KIND)[13]
 * Version 2: (kTAG_KIND)[6]
 */
define( "kTAG_KIND",							'7' );

/**
 * TYPE.
 *
 * Type.
 *
 * This attribute is an enumerated set that contains a combination of data type and
 * cardinality indicators which, combined, represet the data type of the hosting object.
 *
 * Version 1: (kTAG_TYPE)[14]
 * Version 2: (kTAG_TYPE)[7]
 */
define( "kTAG_TYPE",							'8' );

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
 * Version 2: (kTAG_CLASS)[8]
 */
define( "kTAG_CLASS",							'9' );

/**
 * NAMESPACE.
 *
 * Namespace.
 *
 * This attribute is a reference to a term which represents the namespace of the current
 * object. The object local identifiers must be unique within the scope of the namespace.
 *
 * Version 1: (kTAG_NAMESPACE)[3]
 * Version 2: (kTAG_NAMESPACE)[9]
 */
define( "kTAG_NAMESPACE",						'10' );

/*=======================================================================================
 *	REPRESENTATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * INPUT.
 *
 * Input.
 *
 * This attribute represents the enumerated set for the suggested or preferred input type
 * that should be used in a form to manage the value of the referenced property.
 *
 * Version 1: (kTAG_INPUT)[10]
 */
define( "kTAG_INPUT",							'11' );

/**
 * PATTERN.
 *
 * Pattern.
 *
 * This attribute represents the regular expression pattern that can be used to validate the
 * value of the referenced property.
 *
 * Version 1: (kTAG_PATTERN)[11]
 */
define( "kTAG_PATTERN",							'12' );

/**
 * LENGTH.
 *
 * Length.
 *
 * This attribute represents the maximum number of characters that may comprise the value of
 * the referenced property.
 *
 * Version 1: (kTAG_LENGTH)[12]
 */
define( "kTAG_LENGTH",							'13' );

/**
 * MIN.
 *
 * Minimum value.
 *
 * This attribute represents the minimum value that the referenced property may hold.
 *
 * Version 1: (kTAG_MIN_VAL)[13]
 */
define( "kTAG_MIN_VAL",							'14' );

/**
 * MAX.
 *
 * Maximum value.
 *
 * This attribute represents the maximum value that the referenced property may hold.
 *
 * Version 1: (kTAG_MAX_VAL)[14]
 */
define( "kTAG_MAX_VAL",							'15' );

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
 * Version 2: (kTAG_LABEL)[10]
 * Version 3: (kTAG_LABEL)[15]
 */
define( "kTAG_LABEL",							'16' );

/**
 * DEFINITION.
 *
 * Definition.
 *
 * This attribute represents the definition of the referenced object. It is an
 * {@link kTYPE_LSTRING} structure in which the definition can be expressed in several
 + languages. A definition is independent of the context.
 *
 * Version 1: (kTAG_DEFINITION)[??]
 * Version 2: (kTAG_DEFINITION)[11]
 * Version 3: (kTAG_DEFINITION)[16]
 */
define( "kTAG_DEFINITION",						'17' );

/**
 * DESCRIPTION.
 *
 * Description.
 *
 * This attribute represents the description of the referenced object. It is an
 * {@link kTYPE_LSTRING} structure in which the description can be expressed in several
 * languages. A description depends on the context.
 *
 * Version 1: (kTAG_DESCRIPTION)[6]
 * Version 2: (kTAG_DESCRIPTION)[12]
 * Version 3: (kTAG_DESCRIPTION)[17]
 */
define( "kTAG_DESCRIPTION",						'18' );

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
 * Version 2: (kTAG_NOTES)[13]
 * Version 3: (kTAG_NOTES)[18]
 */
define( "kTAG_NOTES",							'19' );

/**
 * EXAMPLES.
 *
 * Examples.
 *
 * This attribute represents the examples or templates of the referenced object.
 * It is a list of strings where each string represents an example or template.
 *
 * Version 1: (kTAG_EXAMPLES)[28]
 * Version 2: (kTAG_EXAMPLES)[14]
 * Version 3: (kTAG_EXAMPLES)[19]
 */
define( "kTAG_EXAMPLES",						'20' );

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
 * Version 2: (kTAG_AUTHORS)[15]
 * Version 3: (kTAG_AUTHORS)[20]
 */
define( "kTAG_AUTHORS",							'21' );

/**
 * ACKNOWLEDGMENTS.
 *
 * Acknowledgments.
 *
 * This attribute represents a list of generic acknowledgments, it is an array of strings.
 *
 * Version 1: (kTAG_ACKNOWLEDGMENTS)[26]
 * Version 2: (kTAG_ACKNOWLEDGMENTS)[16]
 * Version 3: (kTAG_ACKNOWLEDGMENTS)[21]
 */
define( "kTAG_ACKNOWLEDGMENTS",					'22' );

/**
 * BIBLIOGRAPHY.
 *
 * Bibliography.
 *
 * This attribute represents a list of bibliographic references, it is an array of strings.
 *
 * Version 1: (kTAG_BIBLIOGRAPHY)[27]
 * Version 2: (kTAG_BIBLIOGRAPHY)[17]
 * Version 3: (kTAG_BIBLIOGRAPHY)[22]
 */
define( "kTAG_BIBLIOGRAPHY",					'23' );

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
 * Version 2: (kTAG_TERM)[18]
 * Version 3: (kTAG_TERM)[23]
 */
define( "kTAG_TERM",							'24' );

/**
 * NODE.
 *
 * Node.
 *
 * This attribute contains a reference to an object that represents the master node of the
 * attribute host.
 *
 * Version 1: (kTAG_NODE)[??]
 * Version 2: (kTAG_NODE)[19]
 * Version 3: (kTAG_NODE)[24]
 */
define( "kTAG_NODE",							'25' );

/**
 * SUBJECT.
 *
 * Subject.
 *
 * This attribute contains a reference to an object that represents the start, origin or
 * subject vertex of a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kTAG_VERTEX_SUBJECT)[18]
 * Version 2: (kTAG_SUBJECT)[20]
 * Version 3: (kTAG_SUBJECT)[25]
 */
define( "kTAG_SUBJECT",							'26' );

/**
 * kTAG_OBJECT.
 *
 * Object.
 *
 * This attribute contains a reference to an object that represents the end, destination or
 * object vertex of a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kTAG_VERTEX_OBJECT)[20]
 * Version 2: (kTAG_OBJECT)[21]
 * Version 3: (kTAG_OBJECT)[26]
 */
define( "kTAG_OBJECT",							'27' );

/**
 * PREDICATE.
 *
 * Predicate.
 *
 * This attribute contains a reference to an object that represents the predicate term of a
 * <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kTAG_PREDICATE)[19]
 * Version 2: (kTAG_PREDICATE)[22]
 * Version 3: (kTAG_PREDICATE)[27]
 */
define( "kTAG_PREDICATE",						'28' );

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
 * Version 2: (kTAG_PATH)[23]
 * Version 3: (kTAG_PATH)[28]
 */
define( "kTAG_PATH",							'29' );

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
 * Version 2: (kTAG_NAMESPACE_REFS)[24]
 * Version 3: (kTAG_NAMESPACE_REFS)[29]
 */
define( "kTAG_NAMESPACE_REFS",					'30' );

/**
 * NODES.
 *
 * Nodes.
 *
 * This attribute is a collection of node references, it is an array of node object native
 * identifiers who reference the current object.
 *
 * Version 1: (kTAG_REFS_NODE)[10]
 * Version 2: (kTAG_NODES)[25]
 * Version 3: (kTAG_NODES)[30]
 */
define( "kTAG_NODES",							'31' );

/**
 * EDGES.
 *
 * Edges.
 *
 * This attribute is a collection of edge references, it is an array of edge object native
 * identifiers who reference the current object.
 *
 * Version 1: (kTAG_REFS_EDGE)[17]
 * Version 2: (kTAG_EDGES)[26]
 * Version 3: (kTAG_EDGES)[31]
 */
define( "kTAG_EDGES",							'32' );

/**
 * FEATURES.
 *
 * Features.
 *
 * This attribute is a collection of feature references, it is an array of object native
 * identifiers that reference the current object as a feature or trait.
 *
 * Version 1: (kTAG_REFS_TAG_FEATURE)[15]
 * Version 2: (kTAG_FEATURES)[27]
 * Version 3: (kTAG_FEATURES)[32]
 */
define( "kTAG_FEATURES",						'33' );

/**
 * METHODS.
 *
 * Methods.
 *
 * This attribute is a collection of method references, it is an array of object native
 * identifiers that reference the current object as a method or modifier.
 *
 * Version 1: (kTAG_REFS_TAG_METHOD)[??]
 * Version 2: (kTAG_METHODS)[28]
 * Version 3: (kTAG_METHODS)[33]
 */
define( "kTAG_METHODS",							'34' );

/**
 * SCALES.
 *
 * Scales.
 *
 * This attribute is a collection of scale references, it is an array of object native
 * identifiers that reference the current object as a scale or unit.
 *
 * Version 1: (kTAG_REFS_TAG_SCALE)[16]
 * Version 2: (kTAG_SCALES)[29]
 * Version 3: (kTAG_SCALES)[34]
 */
define( "kTAG_SCALES",							'35' );

/*=======================================================================================
 *	USER OBJECT																			*
 *======================================================================================*/

/**
 * USER-NAME.
 *
 * User name.
 *
 * The full user name.
 *
 * Version 1: (kTAG_USER_NAME)[30]
 * Version 2: (kTAG_USER_NAME)[30]
 * Version 3: (kTAG_USER_NAME)[35]
 */
define( "kTAG_USER_NAME",						'36' );

/**
 * USER-CODE.
 *
 * User code.
 *
 * The code with which the user is known to the system.
 *
 * Version 1: (kTAG_USER_CODE)[31]
 * Version 2: (kTAG_USER_CODE)[31]
 * Version 3: (kTAG_USER_CODE)[36]
 */
define( "kTAG_USER_CODE",						'37' );

/**
 * USER-PASS.
 *
 * User password.
 *
 * The password with which the user is known to the system.
 *
 * Version 1: (kTAG_USER_PASS)[32]
 * Version 2: (kTAG_USER_PASS)[32]
 * Version 3: (kTAG_USER_PASS)[37]
 */
define( "kTAG_USER_PASS",						'38' );

/**
 * USER-MAIL.
 *
 * User e-mail.
 *
 * The e-mail address of the user.
 *
 * Version 1: (kTAG_USER_MAIL)[33]
 * Version 2: (kTAG_USER_MAIL)[33]
 * Version 3: (kTAG_USER_MAIL)[38]
 */
define( "kTAG_USER_MAIL",						'39' );

/**
 * USER-ROLE.
 *
 * User roles.
 *
 * The roles assigned to the user.
 *
 * Version 1: (kTAG_USER_ROLE)[34]
 * Version 2: (kTAG_USER_ROLE)[34]
 * Version 3: (kTAG_USER_ROLE)[39]
 */
define( "kTAG_USER_ROLE",						'40' );

/**
 * USER-PROFILE.
 *
 * User profile.
 *
 * The profile role name assigned to the user.
 *
 * Version 1: (kTAG_USER_PROFILE)[35]
 * Version 2: (kTAG_USER_PROFILE)[35]
 * Version 3: (kTAG_USER_PROFILE)[40]
 */
define( "kTAG_USER_PROFILE",					'41' );

/**
 * USER-MANAGER.
 *
 * User manager.
 *
 * Reference to the user that manages the current user.
 *
 * Version 1: (kTAG_USER_MANAGER)[36]
 * Version 2: (kTAG_USER_MANAGER)[36]
 * Version 3: (kTAG_USER_MANAGER)[41]
 */
define( "kTAG_USER_MANAGER",					'42' );

/**
 * USER-DOMAIN.
 *
 * User domain.
 *
 * List of domains the user has access to.
 *
 * Version 1: (kTAG_USER_DOMAIN)[37]
 * Version 2: (kTAG_USER_DOMAIN)[37]
 * Version 3: (kTAG_USER_DOMAIN)[42]
 */
define( "kTAG_USER_DOMAIN",						'43' );

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
