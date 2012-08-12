<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/workspaces/Classes/Service/GridData.php'] =
	t3lib_extMgm::extPath($_EXTKEY) . 'Classes/XClasses/GridData.php';
$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/workspaces/Classes/Service/Workspaces.php'] =
	t3lib_extMgm::extPath($_EXTKEY) . 'Classes/XClasses/Workspaces.php';
?>