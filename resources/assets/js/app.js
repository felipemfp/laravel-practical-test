
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


$(function() {
  var $btnLoad = $('#btnLoad');
  var loading = false;
  var timeout = null;

  var updateLoading = function($target, text, stage) {
   var nextStage = stage >= 3 ? 1 : stage + 1;
   var nextText = text + new Array(nextStage).join('.');
   $target.text(nextText);
   timeout = setTimeout(function() {
     updateLoading($target, text, nextStage);
   }, 300);
  }

  var activateLoading = function($target) {
   updateLoading($target, 'Loading', 0);
  }

  var reload = function(response) {
   clearTimeout(timeout);
   location.reload();
  }

  var fetch = function() {
   $.ajax({
     url: '/update',
     complete: reload
   });
  }

  $btnLoad.click(function() {
   $btnLoad.attr('disabled', 'disabled');
   if (!loading) {
     activateLoading($btnLoad);
     fetch();
   }
   loading = true;
  });
});
