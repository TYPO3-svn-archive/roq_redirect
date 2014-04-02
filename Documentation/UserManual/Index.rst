.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

=====================
Users manual
=====================

Target group: **Editors**

Redirect records
-----------

Selecting site
^^^^^^^^^^
You can manage all redirects with the redirect backend module in TYPO3. If you have a multisite environment than you have to select
the site before adding a redirect. The selected site is the base url of the actual redirect.

.. figure:: ../Images/selectSite62.PNG
    :alt: Select site
    :align: left
    :name: Select site

**Image 2:** Select site

Redirect record
^^^^^^^^^^

After selecting the site in the selectbox you can add, update and remove your redirects for a specific site. So you
can redirect all incoming requests for a specific site to an internal page, external url or internal file. So the first thing
you need to do is choose a redirect type.

Redirect type Internal Page
""""""""""

.. figure:: ../Images/internalPage62.PNG
    :alt: Redirect record internal page
    :align: left
    :name: Redirect record internal page

**Image 3:** Redirect record internal page

Redirect type External url
""""""""""

.. figure:: ../Images/externalUrl62.PNG
    :alt: Redirect record external url
    :align: left
    :name: Redirect record external url

**Image 4:** Redirect record external url

Redirect type Internal File
""""""""""

.. figure:: ../Images/internalFile62.PNG
    :alt: Redirect record internal file
    :align: left
    :name: Redirect record internal file

**Image 5:** Redirect record internal file

Redirect record fields
-----------

The following table describes the main fields of a redirect record.

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
	Internal page, external url and internal file


 - :Field:
    **HTTP Status**

   :Description:
    The HTTP state of the redirect. It can be a 301 (Moved Permanently), 302 (Found), 303 (See other) and 307
    (Temporary redirect).

   :Types Redirect:
   	Internal page, external url and internal file


 - :Field:
    **Total hits**

   :Description:
    Total hits of the redirect.

   :Types Redirect:
   	Internal page, external url and internal file


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
	Add additional params to the internal page for linking inside a part of a site for example

   :Types Redirect:
	Internal page


 - :Field:
	**External url**

   :Description:
	The external url to redirect to

   :Types Redirect:
	External url


 - :Field:
	**Internal file**

   :Description:
	The internal file to redirect to

   :Types Redirect:
	Internal file



