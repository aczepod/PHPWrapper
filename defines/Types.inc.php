<?php

/*=======================================================================================
 *																						*
 *									Types.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 * Type definitions.
 *
 * This file contains the default data types.
 *
 * Types are represented by term objects, they indicate the type of an object and are
 * organised in the following enumerated set:
 *
 * <ul>
 *	<li><i>Primitive data types</i>: These types represent primitive or atomic data types,
 *		which means that these cannot be decomposed in elementary components.
 *	 <ul>
 *		<li><tt>{@link kTYPE_ANY}</tt>: <i>Any type</i>. This type represents a type
 *			wildcard, it qualifies an attribute that can take any type of value.
 *		<li><tt>{@link kTYPE_STRING}</tt>: <i>String or text</i>. This type defines a list
 *			of characters or a list of character strings.
 *		<li><tt>{@link kTYPE_INT}</tt>: <i>Integer number</i>. This type defines an integer
 *			signed number, this number does not have a decimal part and has an indeterminate
 *			precision.
 *		<li><tt>{@link kTYPE_FLOAT}</tt>: <i>Floating point number</i>. This type defines a
 *			signed floating point numeric value of indeterminate precision.
 *		<li><tt>{@link kTYPE_BOOLEAN}</tt>: <i>Boolean switch</i>. This type defines a
 *			switch that can take two values: <tt>ON</tt> and <tt>OFF</tt>. By default we
 *			assume it to be represented by a number in which zero is <tt>OFF</tt> and any
 *			other value is <tt>ON</tt>.  Other representations are <tt>yes</tt>/<tt>no</tt>,
 *			<tt>true</tt>/<tt>false</tt>.
 *	 </ul>
 *	<li><i>Custom primitive data types</i>: These types are variations of primitive data
 *		types, they represent specific sub-types of primitive data types.
 *	 <ul>
 *		<li><tt>{@link kTYPE_BINARY_STRING}</tt>: <i>Binary string</i>. This type represents
 *			a list of bytes. It is equivalent to the {@link kTYPE_STRING} type, except that
 *			the characters that compose the string can take any value, while in the
 *			{@link kTYPE_STRING} type they represent specifically text characters.
 *		<li><tt>{@link kTYPE_DATE_STRING}</tt>: <i>Date string</i>. This type represents a
 *			date in the form of a <tt>YYYYMMDD</tt> string in which missing elements should
 *			be omitted. This means that if we don't know the day we can express that date as
 *			<tt>YYYYMM</tt> and if we don't know the month we can express it as
 *			<tt>YYYY</tt>. This type is functionally identical to a {@link kTYPE_STRING}
 *			type, except that its elements can only be digits and their structure is known.
 *		<li><tt>{@link kTYPE_TIME_STRING}</tt>: <i>Time string</i>. This type is a
 *			combination of the {@link kTYPE_DATE_STRING} type followed by a structure of
 *			three elements representing the hours, minutes and seconds separated by colons,
 *			<tt>YYYYMMDD HHMMSS</tt>. Missing elements are omitted, this means that if you
 *			don't have the minutes you would have a <tt>YYYYMMDD HH</tt> and if you don't
 *			have the time it would become and act as a {@link kTYPE_DATE_STRING} type. This
 *			type is functionally identical to a {@link kTYPE_STRING} type, except that its
 *			elements can only be digits and their structure is known.
 *		<li><tt>{@link kTYPE_REGEX_STRING}</tt>: <i>Regular expression</i>. This type
 *			represents a regular expression string, it is used to perform complex pattern
 *			selections in strings.
 *		<li><tt>{@link kTYPE_INT32}</tt>: <i>32 bit integer</i>. This type defines a 32 bit
 *			signed integer, this number ranges from <tt>−9,223,372,036,854,775,808</tt> to
 *			<tt>9,223,372,036,854,775,807</tt>.
 *		<li><tt>{@link kTYPE_INT32}</tt>: <i>32 bit integer</i>. This type defines a 32 bit
 *			signed integer, this number ranges from <tt>−2,147,483,648</tt> to
 *			<tt>2,147,483,647</tt>.
 *	 </ul>
 *	<li><i>Format types</i>: These types represent data formats or standards:
 *	 <ul>
 *		<li><tt>{@link kTYPE_META}</tt>: <i>Metadata</i>. This type represents the primitive
 *			meta data type, it is a generalised metadata type.
 *		<li><tt>{@link kTYPE_PHP}</tt>: <i>PHP</i>. This type represents the <tt>PHP</tt>
 *			serialized data format. This type is functionally identical to a
 *			{@link kTYPE_STRING} type, except that the contents are encoded.
 *		<li><tt>{@link kTYPE_JSON}</tt>: <i>JSON</i>. This type represents the <tt>JSON</tt>
 *			encoded data format. This type is functionally identical to a
 *			{@link kTYPE_STRING} type, except that the contents are encoded.
 *		<li><tt>{@link kTYPE_XML}</tt>: <i>XML</i>. This type represents the <tt>XML</tt>
 *			encoded data format. This type is functionally identical to a
 *			{@link kTYPE_STRING} type, except that the contents are encoded.
 *		<li><tt>{@link kTYPE_SVG}</tt>: <i>SVG</i>. This type represents the <tt>SVG</tt>
 *			encoded data format. This type is functionally identical to a
 *			{@link kTYPE_XML} type, except that the contents represent an image file.
 *	 </ul>
 *	<li><i>Structured types</i>: These types represent structured data types:
 *	 <ul>
 *		<li><tt>{@link kTYPE_STRUCT}</tt>: <i>Structure list</i>. This data type refers to a
 *			structure, it implies that the offset to which it refers to is a container of
 *			other offsets that will hold the actual data.
 *		<li><tt>{@link kTYPE_LSTRING}</tt>: <i>Language string list</i>. This type
 *			represents a string attribute that can be expressed in several languages, it is
 *			implemented as an array of elements in which the index represents the language
 *			code in which the string, stored in the element data, is expressed in.
 *		<li><tt>{@link kTYPE_STAMP}</tt>: <i>Time-stamp</i>. This type represents a native
 *			time-stamp data type, it holds the date, time and milliseconds.
 *	 </ul>
 *	<li><i>Enumerated types</i>: These types represent attributes holding controlled
 *		vocabularies:
 *	 <ul>
 *		<li><tt>{@link kTYPE_ENUM}</tt>: <i>Enumeration</i>. This value represents the
 *			enumeration data type, it represents an enumeration element or container.
 *			Enumerations represent a vocabulary from which one value must be chosen, this
 *			particular data type is used in {@link COntologyNode} objects: it indicates that
 *			the node refers to a controlled vocabulary scalar data type and that the
 *			enumerated set follows in the graph definition.
 *		<li><tt>{@link kTYPE_ENUM_SET}</tt>: <i>Enumerated set</i>. This value represents
 *			the enumerated set data type, it represents an enumerated set element or
 *			container. Sets represent a vocabulary from which one or more value must be
 *			chosen, this particular data type is used in {@link COntologyNode} objects: it
 *			indicates that the node refers to a controlled vocabulary array data type and
 *			that the enumerated set follows in the graph definition.
 *	 </ul>
 *	<li><i>Custom types</i>: These types represent custom data types belonging to specific
 *		realms:
 *	 </ul>
 *		<li><i>Cardinality types</i>: These types represent requirement and cardinal
 *			information that mixed with the data type provides information on whether the
 *			element is required or whether it represents an array of items:
 *		 <ul>
 *			<li><tt>{@link kTYPE_REQUIRED}</tt>: <i>Required</i>. This type indicates that
 *				the element is required, which means that it must be present in the object. If
 *				this type is missing, it means that the element is optional.
 *			<li><tt>{@link kTYPE_ARRAY}</tt>: <i>Array</i>. This type indicates that the
 *				attribute is a list of values, which means that the attribute is an array of
 *				elements of the provided data type. If this type is missing, it means that
 *				it is a scalar element.
 *		 </ul>
 *		<li><i>Relationship types</i>: These types represent relationship senses, they are
 *			used to indicate the relationship direction:
 *		 <ul>
 *			<li><tt>{@link kTYPE_RELATION_IN}</tt>: <i>Incoming relationship</i>. This type 
 *				indicates an incoming relationship, in other words, all the relationships
 *				that point to the current object.
 *			<li><tt>{@link kTYPE_RELATION_OUT}</tt>: <i>Outgoing relationship</i>. This type
 *				indicates an outgoing relationship, in other words, all the relationships
 *				that originate from the current object.
 *			<li><tt>{@link kTYPE_RELATION_ALL}</tt>: <i>All relationships</i>. This type
 *				indicates all relationships, both incoming and outgoing.
 *		 </ul>
 *		<li><i>Mongo types</i>: These types represent Mongo specific data types:
 *		 <ul>
 *			<li><tt>{@link kTYPE_MongoId}</tt>: <i>MongoId</i>. This type represents the
 *				MongoId data type, when serialised it will be encoded into the following
 *				structure:
 *			 <ul>
 *				<li><tt>{@link kTAG_CUSTOM_TYPE}</tt>: Will contain this constant.
 *				<li><tt>{@link kTAG_CUSTOM_DATA}</tt>: Will contain the HEX string ID.
 *			 </ul>
 *			<li><tt>{@link kTYPE_MongoCode}</tt>: <i>MongoCode</i>. This type represents the
 *				MongoCode data type, when serialised it will be encoded into the following
 *				structure:
 *			 <ul>
 *				<li><tt>{@link code}</tt>: The javascript code string.
 *				<li><tt>{@link scope}</tt>: The list of key/value pairs.
 *			 </ul>
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
 *	PRIMITIVE DATA TYPES																*
 *======================================================================================*/

