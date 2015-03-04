NetCommonsApp.controller('Bbses',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
            NetCommonsTab, NetCommonsUser) {

      $scope.tab = NetCommonsTab.new();

      $scope.user = NetCommonsUser.new();

      $scope.tinymce = NetCommonsWysiwyg.new();

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.initialize = function(data) {
        $scope.bbses = angular.copy(data);
        console.debug($scope.bbses);
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
        console.debug($scope.bbsPosts);
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
        if (quotFlag === '1') {
          //引用文に加工する
          $scope.bbsComments['title'] = 'Re:' + $scope.bbsPosts['title'];
          $scope.bbsComments['content'] = $scope.bbsPosts['content'];
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
        console.debug($scope.bbses);
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