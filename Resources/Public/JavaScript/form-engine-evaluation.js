import FormEngineValidation from '@typo3/backend/form-engine-validation.js';

/**
 * Module: @evoweb/sf-books/form-engine-evaluation
 * @exports @evoweb/sf-books/form-engine-evaluation
 */
export class EvowebFormEngineEvaluation {
  /**
   * @param {string} name
   */
  static registerCustomEvaluation(name) {
    const validation = new EvowebFormEngineEvaluation();
    FormEngineValidation.registerCustomEvaluation(name, value => validation.evaluateIsbnNumber(value));
  }

  /**
   * @param {string} isbn
   * @returns {string}
   */
  evaluateIsbnNumber(isbn) {
    return isbn.replace(/[^0-9X\-]/gi, '');
  }
}
