<?php

declare(strict_types=1);

/*
 * This file is developed by evoWeb.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License or any later version.
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
     * @param string[] $parameters The parameters are value, is_in and set
     * @return string Evaluated field value
     */
    public function evaluateFieldValue(...$parameters): string
    {
        $parameter = $parameters[0] ?? '';
        return preg_replace('/[^0-9X\-]/i', '', $parameter);
    }

    /**
     * Server-side validation/evaluation on opening the record
     *
     * @param array<string, string> $parameters Array with the key 'value' containing the field value from the database
     * @return string Evaluated field value
     */
    public function deevaluateFieldValue(array $parameters): string
    {
        $value = $parameters['value'] ?? '';
        return preg_replace('/[^0-9X\-]/i', '', $value);
    }
}
