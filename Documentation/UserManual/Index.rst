.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

=====================
Users manual
=====================

Target group: **Editors**

Manage redirect records
-----------
Redirects are directly manageable in the TYPO3 backend menu with the redirect web module.

If you have a multi-site environment you can specify redirect for multiple websites. In this case you can choose and select the site for which you want to add redirects.
The selected site will be used as the base url for the redirect that you add. See Image 2: Select site.

**Example:** If you select the site *"www.redirect.com"* and add a redirect of the type *"Internal Page"* (see Image 3) the
url *"http://www.redirect.com/custom"* will redirect to *"http://www.redirect.com/de/customizing.html#c14"*.

.. figure:: ../Images/selectSite62.PNG
    :alt: Select site
    :align: left
    :name: Select site

**Image 2:** Select site

In the redirect module you can create three different redirect types: "Internal Page", "External url" and "Internal File".
* **Internal Page:** redirect a url to an existing TYPO3 page (see Image 3)
* **External url:** redirect to an external type (see Image 4)
* **Internal File:** redirect to an existing internal file in the FAL (see image 5).

Redirect type Internal Page
^^^^^^^^^^

.. figure:: ../Images/internalPage62.PNG
    :alt: Redirect record internal page
    :align: left
    :name: Redirect record internal page

**Image 3:** Redirect record internal page

Redirect type External url
^^^^^^^^^^

.. figure:: ../Images/externalUrl62.PNG
    :alt: Redirect record external url
    :align: left
    :name: Redirect record external url

**Image 4:** Redirect record external url

Redirect type Internal File
^^^^^^^^^^

.. figure:: ../Images/internalFile62.PNG
    :alt: Redirect record internal file
    :align: left
    :name: Redirect record internal file

**Image 5:** Redirect record internal file

Redirect record fields
-----------

See the table below for an overview of all redirect record main fields:

.. t3-field-list-table::
 :header-rows: 1

 - :Field:
    Field:

   :Description:
    Description:

   :Types Redirect:
	Types Redirect:


 - :Field:
    **Redirect url**

   :Description:
    The incoming request url after the domain. For example, you fill in *"about"* in the field redirect url for the
    incoming request *"http://www.domain.com/about"*.

   :Types Redirect:
	Internal page, external url and internal file.


 - :Field:
    **HTTP Status**

   :Description:
    The HTTP state of the redirect. It can be a 301 (Moved Permanently), 302 (Found), 303 (See other) and 307
    (Temporary redirect).

   :Types Redirect:
   	Internal page, external url and internal file.


 - :Field:
    **Total hits**

   :Description:
    Redirect hit counter number. This is not editable.

   :Types Redirect:
   	Internal page, external url and internal file.


 - :Field:
    **Redirect to**

   :Description:
    Select the destination of the redirect. The destination of the redirect is a normal TYPO3 page that you can select
    with the selector or the wizard.

   :Types Redirect:
   	Internal page


 - :Field:
	**Addtional params**

   :Description:
	Add additional params to the internal page for anchor linking. For example *"#c8"*

   :Types Redirect:
	Internal page


 - :Field:
	**External url**

   :Description:
	The external url to redirect to. For example *"http://www.google.com"*.

   :Types Redirect:
	External url


 - :Field:
	**Internal file**

   :Description:
	The internal file from FAL to redirect to. It saves the file reference id.

   :Types Redirect:
	Internal file