/**
 * ANY.
 *
 * Any.
 *
 * This type represents a type wildcard, it qualifies an attribute that can take any type of
 * value.
 *
 * Version 1: (kTYPE_ANY)[:ANY]
 */
define( "kTYPE_ANY"	,							':ANY' );

/**
 * TEXT.
 *
 * String or text.
 *
 * This type defines a list of characters or a list of character strings.
 *
 * Version 1: (kTYPE_STRING)[:TEXT]
 */
define( "kTYPE_STRING",							':TEXT' );

/**
 * INT.
 *
 * Integer number.
 *
 * This type defines an integer signed number, this number does not have a decimal part and
 * has an indeterminate precision.
 *
 * Version 1: (kTYPE_INT)[:INT]
 */
define( "kTYPE_INT",							':INT' );

/**
 * FLOAT.
 *
 * Floating point number.
 *
 * This type defines a signed floating point numeric value of indeterminate precision.
 *
 * Version 1: (kTYPE_FLOAT)[:FLOAT]
 */
define( "kTYPE_FLOAT",							':FLOAT' );

/**
 * BOOLEAN.
 *
 * Boolean switch.
 *
 * This type defines a switch that can take two values: ON and OFF. By default we assume it
 * to to be represented by a number in which zero is OFF and any other value is ON. Other
 * representations are yes/no, true/false.
 *
 * Version 1: (kTYPE_BOOLEAN)[:BOOLEAN]
 */
