<?php

declare(strict_types=1);

namespace Evoweb\SfBooks\ViewHelpers\Data;

/*
 *  Copyright notice
 *
 *  (c) 2012 Claus Due <claus@wildside.dk>, Wildside A/S
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Sorts an instance of ObjectStorage, an Iterator implementation,
 * an Array or a QueryResult (including Lazy counterparts).
 *
 * Can be used inline, i.e.:
 * <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
 *  xmlns:sfb="http://typo3.org/ns/Evoweb/SfBooks/ViewHelpers"
 *  data-namespace-typo3-fluid="true">
 *
 * <f:for each="{dataset -> vhs:iterator.sort(sortBy: 'name')}" as="item">
 *  // iterating data which is ONLY sorted while rendering this particular loop
 * </f:for>
 *
 * @author Claus Due <claus@wildside.dk>, Wildside A/S
 * @package Vhs
 * @subpackage ViewHelpers\Iterator
 */
class SortViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument(
            'subject',
            'array',
            'An array or Iterator implementation to sort'
        );
        $this->registerArgument(
            'as',
            'string',
            'Which variable to update in the TemplateVariableContainer. If left out, returns sorted data
             instead of updating the variable (i.e. reference or copy)'
        );
        $this->registerArgument(
            'sortBy',
            'string',
            'Which property/field to sort by - leave out for numeric sorting based on indexes(keys)'
        );
        $this->registerArgument(
            'order',
            'string',
            'ASC or DESC',
            false,
            'ASC'
        );
        $this->registerArgument(
            'sortFlags',
            'string',
            'Constant name from PHP for SORT_FLAGS: SORT_REGULAR, SORT_STRING, SORT_NUMERIC, SORT_NATURAL,
             SORT_LOCALE_STRING or SORT_FLAG_CASE',
            false,
            'SORT_REGULAR'
        );
    }

    /**
     * "Render" method - sorts a target list-type target. Either $array or
     * $objectStorage must be specified. If both are, ObjectStorage takes precedence.
     *
     * @throws \Exception
     * @return mixed
     */
    public function render()
    {
        $subject = $this->arguments['subject'];
        if ($subject === null && !$this->arguments['as']) {
            // this case enables inline usage if the "as" argument
            // is not provided. If "as" is provided, the tag content
            // (which is where inline arguments are taken from) is
            // expected to contain the rendering rather than the variable.
            $subject = $this->renderChildren();
        } elseif ($subject === null) {
            $priorities = ['array', 'objectStorage', 'queryResult'];
            foreach ($priorities as $argumentName) {
                if ($this->arguments[$argumentName]) {
                    $subject = $this->arguments[$argumentName];
                    break;
                }
            }
        }
        $sorted = null;
        if (is_array($subject) === true) {
            $sorted = $this->sortArray($subject);
        } else {
            if (
                $subject instanceof ObjectStorage ||
                $subject instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage
            ) {
                $sorted = $this->sortObjectStorage($subject);
            } elseif ($subject instanceof \Iterator) {
                /** @var \Iterator $subject */
                $array = [];
                foreach ($subject as $index => $item) {
                    $array[$index] = $item;
                }
                $sorted = $this->sortArray($array);
            } elseif ($subject instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface) {
                $sorted = $this->sortArray($subject->toArray());
            } elseif ($subject !== null) {
                // a NULL value is respected and ignored, but any
                // unrecognized value other than this is considered a
                // fatal error.
                throw new \Exception(
                    'Unsortable variable type passed to Iterator/SortViewHelper. Expected any of Array, QueryResult, '
                    . ' ObjectStorage or Iterator implementation but got ' . gettype($subject),
                    1351958941
                );
            }
        }
        if ($this->arguments['as']) {
            if ($this->templateVariableContainer->exists($this->arguments['as'])) {
                $this->templateVariableContainer->remove($this->arguments['as']);
            }
            $this->templateVariableContainer->add($this->arguments['as'], $sorted);

            return $this->renderChildren();
        }

        return $sorted;
    }

    protected function sortArray(array $array): array
    {
        $sorted = [];
        foreach ($array as $index => $object) {
            if ($this->arguments['sortBy']) {
                $index = $this->getSortValue($object);
            }
            while (isset($sorted[$index])) {
                $index .= '1';
            }
            $sorted[$index] = $object;
        }
        if ($this->arguments['order'] === 'ASC') {
            ksort($sorted);
        } else {
            krsort($sorted);
        }

        return $sorted;
    }

    /**
     * Sort a \TYPO3\CMS\Extbase\Persistence\ObjectStorage instance
     *
     * @param ObjectStorage|\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage $storage
     *
     * @return ObjectStorage
     */
    protected function sortObjectStorage($storage): ObjectStorage
    {
        $sorted = [];
        foreach ($storage as $index => $item) {
            if ($this->arguments['sortBy']) {
                $index = $this->getSortValue($item);
            }
            while (isset($sorted[$index])) {
                $index .= '1';
            }
            $sorted[$index] = $item;
        }

        if ($this->arguments['order'] === 'ASC') {
            ksort($sorted);
        } else {
            krsort($sorted);
        }

        /** @var ObjectStorage $storage */
        $storage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        foreach ($sorted as $item) {
            $storage->attach($item);
        }

        return $storage;
    }

    /**
     * Gets the value to use as sorting value from $object
     *
     * @param mixed $object
     *
     * @return mixed
     */
    protected function getSortValue($object)
    {
        $field = $this->arguments['sortBy'];
        $value = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getProperty($object, $field);
        if ($value instanceof \DateTime) {
            $value = $value->format('U');
        } elseif ($value instanceof ObjectStorage) {
            $value = $value->count();
        } elseif (is_array($value)) {
            $value = count($value);
        }

        return $value;
    }
}
