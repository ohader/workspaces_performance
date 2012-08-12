<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2012 Oliver Hader <oliver.hader@typo3.org>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @author Oliver Hader <oliver.hader@typo3.org>
 * @package EXT:workspaces_performance
 */
class ux_tx_Workspaces_Service_Workspaces extends tx_Workspaces_Service_Workspaces implements t3lib_Singleton {
	/**
	 * retrieves the available workspaces from the database and checks whether
	 * they're available to the current BE user
	 *
	 * @return	array	array of worspaces available to the current user
	 */
	public function getAvailableWorkspaces() {
		$availableWorkspaces = array();

			// add default workspaces
		if ($GLOBALS['BE_USER']->checkWorkspace(array('uid' => (string) self::LIVE_WORKSPACE_ID))) {
			$availableWorkspaces[self::LIVE_WORKSPACE_ID] = self::getWorkspaceTitle(self::LIVE_WORKSPACE_ID);
		}
		if ($GLOBALS['BE_USER']->checkWorkspace(array('uid' => (string) self::DRAFT_WORKSPACE_ID))) {
			$availableWorkspaces[self::DRAFT_WORKSPACE_ID] = self::getWorkspaceTitle(self::DRAFT_WORKSPACE_ID);
		}

			// Add custom workspaces (selecting all, filtering by BE_USER check):
		foreach (Tx_WorkspacesPerformance_Utility_WorkspaceUtility::getInstance()->findAll('title') as $workspace) {
			if ($GLOBALS['BE_USER']->checkWorkspace($workspace)) {
				$availableWorkspaces[$workspace['uid']] = htmlspecialchars($workspace['title']);
			}
		}

		return $availableWorkspaces;
	}

	/**
	 * Find the title for the requested workspace.
	 *
	 * @param integer $wsId
	 * @return string
	 */
	public static function getWorkspaceTitle($wsId) {
		return Tx_WorkspacesPerformance_Utility_WorkspaceUtility::getInstance()->getTitle($wsId);
	}

	/**
	 * Remove all records which are not permitted for the user
	 *
	 * @param array $recs
	 * @param string $table
	 * @return array
	 */
	protected function filterPermittedElements($recs, $table) {
		$pageUtility = Tx_WorkspacesPerformance_Utility_PageUtility::getInstance();
		$checkField = ($table == 'pages') ? 'uid' : 'wspid';
		$permittedElements = array();
		if (is_array($recs)) {
			foreach ($recs as $rec) {
				$page = $pageUtility->findById($rec[$checkField]);
				if ($GLOBALS['BE_USER']->doesUserHaveAccess($page, 1) && $this->isLanguageAccessibleForCurrentUser($table, $rec)) {
					$permittedElements[] = $rec;
				}
			}
		}
		return $permittedElements;
	}

	/**
	 * Determine whether a specific page is new and not yet available in the LIVE workspace
	 *
	 * @static
	 * @param integer $id Primary key of the page to check
	 * @param $language Language for which to check the page
	 * @return boolean
	 */
	public static function isNewPage($id, $language = 0) {
		$isNewPage = FALSE;
			// If the language is not default, check state of overlay
		if ($language > 0) {
			$isNewPage = parent::isNewPage($id, $language);

			// Otherwise check state of page itself
		} else {
			$rec = Tx_WorkspacesPerformance_Utility_PageUtility::getInstance()->findById($id);
			if (is_array($rec)) {
				$isNewPage = (int) $rec['t3ver_state'] === 1;
			}
		}
		return $isNewPage;
	}
}

?>