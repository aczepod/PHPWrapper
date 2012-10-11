#!/bin/bash

#####################################################################################
#                                                                                   #
# Script for initiaslising default ontologies.								        #
#																					#
# Calls:																			#
#	DefaultOntology.php																#
#	StandardsOntology.php															#
#	LandraceDescriptors.php															#
#                                                                                   #
#####################################################################################

echo "********************************************************************************"
echo "*                           Building Ontologies                                *"
echo "********************************************************************************"

###
# Execute.
###
php -f /Library/WebServer/Library/PHPWrapper/data/DefaultOntology.php
php -f /Library/WebServer/Library/PHPWrapper/data/LandraceDescriptors.php

echo
echo "=> Done"
echo
