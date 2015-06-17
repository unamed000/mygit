/**
 * Created by gento on 22/5/2015.
 */

var app = angular.module('mine',[]).constant('post_constant',{'is_ajax' : '1'});
app.run(function($http){
    $http.defaults.headers.post =  {'Content-Type': 'application/x-www-form-urlencoded'};
});
app.config(['$httpProvider', 'post_constant',
    function ($httpProvider, post_constant) {
        $httpProvider.interceptors.push(function () {
            return {
                request: function (config) {
                    if (config.method == "POST"){
                        if(angular.isString(config.data)){
                            config.data += '&' +$.param(post_constant);
                        }else{
                            config.data = angular.extend(post_constant, config.data);
                        }
                    }
                    return config;
                }
            };
        });
    }]);

app.directive('formRegister',['$http',function($http){
    return {
        restrict : 'E',
        controller : function(){
            this.username = '';
            this.password = '';
            this.cpassword = '';
            this.email = '';
            var account = this;
            this.register = function() {
                $http.post(site_url + '/account/register', $.param({
                    username: account.username,
                    password: account.password,
                    email: account.email,
                    cpassword: account.cpassword
                })).success(function(data){
                    process_result(data);
                });
            }
        },
        templateUrl  : sub_view_url('account/sign_up_form.php'),
        controllerAs : 'account'
    }}
]);