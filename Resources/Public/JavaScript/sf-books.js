function getNextSibling(element, selector) {
  // Get the next sibling element
  let sibling = element.nextElementSibling;

  // If there's no selector, return the first sibling
  if (selector) {
    // If the sibling matches our selector, use it
    // If not, jump to the next sibling and continue the loop
    while (sibling) {
      if (sibling.matches(selector)) {
        break;
      }
      sibling = sibling.nextElementSibling
    }
  }

  return sibling;
}

function emitEvent(element, type) {
  let event = document.createEvent('HTMLEvents');
  event.initEvent(type, true, true);
  element.dispatchEvent(event);
}

function triggerClickHandler(event) {
  event.preventDefault();

  let trigger = event.target,
    current = document.querySelector('.trigger_active');

  if (trigger === current) {
    current.classList.remove('trigger_active');
    getNextSibling(current, '.toggle_container').classList.add('close');
  } else {
    if (current != null ) {
      current.classList.remove('trigger_active');
      getNextSibling(current, '.toggle_container').classList.add('close');
    }

    trigger.classList.add('trigger_active');
    getNextSibling(trigger, '.toggle_container').classList.remove('close');
  }
}

function initAccordion() {
  let allTriggers = document.querySelectorAll('.trigger'),
    accordionToOpen = null,
    keepOpen;

  allTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', triggerClickHandler);
  })

  if (window.location.hash) {
    accordionToOpen = document.querySelector('.trigger' + window.location.hash);

    keepOpen = accordionToOpen != null ? accordionToOpen : allTriggers[0];
    keepOpen.classList.add('trigger_active');
    getNextSibling(keepOpen, '.toggle_container').classList.remove('close');
  }
}

function letterClickHandler(event) {
  event.preventDefault();

  let letter = event.target,
    trigger = document.querySelector('.trigger' + letter.hash);

  emitEvent(trigger, 'click');

  document.body.scrollBy({ top: trigger.top });
  window.location.hash = letter.hash;
}

function initLetters() {
  let letters = document.querySelectorAll('.tx-sfbooks .letters a');

  letters.forEach(function (letter) {
    letter.addEventListener('click', letterClickHandler);
  });
}

document.addEventListener('DOMContentLoaded', function() {
  initAccordion();
  initLetters();
});
