<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_roqredirect_domain_model_redirect'] = array(
	'ctrl' => $TCA['tx_roqredirect_domain_model_redirect']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, hidden, redirect_url, redirect_to, http_code, type, external_url, internal_file, additional_url, internal_file, external_url, counter',
	),
	'types' => array(
		'0' => array('showitem' => 'redirect_url;;paletteCore, redirect_to;;paletteRedirectToInternalPage, http_code
		    ,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
        '1' => array('showitem' => 'redirect_url;;paletteCore, external_url, http_code
            ,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
        '2' => array('showitem' => 'redirect_url;;paletteCore, internal_file, http_code
            ,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
        'paletteCore' => array(
            'showitem' => 'hidden;;1, type, sys_language_uid;;;;1-1-1, counter,',
            'canNotCollapse' => TRUE
        ),
        'paletteRedirectToInternalPage' => array(
            'showitem' => 'additional_url,',
            'canNotCollapse' => TRUE
        ),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_roqredirect_domain_model_redirect',
				'foreign_table_where' => 'AND tx_roqredirect_domain_model_redirect.pid=###CURRENT_PID### AND tx_roqredirect_domain_model_redirect.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'redirect_url' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.redirect_url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required,nospace,uniqueInPid'
			),
		),
		'redirect_to' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.redirect_to',
			'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => '',
                'show_thumbs' => '1',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                        'default' => array(
                            'searchWholePhrase' => 1,
                            'maxPathTitleLength' => 40,
                            'maxItemsInResultList' => 5
                        ),
                        'pages' => array(
                            'searchCondition' => 'doktype=1',
                        ),
                    ),
                ),
			),
		),
		'http_code' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.http_code',
			'config' => array(
				'type' => 'select',
				'items' => array(
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.code301', 301),
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.code302', 302),
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.code303', 303),
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.code307', 307),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
        'type' => array(
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.type',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.type.0', 0),
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.type.1', 1),
                    array('LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.type.2', 2),
                ),
                'size' => 1,
                'maxitems' => 1,
            )
        ),
        'additional_url' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.additional_url',
            'config' => array(
                'type' => 'input',
                'size' => 25,
                'eval' => 'trim,nospace'
            ),
        ),
        'external_url' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.external_url',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'required'
            ),
        ),
        'counter' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.counter',
            'config' => array(
                'type' => 'none',
                'size' => 5,
            ),
        ),
        'internal_file' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:roq_redirect/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.internal_file',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'internal_file',
                array(
                    'appearance' => array(
                        'createNewRelationLinkTitle' => 'LLL:EXT:roq_hv_base/Resources/Private/Language/locallang_db.xlf:tx_roqredirect_domain_model_redirect.internal_file',
                    ),
                    'minitems' => 1,
                    'maxitems' => 1,
                    'appearance' => array(
                        'useSortable' => FALSE,
                        'enabledControls' => array(
                            'dragdrop' => FALSE,
                            'localize' => FALSE,
                            'hide' => FALSE,
                        ),
                    ),
                )
            ),
        ),
	),
);

?>