.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

=====================
Introduction
=====================

What does it do?
-----------

Backend module for managing redirects. This extension provides a backend module for managing redirects for
multiple sites and languages. The extension hooks into a preprocess request and checks for a redirect record with the
same url as the requested url. A redirect will be initiated to the defined redirect destination if a redirect record exists for this request.

.. figure:: ../Images/redirectModule62.PNG
    :alt: Redirect module
    :align: left
    :name: Redirect module

**Image 1:** Redirect backend module

Features
-----------

* Redirect to internal page, external url or internal file
* Redirect hit counter
* Support for anchor linking
* Checks per-site editor authorization in back-end based on db mounts
* Checks if a redirect source url already exists

Background
-----------

* Compatible with TYPO3 CMS 6.1.X and TYPO3 CMS 6.2.X LTS
* The extension is based on Extbase and Fluid
* Documentation is based on ReST
