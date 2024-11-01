..  include:: /Includes.rst.txt
..  index:: Breaking Changes
..  _breaking-changes:

================
Breaking Changes
================

01. November 2024
=================

Content registration
--------------------

Plugins are now registered with CType and not list_type anymore. Migration for
existing content elements is provided.

28. July 2023
=============

Change typoscript parameter
---------------------------
Rename TypoScript parameter settings.limit into settings.itemsPerPage.
This also relates to the plugin settings where limit is renamed into itemsPerPage to.

Drop ViewHelper
---------------
As of version 8.x the SortViewHelper is dropped because its never used.

13. March 2021
==============

Replace pagination widget by pagination API
-------------------------------------------
Usage of f:widget.paginate is replaced with paginator and pagination objects with usage of Paginator.html partials.

Routes configuration
--------------------
Routes configuration files are moved from /Configuration/Yaml to /Configuration/Routes

03. May 2020
============

Cleanup of plugins
------------------
Due to a more restricted handling of resolving controllers and actions in links every plugin is reduced to it's main
data models. The following plugins are modified:

========= ================================================== ==================
Plugin    Controller before change                           after change
========= ================================================== ==================
Book      BookController, CategoryController                 BookController
Category  CategoryController, BookController                 CategoryController
Series    SeriesController, BookController                   SeriesController
Search    SearchController, BookController, AuthorController SearchController
========= ================================================== ==================

In consequence you need to check whether your pages are still displaying all information after upgrade.

There are settings for the link generation authorPageId, bookPageId, categoryPageId, seriesPageId to compensate
reduced flexibility. Have a look into the TypoScript constants editor.

Cleanup of flexforms
--------------------
The field settings.templatePath got removed with view.templateRootPaths.200. By this no extra handling for overriding
templates is necessary anymore. But the new field needs to be filled to get it working again.

27. April 2017
==============

Remove ViewHelper
-----------------
In favor of the core the widget ViewHelper was dropped. Please replace 'sfb:widget.paginate' with 'f:widget.paginate'
and check if configuration still works.

Template behaviour
------------------
Only valid template file type since version 4 are html files. Every other template file needs to be reuploaded.
