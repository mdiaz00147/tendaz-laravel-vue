myApp.controller("shippingController" , ["$scope" , "Shipping" , "$location" , "$rootScope",   function ($scope , Shipping  , $location , $rootScope) {

    /*METHODS*/
    angular.extend($scope , {
        'newAddress' : false,
        'address' : {}
    });
    $rootScope.states.defaultState = {'id' : 710 , 'name' : 'Distrito Capital de Bogotá'};

    angular.extend($scope , {
        'goToPay' : function () {
            if($rootScope.carts.shippingAddress.data._id){
                var ordObject = {
                    'shipping_address_id'  : $rootScope.carts.shippingAddress.data._id
                };
                Shipping.assignShipping(ordObject);
                $location.path('/payment');
            }else{
                alert('Escoge una direccion');
            }
        },
       'getAddresses' : function () {
           Shipping.getAddresses();
       },
        'getShippingValue' : function (id) {
            Shipping.getShippingValue(id);
        },
        'addressCreate' : function () {
           $scope.newAddress = !$scope.newAddress;
        },
        'getStates' : function () {
            Shipping.getStates();
        },
        'changeState' : function () {
            Shipping.getCities($rootScope.states.defaultState.id);
        },
        'doAddress' : function () {
            var addrObject = {
              'name'  : $scope.address.name,
              'street' : $scope.address.street,
              'complement' : $scope.address.complement,
              'country_id' : 50,
              'state_id' : $scope.states.defaultState.id,
              'city_id' : $scope.defaultCity.id,
              'receiverName' : $rootScope.states.defaultState.id
            };
            Shipping.create(addrObject).then(function () {
                $scope.addressCreate();
                Shipping.getAddresses();
            });
        },
        'changeShipping' : function () {
            var ordObject = {
              'shipping_method_id'  : $rootScope.carts.shippingMethod.data._id
            };
            Shipping.doShippingMethod(ordObject);
        },
        'changeAddress' : function (id) {
          $scope.getShippingValue(id);
        }

    });
    /*GET TOTAL SHIPPING*/
    //$scope.getShippingValue();

    /*VARIABLES*/
    $scope.getStates();
    $scope.getAddresses();
}]);