define( "kTYPE_BOOLEAN",						':BOOLEAN' );

/*=======================================================================================
 *	CUSTOM PRIMITIVE DATA TYPES															*
 *======================================================================================*/

/**
 * BINARY.
 *
 * Binary string.
 *
 * This type represents a sequence of bytes. It is equivalent to the {@link kTYPE_STRING}
 * type, except that the string can hold elements of any value, while the
 * {@link kTYPE_STRING} type holds only text elements.
 *
 * Version 1: (kTYPE_BINARY)[:BINARY]
 */
define( "kTYPE_BINARY_STRING",					':BINARY' );

/**
 * DATE.
 *
 * Date string.
 *
 * This type represents a date in the form of a <tt>YYYYMMDD</tt> string in which missing
 * elements should be omitted. This means that if we don't know the day we can express that
 * date as <tt>YYYYMM</tt> and if we don't know the month we can express it as
 * <tt>YYYY</tt>.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that its
 * elements can only be digits and their structure is known.
 *
 * Version 1: (kTYPE_DATE)[:DATE-STRING']
 */
define( "kTYPE_DATE_STRING",					':DATE' );

/**
 * TIME.
 *
 * Time string.
 *
 * This type is a combination of the {@link kTYPE_DATE_STRING} type followed by a structure
 * of three elements representing the hours, minutes and seconds, <tt>YYYYMMDD HHMMSS</tt>.
 * Missing elements are omitted, this means that if you don't have the minutes you would
 * have a <tt>YYYYMMDD HH</tt> and if you don't have the time it would become and act as a
 * {@link kTYPE_DATE_STRING} type.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that its
 * elements can only be digits and their structure is known.
 *
 * Version 1: (kTYPE_TIME)[:DATE-STRING']
 */
define( "kTYPE_TIME_STRING",					':TIME' );

/**
 * REGEX.
 *
 * Regular expression.
 *
 * This type represents a regular expression string, it is used to perform complex pattern
 * selections in strings.
 *
 * Version 1: (kTYPE_REGEX)[:REGEX']
 */
