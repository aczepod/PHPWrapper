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
				case kISO_FILE_639_3:
					ISOBuild6393XML();
					break;
				case kISO_FILE_639:
					ISOBuild639XML();
					break;
			}
		
		} // Iterating the files.
		
	} // ISOBuildXMLFiles.

	 
	/*===================================================================================
	 *	ISOBuild6393XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Build XML files</h4>
	 *
	 * This method will generate the XML files completed with all the translations and save
	 * it at the top level of the cache directory.
	 */
	function ISOBuild6393XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_639_3.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Load namespaces.
			//
			$part1_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639, kONTOLOGY_ISO_639_1 ) ),
					NULL,
					TRUE );
			$part2_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639, kONTOLOGY_ISO_639_2 ) ),
					NULL,
					TRUE );
			$part3_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639, kONTOLOGY_ISO_639_3 ) ),
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$part1_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$part1_ns,
					TRUE )[ 0 ];
			$part2_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$part2_ns,
					TRUE )[ 0 ];
			$part3_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
					$part3_ns,
					TRUE )[ 0 ];
			
			//
			// Load attribute tags.
			//
			$inv_name_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_3_INVNAME ) ),
					NULL,
					TRUE )[ 0 ];
			$status_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_3_status ) ),
					NULL,
					TRUE )[ 0 ];
			$scope_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_3_scope ) ),
					NULL,
					TRUE )[ 0 ];
			$type_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO, kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_3_type ) ),
					NULL,
					TRUE )[ 0 ];

			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_639_3_entry'} as $record )
			{
				//
				// Init term.
				//
				$part3_term = new COntologyTerm();
				$part3_term->LID( (string) $record[ 'id' ] );
				$part3_term->NS( $part3_ns );
				$part3_term->Label( 'en', (string) $record[ 'name' ] );
				$part3_term->Description( 'en', (string) $record[ 'reference_name' ] );
				if( ($tmp = $record[ 'status' ]) !== NULL )
					$part3_term[ $status_tag[ kOFFSET_NID ] ] = (string) $tmp;
				if( ($tmp = $record[ 'scope' ]) !== NULL )
					$part3_term[ $scope_tag[ kOFFSET_NID ] ] = (string) $tmp;
				if( ($tmp = $record[ 'type' ]) !== NULL )
					$part3_term[ $type_tag[ kOFFSET_NID ] ] = (string) $tmp;
				if( ($tmp = $record[ 'inverted_name' ]) !== NULL )
					ManageTypedOffset( $part3_term, (string) $inv_name_tag[ kOFFSET_NID ],
						  			   kOFFSET_LANGUAGE, kOFFSET_DATA,
						  			   'en', (string) $tmp );
				
				//
				// Iterate languages.
				//
				foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
				{
					//
					// Check language key file.
					//
					$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
								.kISO_FILE_639_3.'.serial';
					if( is_file( $file_path ) )
					{
						//
						// Instantiate keys array.
						//
						$keys = unserialize( file_get_contents( $file_path ) );
						
						//
						// Update label.
						//
						if( ($string = $part3_term->Label( 'en' )) !== NULL )
						{
							if( array_key_exists( $string, $keys ) )
								$part3_term->Label( $language, $keys[ $string ] );
						}
						
						//
						// Update description.
						//
						if( ($string = $part3_term->Description( 'en' )) !== NULL )
						{
							if( array_key_exists( $string, $keys ) )
								$part3_term->Description( $language, $keys[ $string ] );
						}
						
						//
						// Update inverted name.
						//
						if( $part3_term->offsetExists( (string) $inv_name_tag[ kOFFSET_NID ] ) )
						{
							$string = ManageTypedOffset(
										$part3_term, (string) $inv_name_tag[ kOFFSET_NID ],
										kOFFSET_LANGUAGE, kOFFSET_DATA,
										'en' );
							if( array_key_exists( $string, $keys ) )
								ManageTypedOffset(
									$part3_term, (string) $inv_name_tag[ kOFFSET_NID ],
									kOFFSET_LANGUAGE, kOFFSET_DATA,
									$language, $keys[ $string ] );
						}
					
					} // Key file exists.
				
				} // Iterating languages.
				
				//
				// Create node, relate to parent and commit.
				//
				$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
					$part3_node
						= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
							$part3_term ),
					$part3_parent );
				
				//
				// Handle part 1 code.
				//
				if( $record[ 'part1_code' ] !== NULL )
				{
					//
					// Init term.
					//
					$part1_term = new COntologyTerm();
					$part1_term->LID( (string) $record[ 'part1_code' ] );
					$part1_term->NS( $part1_ns );
					$part1_term->Term( $part3_term );					
					
					//
					// Create node, relate to parent and commit.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$part1_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
								$part1_term ),
						$part1_parent );
				
				} // Has part 1 code.
				
				//
				// Handle part 2 code.
				//
				if( $record[ 'part2_code' ] !== NULL )
				{
					//
					// Init term.
					//
					$part2_term = new COntologyTerm();
					$part2_term->LID( (string) $record[ 'part2_code' ] );
					$part2_term->NS( $part2_ns );
					$part2_term->Term( $part3_term );					
					
					//
					// Create node, relate to parent and commit.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$part1_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
								$part2_term ),
						$part2_parent );
				
				} // Has part 2 code.
			
			} // Iterating records.
		
		} // Loaded file.

	} // ISOBuild6393XML.

	 
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
		
	} // ISOBuild639XML.

?>
