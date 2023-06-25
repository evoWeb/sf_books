.. include:: /Includes.rst.txt

.. _configuration:

=============
Configuration
=============


Introduction
============

There are configurations for listView and singleView and more general parts
like templateFile or pidList. In all fields related stdWraps fields from
tx_sfbooks_books are available for field and data like uid.


General plugin configuration
============================

Following parameter are available as constants. And with the same
name also as setup parameter.


plugin.tx\_sfbooks
==================

:aspect:`Property`
         templatePath

:aspect:`Data type`
         :ref:`integer <t3tsref:data-type-string>`

:aspect:`Description`
         Path to the template file like EXT:sf_books/books_template.html

:aspect:`Default`
         none

:aspect:`Possible values`
         any valid view.templateRootPaths
