'use strict';

const Credentials = {
  init: () => {
    const toggleApiKeysElement = document.getElementById('orion-toggle-api-keys');
    if(!toggleApiKeysElement) return;
    toggleApiKeysElement.addEventListener('click', function(e) {
      e.preventDefault();
      const passwordInputs = document.querySelectorAll('#acf-group_65129be483ac5 [type=password]');
      if(passwordInputs.length > 0) {
        passwordInputs.forEach(function(element) {
          element.type = 'text';
          element.setAttribute('data-type', 'password');
        });
        return;
      }
      const changedPasswordInputs = document.querySelectorAll('#acf-group_65129be483ac5 [data-type=password]');
      if(changedPasswordInputs.length > 0) {
        changedPasswordInputs.forEach(function(element) {
          element.type = 'password';
          element.setAttribute('data-type', undefined);
        });
      }
    });
  }
}


export default Credentials;