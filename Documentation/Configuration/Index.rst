..  include:: /Includes.rst.txt
..  index:: Configuration
..  _configuration:

=============
Configuration
=============

Introduction
============

There are configurations for listView and singleView and more general parts
like templateFile or pidList. In all fields related stdWraps fields from
tx_sfbooks_books are available for field and data like uid.

plugin.tx_sfbooks
=================

Settings for all plugins

plugin.tx_sfbooks_\[book\|author\|category\|series\|search\]
============================================================

Settings specifically for each single plugins

..  confval-menu::
    :name: settings-reference
    :display: table
    :type:
    :Default:

    ..  confval:: templateRootPaths
        :type: array of :ref:`path <t3tsref:data-type-path>`
        :Default: none

        Used to define several paths for templates, which will be tried in reversed
        order (the paths are searched from bottom to top). The first folder where
        the desired layout is found, is used. If the array keys are numeric, they
        are first sorted and then tried in reversed order.

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               view {
                  templateRootPaths {
                     10 = EXT:sitedesign/Resources/Private/Templates
                     20 = EXT:sitemodification/Resources/Private/Templates
                  }
               }
            }

    ..  confval:: pagination
        :type: :ref:`string <t3tsref:data-type-string>`
        :Default: none

        Allows to configure what pagination class should be used. If no class name
        is given or the given class does not implement the PaginationInterface, the
        default SimplePagination gets used.

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               settings {
                  pagination = TYPO3\CMS\Core\Pagination\SlidingWindowPagination
               }
            }

    ..  confval:: itemsPerPage
        :type: :ref:`integer <t3tsref:data-type-integer>`
        :Default: 10

        Amount of list entries per page.

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               settings {
                  itemsPerPage = 10
               }
            }

    ..  confval:: numberOfLinks
        :type: :ref:`integer <t3tsref:data-type-integer>`
        :Default: 5

        If a SlidingWindowPagination or compatible pagination is used, this defines
        the amount of pages in the pagination list.

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               settings {
                  numberOfLinks = 3
               }
            }

    ..  confval:: groupAuthors
        :type: :ref:`boolean <t3tsref:data-type-boolean>`
        :Default: 1

        Choose weather to group the author list by first letter or not.

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               settings {
                  groupAuthors = 1
               }
            }

    ..  confval:: groupSeries
        :type: :ref:`boolean <t3tsref:data-type-boolean>`
        :Default: 1

        Choose weather to group the series list by first letter or not.

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               settings {
                  groupSeries = 1
               }
            }

    ..  confval:: orderings
        :type: array
        :Default: 1

        Combinations of fields with order directions

        **Example:**

        ..  code-block:: typoscript
            :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

            plugin.tx_sfbooks {
               settings {
                  orderings {
                    title = ASC
                  }
               }
            }
