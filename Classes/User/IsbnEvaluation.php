<?php

declare(strict_types=1);

/*
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Evoweb\SfBooks\User;

use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

class IsbnEvaluation
{
    /**
     * Returns JavaScript instruction for client side validation/evaluation
     * (invoked by FormEngine when editing book entities).
     */
    public function returnFieldJS(): JavaScriptModuleInstruction
    {
        return JavaScriptModuleInstruction::create(
            '@evoweb/sf-books/form-engine-evaluation.js',
            'EvowebFormEngineEvaluation',
        );
    }

    /**
     * Server-side validation/evaluation on saving the record
     *
     * @param array $parameters The parameters value, is_in and set
     * @return string Evaluated field value
     */
    public function evaluateFieldValue(...$parameters): string
    {
        return preg_replace('/[^0-9X\-]/i', '', $parameters[0]);
    }

    /**
     * Server-side validation/evaluation on opening the record
     *
     * @param array $parameters Array with key 'value' containing the field value from the database
     * @return string Evaluated field value
     */
    public function deevaluateFieldValue(array $parameters): string
    {
        return preg_replace('/[^0-9X\-]/i', '', $parameters['value']);
    }
}
