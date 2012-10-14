<?php

/**
 * Compile ISO codes.
 *
 * This file contains the routine to compile the ISO codes from the iso-codes brew package..
 *
 *	@package	MyWrapper
 *	@subpackage	Data
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *																						*
 *										ISOCodes.php									*
 *																						*
 *======================================================================================*/

//
// Local includes.
//
require_once( 'ISOCodes.inc.php' );

//
// File functions.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION.'/file.php' );

//
// Parser functions.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION.'/parsing.php' );

		

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ISODecodePOFiles																*
	 *==================================================================================*/

	/**
	 * <h4>Decode PO files</h4>
	 *
	 * This method will parse all MO files, decode them into PO files and write to the
	 * {@link kISO_FILE_PO_DIR} directory the PHP serialised decode array.
	 */
	function ISODecodePOFiles()
	{
		//
		// Init local storage.
		//
		$_SESSION[ kISO_LANGUAGES ] = Array();
		$_SESSION[ kISO_FILES ]
			= array( kISO_FILE_639, kISO_FILE_639_3, kISO_FILE_3166,
					 kISO_FILE_3166_2, kISO_FILE_4217, kISO_FILE_15924 );
		
		//
		// Point to MO files.
		//
		$_SESSION[ kISO_FILE_MO_DIR ] = kISO_CODES_PATH.kISO_CODES_PATH_LOCALE;
		$moditer = new DirectoryIterator( $_SESSION[ kISO_FILE_MO_DIR ] );

		//
		// Create temporary directory.
		//
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
// !!! MILKO - For testing purposes.
$_SESSION[ kISO_FILE_PO_DIR ] = '/Library/WebServer/Library/PHPWrapper/data/cache';
		
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
		
	} // ISODecodePOFiles.

	 
	/*===================================================================================
	 *	ISOBuildXMLFiles																*
	 *==================================================================================*/

	/**
	 * <h4>Build XML files</h4>
	 *
	 * This method will generate the XML files completed with all the translations and save
	 * it at the top level of the cache directory.
	 */
	function ISOBuildXMLFiles()
	{
		//
		// Iterate known fiels.
		//
		echo( "    - Generating XML files\n" );
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
				case kISO_FILE_639:
					ISOBuild639XML();
					break;
			}
		
		} // Iterating the files.
		
	} // ISOBuildXMLFiles.

	 
	/*===================================================================================
	 *	ISOBuild639XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Build XML files</h4>
	 *
	 * This method will generate the XML files completed with all the translations and save
	 * it at the top level of the cache directory.
	 */
	function ISOBuild639XML()
	{
		//
		// Init local storage.
		//
		$path = kISO_CODES_PATH.kISO_CODES_PATH_XML."/".kISO_FILE_639.".xml";
		
		//
		// Open input XML file.
		//
		$xml_in = simplexml_load_file( $path );
		
		//
		// Open destination XML file.
		//
		$xml_out = new SimpleXMLElement( '<'.kISO_FILE_639.'></'.kISO_FILE_639.'>' );
		
		//
		// Iterate
		
	} // ISOBuild639XML.

?>
