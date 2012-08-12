<?php

########################################################################
# Extension Manager/Repository config file for ext "workspaces_performance".
#
# Auto generated 12-08-2012 18:53
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Workspace Performance',
	'description' => 'Optimizes performance of TYPO3 Workspaces',
	'category' => 'be',
	'author' => 'Oliver Hader',
	'author_email' => 'oliver.hader@typo3.org',
	'shy' => '',
	'dependencies' => 'workspaces,version',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-0.0.0',
			'workspaces' => '4.5.0-0.0.0',
			'version' => '4.5.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:14:{s:16:"ext_autoload.php";s:4:"6ccb";s:21:"ext_conf_template.txt";s:4:"4f1f";s:12:"ext_icon.gif";s:4:"b4e6";s:17:"ext_localconf.php";s:4:"9808";s:14:"ext_tables.php";s:4:"af41";s:21:"Classes/Bootstrap.php";s:4:"9e15";s:53:"Classes/Configuration/BackendConfigurationManager.php";s:4:"fb04";s:31:"Classes/Utility/PageUtility.php";s:4:"6e88";s:31:"Classes/Utility/SortUtility.php";s:4:"472f";s:32:"Classes/Utility/StageUtility.php";s:4:"40ea";s:36:"Classes/Utility/WorkspaceUtility.php";s:4:"d9c3";s:29:"Classes/XClasses/GridData.php";s:4:"3247";s:31:"Classes/XClasses/Workspaces.php";s:4:"2302";s:27:"Resources/Configuration.php";s:4:"4498";}',
	'suggests' => array(
	),
);

?>