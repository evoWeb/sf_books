class EvowebBookAccordion {
  /**
   * @type {HTMLElement}
   */
  current = null;

  constructor() {
    this.initializeClickTriggers();
    this.initializeAnchoredAccordion();
  }

  initializeClickTriggers() {
    const triggers = [...document.querySelectorAll('.trigger')];
    triggers.map(trigger => trigger.addEventListener('click', event => this.clickEventHandler(event)));
  }

  initializeAnchoredAccordion() {
    if (window.location.hash) {
      const hash = window.location.hash,
        accordionToOpen = document.querySelector('.trigger' + hash);
      if (accordionToOpen) {
        this.current = accordionToOpen;
        this.activate(this.current);
      }
    }
  }

  /**
   * @param {PointerEvent} event
   */
  clickEventHandler(event) {
    event.preventDefault();
    const trigger = event.target;

    if (trigger === this.current) {
      this.deactivate(this.current);
    } else {
      if (this.current != null) {
        this.deactivate(this.current);
      }

      this.current = trigger;
      this.activate(this.current);
    }
  }

  /**
   * @param {HTMLElement} element
   */
  activate(element) {
    element.classList.add('trigger_active');
    this.getNextSibling(element, '.toggle_container').classList.remove('close');
  }

  /**
   * @param {HTMLElement} element
   */
  deactivate(element) {
    element.classList.remove('trigger_active');
    this.getNextSibling(element, '.toggle_container').classList.add('close');
  }

  /**
   * @param {HTMLElement} element
   * @param {string} selector
   */
  getNextSibling(element, selector) {
    // Get a sibling by selector
    return element.parentElement.querySelector(selector);
  }
}

class EvowebBookLetters {
  constructor() {
    this.initializeClickTriggers();
  }

  initializeClickTriggers() {
    const triggers = [...document.querySelectorAll('.tx-sfbooks .letters a')];
    triggers.map(trigger => trigger.addEventListener('click', event => this.clickEventHandler(event)));
  }

  /**
   * @param {PointerEvent} event
   */
  clickEventHandler(event) {
    event.preventDefault();

    const trigger = event.target,
      hash = trigger.hash,
      accordionToOpen = document.querySelector('.trigger' + hash);

    this.emitEvent(accordionToOpen, 'click');

    document.body.scrollBy({ top: accordionToOpen.top });
    window.location.hash = hash;
  }

  emitEvent(element, type) {
    element.dispatchEvent(new CustomEvent(type, true, true));
  }
}

function evowebBookInitialization() {
  new EvowebBookAccordion();
  new EvowebBookLetters();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', evowebBookInitialization);
} else {
  evowebBookInitialization();
}
