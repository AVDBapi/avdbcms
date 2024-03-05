(function(window, videojs) {
  'use strict';

  var plugin = function(options) {
    var player = this, isLoaded;
    if (!options) options = {};

    player.on('timeupdate', time_updated);
    player.on('ended', time_updated);

    function time_updated(time_update_event){
      var current_time = this.currentTime();
      var duration = this.duration();
      var time = Math.floor(current_time);

      if(time > duration || time_update_event.type === "ended") {
        time = 0;
      }

      if (isLoaded) {
        if (options.localStorageKey) {
          localStorage[options.localStorageKey] = time;
        }

        if (options.sessionStorageKey) {
          sessionStorage[options.sessionStorageKey] = time;
        }
      }
    }

    player.ready(function() {
      var seekFunction = function() {
        if (isLoaded) return;
        isLoaded = true;
        var seek = 0;

        if (options.localStorageKey) {
          seek = parseInt(localStorage[options.localStorageKey]);
        }

        if (options.sessionStorageKey) {
          seek = parseInt(sessionStorage[options.sessionStorageKey]);
        }

        if(isNaN(seek) === true){

           seek = 0;
        }

        player.currentTime(seek);
      };


      player.one('playing', seekFunction);
      player.one('play', seekFunction);
      player.one('loadedmetadata', seekFunction);
    });


  };

  // register the plugin
  videojs.registerPlugin('remember', plugin);
})(window, window.videojs);
