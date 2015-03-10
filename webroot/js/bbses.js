NetCommonsApp.controller('Bbses',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
            NetCommonsTab, NetCommonsUser) {

      $scope.tab = NetCommonsTab.new();

      $scope.user = NetCommonsUser.new();

      $scope.tinymce = NetCommonsWysiwyg.new();

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(data) {
        $scope.bbses = angular.copy(data);
      };
    });

NetCommonsApp.controller('BbsPost',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
            NetCommonsTab, NetCommonsUser, NetCommonsWorkflow) {

      $scope.tab = NetCommonsTab.new();

      $scope.user = NetCommonsUser.new();

      $scope.tinymce = NetCommonsWysiwyg.new();

      $scope.workflow = NetCommonsWorkflow.new($scope);

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(data) {
        $scope.bbsPosts = angular.copy(data);
      };
    });

NetCommonsApp.controller('BbsComment',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
            NetCommonsTab, NetCommonsUser) {

      $scope.tab = NetCommonsTab.new();

      $scope.user = NetCommonsUser.new();

      $scope.tinymce = NetCommonsWysiwyg.new();

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(bbsPosts, bbsComments, quotFlag) {
        $scope.bbsComments = angular.copy(bbsComments);

        //引用データとして使用
        $scope.bbsPosts = angular.copy(bbsPosts);

        //引用するONの場合、データをセット
        if (quotFlag === '1') {console.debug($scope.bbsPosts);
          //引用文に加工する
          $scope.bbsComments['title'] = 'Re:' + $scope.bbsPosts['title'];
          $scope.bbsComments['content'] =
              '<br /><blockquote>' +
              $scope.bbsPosts['content'] +
              '</blockquote>';
        }
      };
    });

NetCommonsApp.controller('BbsEdit',
    function($scope, NetCommonsBase, NetCommonsTab) {

      $scope.tab = NetCommonsTab.new();

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(bbses) {
        $scope.bbses = angular.copy(bbses);
      };

      $scope.initAutoApproval = function() {
        //コメントを使うONの状態からの操作
        if ($scope.bbses.use_comment) {

          //自動承認をOFFにする
          $scope.bbses.auto_approval = false;
        }
      };

      $scope.initUnlikeButton = function() {
        //評価ボタンONの状態からの操作
        if ($scope.bbses.use_like_button) {

          //マイナス評価ボタンをOFFにする
          $scope.bbses.use_unlike_button = false;
        }
      };
    });

NetCommonsApp.controller('BbsFrameSettings',
    function($scope, NetCommonsBase, NetCommonsTab) {

      $scope.tab = NetCommonsTab.new();

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(bbsSettings) {
        $scope.bbsSettings = angular.copy(bbsSettings);
      };
    });

NetCommonsApp.controller('BbsAuthoritySettings',
    function($scope, NetCommonsBase, NetCommonsTab) {

      $scope.tab = NetCommonsTab.new();

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(bbses) {
        $scope.bbses = angular.copy(bbses);
      };

      $scope.checkAuth = function() {
        //編集者と一般ONの状態からの操作
        if (! $scope.bbses.editor_publish_authority &&
            ! $scope.bbses.general_publish_authority) {

          //編集者をONにする
          $scope.bbses.editor_publish_authority = true;

        }
        //編集者と一般OFFの状態からの操作
        if ($scope.bbses.editor_publish_authority &&
            $scope.bbses.general_publish_authority) {

          //一般をOFFにする
          $scope.bbses.general_publish_authority = false;

        }
      };
    });
