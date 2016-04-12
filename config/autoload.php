<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package Styleguides
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Contao\Styleguide'    				 => 'system/modules/hb-styleguides/elements/Styleguide.php'
));


/**
 * Register the templates
 */
 TemplateLoader::addFiles(array
 (
 	'ce_styleguide' => 'system/modules/hb-styleguides/templates',
 ));
