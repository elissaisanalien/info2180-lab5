window.addEventListener('DOMContentLoaded', () => {
  const lookupButton = document.getElementById('lookup');
  const citiesButton = document.getElementById('lookup-cities');
  const countryInput = document.getElementById('country');
  const result = document.getElementById('result');

  // extra is an optional query string fragment, e.g. "&lookup=cities"
  function search(extra = '') {
    const country = encodeURIComponent(countryInput.value.trim());

    fetch(`world.php?country=${country}${extra}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Request failed: ${response.status}`);
        }
        return response.text();
      })
      .then(data => {
        result.innerHTML = data;
      })
      .catch(error => {
        result.textContent = 'There was a problem retrieving the data.';
        console.error(error);
      });
  }

  lookupButton.addEventListener('click', () => search());
  citiesButton.addEventListener('click', () => search('&lookup=cities'));
});