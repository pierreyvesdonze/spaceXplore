let app = {

    init: function () {
        console.log('init');

        $('.carousel').carousel({
            interval: false
          })
    }
}

document.addEventListener('DOMContentLoaded', app.init);