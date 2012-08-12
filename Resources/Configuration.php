<?php
return array(
	'objects' => array(
		'Tx_Extbase_Persistence_Storage_BackendInterface' => array(
			'className' => 'Tx_Extbase_Persistence_Storage_Typo3DbBackend',
		),
	),
	'mvc' => array(
		'requestHandlers' => array(
			'Tx_Extbase_MVC_Web_FrontendRequestHandler' => 'Tx_Extbase_MVC_Web_FrontendRequestHandler',
			'Tx_Extbase_MVC_Web_BackendRequestHandler' => 'Tx_Extbase_MVC_Web_BackendRequestHandler',
		),
	),
	'persistence'=> array(
		'enableAutomaticCacheClearing' => 1,
		'updateReferenceIndex' => 0,
		'classes' => array(
			'Tx_Extbase_Domain_Model_FrontendUser' => array(
				'mapping' => array(
					'tableName' => 'fe_users',
					'recordType' => 'Tx_Extbase_Domain_Model_FrontendUser',
					'columns' => array(
						'lockToDomain' => array(
							'mapOnProperty' => 'lockToDomain',
						),
					),
				),
			),
			'Tx_Extbase_Domain_Model_FrontendUserGroup' => array(
				'mapping' => array(
					'tableName' => 'fe_groups',
					'recordType' => 'Tx_Extbase_Domain_Model_FrontendUserGroup',
					'columns' => array(
						'lockToDomain' => array(
							'mapOnProperty' => 'lockToDomain',
						),
					),
				),
			),
		),
	),
);
?>