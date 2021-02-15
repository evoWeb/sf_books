function getNextSibling (element, selector) {
  // Get the next sibling element
  var sibling = element.nextElementSibling;

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

function triggerClickHandler(event) {
  event.preventDefault();

  var trigger = this,
    current = document.querySelector('.trigger_active');

  if (trigger === current) {
    current.classList.remove('trigger_active');
    getNextSibling(current, '.toggle_container').classList.add('close');
  } else {
    current.classList.remove('trigger_active');
    getNextSibling(current, '.toggle_container').classList.add('close');

    trigger.classList.add('trigger_active');
    getNextSibling(trigger, '.toggle_container').classList.remove('close');
  }
}

function initAccordion() {
  var allTriggers = document.querySelectorAll('.trigger'),
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

  var letter = this,
    trigger = document.querySelector('.trigger' + letter.href);

  trigger.trigger('click');

  document.body.scrollBy({ top: trigger.top });
  window.location.hash = letter.attr('href');
}

function initLetters() {
  var letters = document.querySelectorAll('.tx_sfbooks_author_letters a, .tx_sfbooks_series_letters a');

  letters.forEach(function (letter) {
    letter.addEventListener('click', letterClickHandler);
  });
}

document.addEventListener('DOMContentLoaded', function() {
  initAccordion();
  initLetters();
});
