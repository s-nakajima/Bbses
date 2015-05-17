/**
 * @fileoverview Bbses Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Bbses Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('Bbses', function($scope) {

  /**
   * Use like button
   *
   * @return {void}
   */
  $scope.useLike = function() {
    var likeElement = $('#BbsSettingUseLike');
    var unlikeElement = $('#BbsSettingUseUnlike');

    if (likeElement[0].checked) {
      unlikeElement[0].disabled = false;
    } else {
      unlikeElement[0].disabled = true;
    }
  };
});


/**
 * BbsArticlesEdit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('BbsArticlesEdit',
      function($scope, NetCommonsWysiwyg) {

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
  });
