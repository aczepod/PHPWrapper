<?php

/*=======================================================================================
 *																						*
 *								LandracesPassport.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	Landraces passport ontology definitions.
 *
 *	This file contains common definitions used by the landraces passport ontology.
 *
 *	@package	MyWrapper
 *	@subpackage	Data
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 26/10/2012
 */

/*=======================================================================================
 *	ROOT																				*
 *======================================================================================*/

/**
 * Landrace descriptors.
 *
 * Descriptors For Web-Enabled National In Situ Landrace (LR) Inventories.
 */
define( "kLR_ROOT",								'LR' );

/*=======================================================================================
 *	MAIN CATEGORIES																		*
 *======================================================================================*/

/**
 * INVENTORY IDENTIFICATION.
 *
 * Descriptors identifying the inventory and origin of the landrace or population.
 */
define( "KLR_INVENTORY",						'LR:INVENTORY' );

/**
 * TAXON IDENTIFICATION.
 *
 * Descriptors identifying the scientific nomenclature of the landrace or population.
 */
define( "KLR_TAXONOMY",							'LR:TAXONOMY' );

/**
 * LANDRACE/POPULATION IDENTIFICATION.
 *
 * Descriptors identifying the specific landrace or population.
 */
define( "KLR_IDENTIFICATION",					'LR:IDENTIFICATION' );

/**
 * SITE/LOCATION IDENTIFICATION.
 *
 * Descriptors identifying the location of the landrace or population.
 */
define( "KLR_SITE",								'LR:SITE' );

/**
 * THE FARMER (I.E. THE MAINTAINER).
 *
 * Descriptors identifying the maintainer of the landrace or population.
 */
define( "KLR_MAINTAINER",						'LR:MAINTAINER' );

/**
 * THE LANDRACE.
 *
 * Descriptors describing the landrace.
 */
define( "KLR_LANDRACE",							'LR:LANDRACE' );

/**
 * CONSERVATION AND MONITORING.
 *
 * Descriptors covering conservation and maintenance of the landrace or population.
 */
define( "KLR_MONITOR",							'LR:MONITOR' );

/**
 * CONSERVATION AND MONITORING.
 *
 * Descriptors collecting comments on the landrace or population.
 */
define( "KLR_REMARKS",							'LR:REMARKS' );

?>
