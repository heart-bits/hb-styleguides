<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  Sascha Wustmann 2016
 * @package    hb-styleguides
 * @license    GNU/LGPL
 * @filesource
 */

/**
 * Table tl_styleguides
 */
$GLOBALS['TL_DCA']['tl_styleguides'] = array
(

	// Config
	'config'   => array
	(
		'dataContainer'    => 'Table',
		'enableVersioning' => true,
		'sql'              => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
	),
	// List
	'list'     => array
	(
		'sorting'           => array
		(
			'mode'        => 2,
			'fields'      => array('company'),
			'flag'        => 1,
			'panelLayout' => 'filter;sort,search,limit'
		),
		'label'             => array
		(
			'fields' => array(
				'company',
			),
			'format' => '%s',
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations'        => array
		(
			'edit'   => array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_styleguides']['edit'],
				'href'  => 'act=edit',
				'icon'  => 'edit.gif'
			),
			'delete' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_styleguides']['delete'],
				'href'       => 'act=delete',
				'icon'       => 'delete.gif',
				'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show'   => array
			(
				'label'      => &$GLOBALS['TL_LANG']['tl_styleguides']['show'],
				'href'       => 'act=show',
				'icon'       => 'show.gif',
				'attributes' => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'  => array('company'),
		'default'       => '{company_legend},company,logo,logo_negative,alt,title,size;{color_legend},color;{type_legend},type;',
	),

	'subpalettes' => array
	(

	),

	// Fields
	'fields'   => array
	(
		'id'     => array
		(
			'sql' => "int(10) unsigned NOT NULL auto_increment"
		),

		'tstamp' => array
		(
			'sql' => "int(10) unsigned NOT NULL default '0'"
		),

		'company'  => array
		(
			'label'		=> &$GLOBALS['TL_LANG']['tl_styleguides']['company'],
			'exclude' => true,
			'sorting'   => true,
			'flag'      => 1,
			'search'    => true,
			'sql' => 'int(100) unsigned NULL',
			'foreignKey' => 'tl_companies.CONCAT(company," (",geocoderAddress,")")',
			'inputType'	=> 'select',
			'eval' => array(
        	'includeBlankOption' => true,
					'tl_class' => 'w50 clr'
			)
		),

		'logo'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_styleguides']['logo'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'load_callback' => array(
				array('tl_styleguides', 'setSingleSrcFlags')
			),
			'sql'                     => "binary(16) NULL"
		),

		'logo_negative'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_styleguides']['logo_negative'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'load_callback' => array(
				array('tl_styleguides', 'setSingleSrcFlags')
			),
			'sql'                     => "binary(16) NULL"
		),

		'alt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_styleguides']['alt'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),

		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_styleguides']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),

		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_styleguides']['size'],
			'exclude'                 => true,
			'inputType'               => 'imageSize',
			'options'                 => System::getImageSizes(),
			'reference'               => &$GLOBALS['TL_LANG']['MSC'],
			'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),

		'color'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_styleguides']['color'],
			'exclude'                 => true,
			'inputType'               => 'listWizard',
			'eval'                    => array('allowHtml'=>true),
			'sql'                     => "blob NULL"
		),

		'type'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_styleguides']['type'],
			'exclude'                 => true,
			'inputType'               => 'listWizard',
			'eval'                    => array('allowHtml'=>true),
			'sql'                     => "blob NULL"
		),
	)
);

/**
 * Class tl_styleguides
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  2015 Sascha Wustmann
 * @author     Sascha Wustmann <http://saschawustmann.com>
 * @package
 */
class tl_styleguides extends \Backend
{
	/**
	 * Dynamically add flags to the "singleSRC" field
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setSingleSrcFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
			$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
		}

		return $varValue;
	}
}
