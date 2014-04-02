.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

=====================
Changelog
=====================

1.0.0 2014/04/03
==========

Breaking/Important changes
-----------
::

	* Added support for TYPO3 CMS 6.2 LTS
	* Changes in database structure, an update in Extension Manager / Compare in Install Tool is needed
		- added type field for different types of redirect
		- added external_url field for redirect type external url
		- added internal file field for redirect type internal file
		- added additional_url field for redirect internal page
		- added counter field for total hits of the redirect

Features
-----------
::

	* Added types to redirect: internal page, external url or internal file
	* Counter for total hits of the redirect
	* Add additional params for linking inside a part of the internal website page
	* Automatic authorization per site for editors based on mounted sites
	* Warning if redirect source url already exist

Miscellaneous
-----------
::

	* Improved documentation

0.0.0 2014/03/05
==========

Features
-----------
::

	* Backend module to manage redirects
	* Redirect to internal page
	* Multisite support
	* Multilanguage support
	* HTTP status 301, 302, 303 and 307

Miscellaneous
-----------
::

	* ReST documentation