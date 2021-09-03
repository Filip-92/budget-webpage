const form = document.getElementById('formId');

$(window).resize(function() {
    if(window.outerWidth < 1700){


        form.classList.remove('column')
        form.classList.add('row')

    }
  });

  $(window).resize(function() {
    if(window.outerWidth > 1700){


        form.classList.add('column')
        form.classList.remove('row')

    }
  });