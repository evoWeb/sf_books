.. include:: ../Includes.txt


.. _breaking-changes:

Breaking Changes
================

2021.03.13
''''''''''

Replace pagination widget by pagination API
-------------------------------------------

Usage of f:widget.paginate is replaced with paginator and pagination objects with usage of Paginator.html partials.

Routes configuration
--------------------

Routes configuration files are moved from /Configuration/Yaml to /Configuration/Routes


2020.05.03
''''''''''

Cleanup of plugins
------------------

Due to a more restricted handling of resolving controllers and actions in links every plugin is reduced to it's main
data models. The following plugins are modified:

+----------+----------------------------------------------------+--------------------+
| Plugin   | Controller before change                           | after change       |
+==========+====================================================+====================+
| Book     | BookController, CategoryController                 | BookController     |
| Category | CategoryController, BookController                 | CategoryController |
| Series   | SeriesController, BookController                   | SeriesController   |
| Search   | SearchController, BookController, AuthorController | SearchController   |
+----------|----------------------------------------------------+--------------------+

In consequence you need to check whether your pages are still displaying all information after upgrade.

There are settings for the link generation authorPageId, bookPageId, categoryPageId, seriesPageId to compensate
reduced flexibility. Have a look into the TypoScript constants editor.

Cleanup of flexforms
--------------------

The field settings.templatePath got removed with view.templateRootPaths.200. By this no extra handling for overriding
templates is necessary anymore. But the new field needs to be filled to get it working again.


2017.04.27
''''''''''

Remove viewhelper
-----------------

In favor of the core the widget viewhelper was dropped. Please replace 'sfb:widget.paginate' with 'f:widget.paginate'
and check if configuration still works.


Template behaviour
------------------

Only valid template file type since version 4 are html files. Every other template file needs to be reuploaded.
