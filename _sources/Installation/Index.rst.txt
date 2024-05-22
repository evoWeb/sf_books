.. include:: /Includes.rst.txt

.. _installation:

============
Installation
============


Download via Extension Manager
==============================

In the TYPO3 Backend go to Admin Tools > Extensions. Change in the dropdown on
the top left to 'Get Extensions', enter the extension key 'sf_books' in the
text field below the headline 'Get Extensions' and hit go. In the result list
install the extension by hitting the action for that.


Download via Composer
=====================

Add evoweb/sf-books to the require in your composer.json.

.. code-block:: bash
   :caption: Enter on shell

   composer require evoweb/sf-books


Include TypoScript
==================

Include static file "Book Library" in your typoscript record or import in your
sitepackage and modify the constants to match the page setup you have added.


Include Routing configuration
=============================

To have speaking urls you need to add the following import in your site config.
This allows each of the plugins to render seo friendly urls.

.. code-block:: typoscript
   :caption: config/sites/[main]/config.yaml

    imports:
        - { resource: "EXT:sf_books/Configuration/Routes/Default.yaml" }
