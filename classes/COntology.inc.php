<?php

/*=======================================================================================
 *																						*
 *									COntology.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntology} definitions.
 *
 *	This file contains common definitions used by the {@link COntology} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *	SESSION CACHE OFFSETS																*
 *======================================================================================*/

/**
 * Nodes.
 *
 * This tag is the offset of the nodes cache, it is an array in which the key is the term
 * global identifier and the value is the node identifier.
 */
define( "kOFFSET_NODES",						'_NODES_' );

/*=======================================================================================
 *	TEMPLATE FILE OPTIONS																*
 *======================================================================================*/

/**
 * Creator.
 *
 * This tag indicates the file creator.
 */
define( "kOFFSET_TEMPLATE_CREATOR",				'setCreator' );

/**
 * Last modified by.
 *
 * This tag indicates the last person who modified the file.
 */
define( "kOFFSET_TEMPLATE_MODIFIER",			'setLastModifiedBy' );

/**
 * Title.
 *
 * This tag indicates the file title.
 */
define( "kOFFSET_TEMPLATE_TITLE",				'setTitle' );

/**
 * Subject.
 *
 * This tag indicates the file subject.
 */
define( "kOFFSET_TEMPLATE_SUBJECT",				'setSubject' );

/**
 * Description.
 *
 * This tag indicates the file description.
 */
define( "kOFFSET_TEMPLATE_DESCRIPTION",			'setDescription' );

/**
 * Keywords.
 *
 * This tag indicates the file keywords (space separated).
 */
define( "kOFFSET_TEMPLATE_KEYWORDS",			'setKeywords' );

/**
 * Category.
 *
 * This tag indicates the file category.
 */
define( "kOFFSET_TEMPLATE_CATEGORY",			'setCategory' );

/*=======================================================================================
 *	TEMPLATE FORMAT OPTIONS																*
 *======================================================================================*/

/**
 * Excel 2007 one data worksheet.
 *
 * This tag indicates an Excel 2007 file with one worksheet for data starting on the fourth
 * row.
 */
define( "kOFFSET_TEMPLATE_EXCEL2007_1",			'1_Excel2007' );

/**
 * Excel 2007 metadata abd data worksheets.
 *
 * This tag indicates an Excel 2007 file with one worksheet for metadata and one for data
 * starting on the second row.
 */
define( "kOFFSET_TEMPLATE_EXCEL2007_2",			'2_Excel2007' );

?>
