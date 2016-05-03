/**
 * @fileoverview Bbses Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * BbsArticlesEdit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('BbsArticlesEdit',
    ['$scope', 'NetCommonsWysiwyg', function($scope, NetCommonsWysiwyg) {

      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();

      /**
       * initialize
       *
       * @return {void}
       */
      $scope.initialize = function(data) {
        $scope.bbsArticle = data.bbsArticle;
      };
    }]);
