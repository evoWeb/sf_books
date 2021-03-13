.. include:: ../Includes.txt

.. _installation:

============
Installation
============


Download via Extension Manager
------------------------------

In the TYPO3 Backend go to Admin Tools > Extensions. Change in the dropdown on
the top left to 'Get Extensions', enter the extension key 'sf_books' in the
text field below the headline 'Get Extensions' and hit go. In the result list
install the extension by hitting the action for that.


Download via Composer
---------------------

Add evoweb/extender to the require in your composer.json like in the following
example and run 'composer install'.

::

	{
		"require": {
			"typo3/cms-core": "^10.0",
			"evoweb/sf-books": "*",
		}
	}


Alternatively if you have an existing project with a configured composer.json you
can add extender with the command by running 'composer require evoweb/sf-books'.


Include TypoScript
------------------

Include static file "Book Library" in your typoscript record or import in your
sitepackage and modify the constants to match the page setup you have added.


Include Routing configuration
-----------------------------

To have speaking urls you need to add the following import in your site config.
This allows each of the plugins to render seo friendly urls.

::

	imports:
		- { resource: "EXT:sf_books/Configuration/Routes/Default.yaml" }
