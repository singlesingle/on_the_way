<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>登陆</title>

    <!--Core CSS -->
    <link href="/static/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/css/bootstrap-reset.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="/static/css/style.css" rel="stylesheet">
    <link href="/static/css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-body">

<div class="container">

    <form class="form-signin">
        <h2 class="form-signin-heading">用户登陆</h2>
        <div class="login-wrap">
            <div class="user-login-info">
                <input type="text" id="phone" class="form-control" placeholder="手机号" autofocus>
                <input type="password" id="password" class="form-control" placeholder="密码">
            </div>
            {*<label class="checkbox">*}
                {*<input type="checkbox" value="remember-me"> Remember me*}
            {*</label>*}
            <button class="btn btn-lg btn-login btn-block" type="button" onclick="login();">登陆</button>

            <div class="registration">
                注册新账号? 忘了密码?
                <a>
                    请联系管理员
                </a>
            </div>

        </div>
    </form>

</div>



<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script>
 function login() {
        phone = $('#phone').val().trim();
        password = $('#password').val().trim();

        if(phone == "") {
            alert("Phone is null");
            return;
        }
	if(password == "") {
	    alert("Password is null");
	}
        $.ajax({
            url: '/api/user/login',
            dataType: "json",
            type:"POST",
            data:{
                phone: phone,
                pwd: password
            },
            success: function(jsonobject) {
                if (jsonobject.error.returnCode == 0) {
                    var url = '/page/desktop/info';
                    window.location.href=url;
                }else {
                    alert(jsonobject.error.returnUserMessage);
                }
            },
            error: function() {
                alert('login exception, please contact administrator!');
            },
        });
    }
</script>
<script src="/static/js/jquery.js"></script>
<script src="/static/bs3/js/bootstrap.min.js"></script>

</body>
</html>