define( "kTYPE_REGEX_STRING",					':REGEX' );

/**
 * 32.
 *
 * 32 bit integer.
 *
 * This type defines a 32 bit signed integer, this number ranges from −2,147,483,648 to
 * 2,147,483,647.
 *
 * Version 1: (kTYPE_INT32)[:INT32]
 */
define( "kTYPE_INT32",							':INT32' );

/**
 * 64.
 *
 * 64 bit integer.
 *
 * This type defines a 64 bit signed integer, this number ranges from
 * −9,223,372,036,854,775,808 to 9,223,372,036,854,775,807.
 *
 * Version 1: (kTYPE_INT64)[:INT64]
 */
define( "kTYPE_INT64",							':INT64' );

/*=======================================================================================
 *	STANDARD FORMAT TYPES																*
 *======================================================================================*/

/**
 * META.
 *
 * Metadata.
 *
 * This type represents the primitive meta data type, it is a generalised metadata type.
 *
 * Version 1: (kTYPE_META)[:META]
 */
define( "kTYPE_META",							':META' );

/**
 * PHP.
 *
 * PHP.
 *
 * This type represents the <tt>PHP</tt> serialised data format.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that the
 * contents are encoded.
 *
 * Version 1: (kTYPE_PHP)[:PHP]
 */
define( "kTYPE_PHP",							':PHP' );

/**
 * JSON.
 *
 * JSON.
 *
 * This type represents the <tt>JSON</tt> encoded data format.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that the
 * contents are encoded.
 *
 * Version 1: (kTYPE_JSON)[:JSON]
 */
define( "kTYPE_JSON",							':JSON' );

/**
 * XML.
 *
 * XML.
 *
 * This type represents the <tt>XML</tt> encoded data format.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that the
 * contents are encoded.
 *
 * Version 1: (kTYPE_XML)[:XML]
 */
define( "kTYPE_XML",							':XML' );

/**
 * SVG.
 *
 * SVG.
 *
 * This type represents the <tt>SVG</tt> encoded data format.
 *
 * This type is functionally identical to a {@link kTYPE_XML} type, except that the contents
 * represent an image file.
 *
 * Version 1: (kTYPE_SVG)[:SVG]
 */
define( "kTYPE_SVG",							':SVG' );

/*=======================================================================================
 *	STRUCTURED DATA TYPES																*
 *======================================================================================*/

/**
 * STRUCT.
 *
 * Structure.
 *
 * This data type refers to a structure, it implies that the offset to which it refers to
 * is a container of other offsets that will hold the actual data.
 *
 * Version 1: (kTYPE_STRUCT)[:STRUCT]
 */
define( "kTYPE_STRUCT",							':STRUCT' );

/**
 * LSTRING.
 *
 * Language string.
 *
 * This type represents a string attribute that can be expressed in several languages, it is
 * implemented as an array of elements in which the index represents the language code in
 * which the string, stored in the element data, is expressed in.
 *
 * Version 1: (kTYPE_LSTRING)[:LSTRING]
 */
define( "kTYPE_LSTRING",						':LSTRING' );

/**
 * STAMP.
 *
 * Time-stamp.
 *
 * This type represents a native time-stamp data type, it holds the date, time and
 * milliseconds.
 *
 * Version 1: (kTYPE_STAMP)[:TIME-STAMP]
 */
define( "kTYPE_STAMP",							':STAMP' );

/*=======================================================================================
 *	ENUMERATED TYPES																	*
 *======================================================================================*/

/**
 * ENUM.
 *
 * Enumeration.
 *
 * This value represents the enumeration data type, it represents an enumeration element or
 * container.
 *
 * Enumerations represent a vocabulary from which one value must be chosen, this particular
 * data type is used in {@link COntologyNode} objects: it indicates that the node refers to
 * a controlled vocabulary scalar data type and that the enumerated set follows in the graph
 * definition.
 *
 * Version 1: (kTYPE_ENUM)[:ENUM]
 */
define( "kTYPE_ENUM",							':ENUM' );

/**
 * SET.
 *
 * Enumerated set.
 *
 * This value represents the enumerated set data type, it represents an enumerated set
 * element or container.
 *
 * Sets represent a vocabulary from which one or more value must be chosen, this particular
 * data type is used in {@link COntologyNode} objects: it indicates that the node refers to
 * a controlled vocabulary array data type and that the enumerated set follows in the graph
 * definition.
 *
 * Version 1: (kTYPE_ENUM_SET)[:SET]
 */
