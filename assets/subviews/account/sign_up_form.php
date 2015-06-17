<h5 style="font-size:100%">or Create an account to manage multiple facebook accounts</h5>
<form ng-submit="account.register()" class="col s12 opposite-form-color" name="form" novalidate>
    <div class="row">
        <div class="input-field col s12">
            <input name="username" id="username" type="text" ng-model="account.username" required>
            <label for="username">Username</label>
            <div class="left-align error-mess" ng-show="form.$submitted || form.username.$touched">
                <span ng-show="form.username.$error.required">Username is required.</span>
            </div>
        </div>
        <div class="input-field col s12">
            <input id="email" type="email" name="email" ng-model="account.email" required>
            <label for="email">Email</label>
            <div class="left-align error-mess" ng-show="form.$submitted || form.email.$touched">
                <span ng-show="form.email.$error.required">Email is required.</span>
                <span ng-show="form.email.$error.email">Invalid email address.</span>
            </div>
        </div>
        <div class="input-field col s12">
            <input name="password" id="password" type="password" ng-model="account.password" required>
            <label for="password">Password</label>
            <div class="left-align error-mess" ng-show="form.$submitted || form.password.$touched">
                <span ng-show="form.password.$error.required">Password is required.</span>
            </div>
        </div>
        <div class="input-field col s12">
            <input id="cpassword" name="cpassword" type="password" ng-model="account.cpassword" required>
            <label for="re-password">Re-Password</label>
            <div class="left-align error-mess" ng-show="(form.$submitted || form.password.$touched) && form.password.$viewValue != form.cpassword.$viewValue">
                <span ng-show="form.password.$viewValue != form.cpassword.$viewValue">Confirm Password is not match.</span>
            </div>
        </div>
        <div class="s12">
            <button class="btn btn-large waves-effect waves-light" type="submit" name="action">Submit
                <i class="mdi-content-send right"></i>
            </button>
        </div>
    </div>
</form>