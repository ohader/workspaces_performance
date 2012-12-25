..  Editor configuration
	...................................................
	* utf-8 with BOM as encoding
	* tab indent with 4 characters for code snippet.
	* optional: soft carriage return preferred.

.. Includes roles, substitutions, ...
.. include:: _IncludedDirectives.rst

===========================================================
|extension_name|
===========================================================

:Extension name: |extension_name|
:Extension key: |extension_key|
:Version: |extension_version|
:Description: manuals covering TYPO3 extension "|extension_name|"
:Language: en
:Author: |author|
:Creation: |creation_date|
:Generation: |time|
:Licence: Open Content License available from `www.opencontent.org/opl.shtml <http://www.opencontent.org/opl.shtml>`_

The content of this document is related to TYPO3, a GNU/GPL CMS/Framework available from `www.typo3.org
<http://www.typo3.org/>`_


**Table of Contents**

.. toctree::
	:maxdepth: 2

	ProjectInformation
	AdministratorManual
	DeveloperCorner

.. STILL TO ADD IN THIS DOCUMENT
	@todo: add section for screen-shot of Extension Manager configuration and workspace module view


What does it do?
===========================================================

This extension overrides several functionality in the TYPO3 Core with
the aim to improve performance of the workspace module in the back-end.

This extension is dedicated to work with TYPO3 4.5 to 4.7.

* the calculation of changes in percentage is disabled
* fetching and calculating permissions and page root-lines is optimized
* Extbase for this module bootstrap is overridden by default values and thus optimized
