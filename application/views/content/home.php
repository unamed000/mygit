<div class="row main">
    <div class="scroll col s12 l8 grey darken-3 content" style="color: #ffffff;">
        <div class="valign-wrapper" style="height:100px;">
            <div class="valign center-align" style="width:100%;">
                <a class="btn-floating btn-large waves-effect waves-red white red-text">Mine</a>
            </div>
        </div>
        <div class="center-align" style="font-size:120%; margin-bottom:20px;">
            Manage Your Facebook Page has never been easier with <span class="<?= $this->config->item('main_text_color');?> ">Mine</span>!
        </div>
        <div class="center-align unicode-font-family">
            Solution to sell your product on social pages like facebook. Easier manage page content like Sales, Order, Product and Feedback
        </div>

        <div class="valign-wrapper" style="height:300px">
            <div class="valign center-align" style="width:100%">
                <h4>Contact</h4>
                <p>
                    Skype : huyvu.gento <br>
                    <a href="mailto:huy.vuhoang93@gmail.com">huy.vuhoang93@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
    <div class="col s12 l4 white-bg no-padding content" style="height:1000px; overflow: hidden">
        <div class="row" style="margin-top:50px;">
            <div class="center-align" style="width:100%;">
                <a href="#" onclick="facebook_login()">
                    <div>
                        <i class="fa fa-facebook fa-5x <?= $this->config->item('main_text_color');?>" ></i>
                    </div>
                    <div>
                        <span class="<?= $this->config->item('main_text_color');?> " style="font-weight: bold; font-size:120%;">Sign in with facebook now</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="scroll content usual-bg-color usual-text-color" style="height:100%;" >
            <div class="center-align" style="padding-top: 25px">
                <form-register></form-register>
            </div>
        </div>

    </div>
</div>


<script>
    var facebook_login = function(){
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                register_with_server();
            }
            else {
                FB.login(function(){
                    register_with_server();
                }, {scope: 'user_about_me,manage_pages,read_page_mailboxes'});
            }
        });
    };

    var register_with_server = function(){
        var user_info = FB.api('/me');
        FB.api('/me', function(response) {
            $.post({

            });
        });
        return user_info;
    };
</script>
