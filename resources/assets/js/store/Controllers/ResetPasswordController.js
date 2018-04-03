myApp.controller('ResetPasswordController' , ["$scope" , "Account" , "$location" , "User", function ($scope , Account , User) {
    angular.extend($scope ,{
         getParameterByName : function(name, url) {
            if (!url) {
                url = window.location.href;
            }
            name = name.replace(/[\[\]]/g, "\\$&");

            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
        changeElement : function (clase , disabled , text) {
            var button = document.getElementsByClassName(clase)[0];
            button.disabled = disabled;
            button.innerHTML = text;
        },
        resetPassword : function (resetPasswordForm) {
            if (resetPasswordForm.$valid){
                var resetObj = {
                    email : $scope.reset.email,
                    password : $scope.reset.password,
                    password_confirmation:$scope.reset.password_confirmation,
                    token : token
                };
                $scope.formSubmited = false;
                $scope.changeElement('resetPassword' , true , "<i class='fa fa-refresh fa-spin  fa-fw'></i> Restableciendo Contraseña.");
               Account.postResetPassword(resetObj)
                    .then(function(response) {
                        $scope.errors = null;
                        toastr["info"](response.data.status);
                        $scope.changeElement('resetPassword' , false , "<i class='fa fa-refresh'></i>Reestablecer Contraseña");
                    }).catch(function(response) {
                    $scope.errors = response.data;
                    $scope.changeElement('resetPassword' , false , "<i class='fa fa-refresh'></i>Reestablecer Contraseña");
                }).finally(function() {});
            }else{
                $scope.formSubmited = true;
            }
        }
    });
    
    
}]);