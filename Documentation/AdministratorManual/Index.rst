============================
Administrator Manual
============================

Target group: **Administrators**

Installation
=============

* Install the extension with the key **roq_redirect** from the Extension Manager
* Include the **Redirect (roq_redirect)** static template
* Adding privileges to the editors
* And you're ready to go!!!

.. figure:: ../Images/staticTemplate62.PNG
    :alt: Static template
    :align: left
    :name: Static template

**Image 6:** Static template


Default configuration TYPO3
=======================

The redirect extension assume that the default setup in TYPO3 is correct:

* Domain records are correctly set
* config.baseURL is set

Domain records
^^^^^^^^^^^^^^^^^^

When you have multiple domain records for one installation, always put the leading domain record above the other domain
records.

.. figure:: ../Images/domainRecords62.PNG
    :alt: Static template
    :align: left
    :name: Static template

**Image 7:** Domain records

config.baseURL
^^^^^^^^^^^^^^^^^^

Set always the config.baseURL in TypoScript.