define( "kTYPE_ENUM_SET",						':SET' );

/*=======================================================================================
 *	CARDINALITY TYPES																	*
 *======================================================================================*/

/**
 * REQUIRED.
 *
 * Required.
 *
 * This type indicates that the element is required, which means that it must be present in
 * the object.
 *
 * If this type is missing, it means that the element is optional.
 *
 * Version 1: (kTYPE_CARD_REQUIRED)[:REQUIRED]
 */
define( "kTYPE_REQUIRED",						':REQUIRED' );

/**
 * RESTRICTED.
 *
 * Restricted.
 *
 * This type applies mostly to enumerated sets, it indicates that the attribute is
 * restricted to an enumerated set.
 *
 * If this type is missing, it means that the attribute may take values not belonging to the
 * enumerated set.
 *
 * Version 1: (kTYPE_CARD_RESTRICTED)[:RESTRICTED]
 */
define( "kTYPE_RESTRICTED",						':RESTRICTED' );

/**
 * COMPUTED.
 *
 * Computed.
 *
 * This type indicates that the element is computed, which means that it is automatically
 * filled usually when committing the object.
 *
 * If this type is missing, it means that the attribute must be explicitly set.
 *
 * Version 1: (kTYPE_COMPUTED)[:COMPUTED]
 */
define( "kTYPE_COMPUTED",						':COMPUTED' );

/**
 * LOCKED.
 *
 * Locked.
 *
 * This type indicates that the element is locked, which means that it is not modifiable.
 * This means that the value cannot be changed once the object has been committed.
 *
 * If this type is missing, it means that the attribute can be explicitly modified.
 *
 * Version 1: (kTYPE_LOCKED)[:LOCKED]
 */
define( "kTYPE_LOCKED",							':LOCKED' );

/**
 * ARRAY.
 *
 * Array.
 *
 * This type indicates that the attribute is a list of values, which means that the
 * attribute is an array of elements of the provided data type.
 *
 * If this type is missing, it means that it is a scalar element.
 *
 * Version 1: (kTYPE_CARD_ARRAY)[:ARRAY]
 */
define( "kTYPE_ARRAY",							':ARRAY' );

/*=======================================================================================
 *	RELATIONSHIP TYPES																	*
 *======================================================================================*/

/**
 * RELATION-IN.
 *
 * Incoming relationship.
 *
 * This type indicates an incoming relationship, in other words, all the relationships that
 * point to the current object.
 *
 * Version 1: (kTYPE_RELATION_IN)[:RELATION-IN]
 */
define( "kTYPE_RELATION_IN",					':RELATION-IN' );

/**
 * OUTGOING.
 *
 * Outgoing relationship.
 *
 * This type indicates an outgoing relationship, in other words, all the relationships that
 * originate from the current object.
 *
 * Version 1: (kTYPE_RELATION_OUT)[:RELATION-OUT]
 */
define( "kTYPE_RELATION_OUT",					':RELATION-OUT' );

/**
 * ALL.
 *
 * All relationships.
 *
 * This type indicates all relationships, both incoming and outgoing.
 *
 * Version 1: (kTYPE_RELATION_ALL)[:RELATION-ALL]
 */
define( "kTYPE_RELATION_ALL",					':RELATION-ALL' );

/*=======================================================================================
 *	MONGO TYPES																			*
 *======================================================================================*/

/**
 * MongoId.
 *
 * This type represents the <tt>MongoId</tt> data type, when serialised it will be encoded
 * into the following structure:
 * <ul>
 *	<li><tt>{@link kTAG_CUSTOM_TYPE}</tt>: Will contain this constant.
 *	<li><tt>{@link kTAG_CUSTOM_DATA}</tt>: Will contain the HEX string ID.
 * </ul>
 *
 * Version 1: (kTYPE_MongoId)[:MongoId]
 */
define( "kTYPE_MongoId",						':MongoId' );

/**
 * MongoCode.
 *
 * This type represents the <tt>MongoCode</tt> data type, when serialised it will be encoded
 * into the following structure:
 * <ul>
 *	<li><tt>code</tt>: The javascript code string.
 *	<li><tt>scope</tt>: The list of key/value pairs.
 * </ul>
 *
 * Version 1: (kTYPE_MongoCode)[:MongoCode]
 */
define( "kTYPE_MongoCode",						':MongoCode' );


?>
