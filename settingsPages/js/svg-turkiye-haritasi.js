/*! SVG Türkiye Haritası | MIT Lisans | dnomak.com */

function svgturkiyeharitasi() {
  const element = document.querySelector('#svg-turkiye-haritasi');
  const info = document.querySelector('.il-isimleri');

  element.addEventListener(
    'mouseover',
    function (event) {
      if (event.target.tagName === 'path' && event.target.parentNode.id !== 'guney-kibris') {
        info.innerHTML = [
          '<div>',
          event.target.parentNode.getAttribute('data-iladi'),
          '</div>'
        ].join('');
      }
    }
  );

  element.addEventListener(
    'mousemove',
    function (event) {
      // info.style.top = event.pageY + 'px';
      // info.style.left = event.pageX + 'px';
    }
  );

  element.addEventListener(
    'mouseout',
    function (event) {
      info.innerHTML = '';
    }
  );

  element.addEventListener(
    'click',
    function (event) {
      if (event.target.tagName === 'path') {
        const parent = event.target.parentNode;
        const id = parent.getAttribute('id');

        if (
          id === 'guney-kibris'
        ) {
          return;
        }

        const countrySelect = document.getElementById("countrySelect");
        countrySelect.selectedIndex = parent.getAttribute('data-plakakodu');

        $.ajax({
          type: "POST",
          url: "http://localhost/controlPagesAdmin/controlCountry.php",
          data: { countrySelect: countrySelect.value },
        }).done(function( countryResult ) {
          document.getElementById("country_detail").innerHTML = countryResult;
        });

        // let il = document.getElementById(id);
        // let ilSelect = il.firstElementChild;
        // ilSelect.setAttribute("style", "fill: #E0693C");

        // window.location.href = (
        //   '#'
        //   + id
        //   + '-'
        //   + parent.getAttribute('data-plakakodu')
        // );
      }
    }
  );
}
