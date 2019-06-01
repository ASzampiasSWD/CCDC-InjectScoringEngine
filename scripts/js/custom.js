/* Custom JS
Author: Amanda Szampias
Date: May 23, 2019
School: Cuyahoga Community College */

/* Validation Code. Used with validate.js START */

function resetFormGroups(form) {
    form.querySelectorAll(".form-group").forEach(resetFormGroup);

 function resetFormGroup(formGroup) {
    formGroup.classList.remove('has-error');
    formGroup.classList.remove('has-success');
    formGroup.querySelectorAll('.help-block.error').forEach(function (el) {
       el.parentNode.removeChild(el);
    });
 }
}

function displayErrors(validationErrors, form) {
 form.querySelectorAll("input[name]:not([type=hidden]), select[name]").forEach(function (el) {
    displayErrorForInput(el, validationErrors && validationErrors[el.name]);
 });
}

function displayErrorForInput(input, errors) {
 var formGroup = closestParent(input.parentNode, 'form-group');
 var messages = formGroup.querySelector('.messages');

 if (errors) {
    formGroup.classList.add('has-error');
    errors.forEach(function (err) {
       addError(messages, err);
    });
 }
}

function closestParent(child, className) {
 if (!child || child == document) {
    return null;
 }
 if (child.classList.contains(className)) {
    return child;
 } else {
    return closestParent(child.parentNode, className);
 }
}

function addError(messages, error) {
 var block = document.createElement("p");
 block.style.color = "red";
 block.classList.add("help-block");
 block.classList.add("error");
 block.innerText = error;
 messages.appendChild(block);
}

function handleValidate(form, data, formConstraints) {
  resetFormGroups(form);
  var errors = validate(data, formConstraints);
  if (errors) {
    displayErrors(errors, form);
  }
  return !errors;
}

/* Validation Code. Used with validate.js END */
