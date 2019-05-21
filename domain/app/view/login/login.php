<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

</head>
<body>
<?php
if (isset($this->data['second'])){
    echo $this->data['second'];
}
?>
<input type="button" value="start" id="btn">
<p/>
<i id="all_data"></i>

</body>
<script src="../public/static/jquery/jquery-3.3.1.js"></script>
<script src="../public/static/jquery/jQuery.md5.js"></script>
<script>

    $("#btn").click(function () {
            var data = {
                user_name: "Junpeng",
                user_password: "123456",
                confirm_password: "123456",
                email: "784637485@qq.com",
                phone_num: "13265914348",
            };

            // 登陆
            $.ajax({
                url: "http://local.domain.cn/Login/login_check",
                type: "POST",
                dataType: "json",
                data: {
                    "user_name": "Junpeng",
                    "user_password": "123456"
                },
                success: function (data) {
                    if (data.code == 200) {
                        console.log(data.data);
                        window.location.href = "http://local.domain.cn/Domain/domain";
                    } else if (data.code == 202) {
                        console.log(data.data);
                    }
                }
            })


            // )
            //        注册
            // $.ajax({
            //         url: "http://local.domain.cn/Login/add_user",
            //         type: "POST",
            //         dataType: "json",
            //         data: {
            //             "user": data
            //         },
            //         success: function (data) {
            //             if (data.code == 200) {
            //                 console.log(data.data);
            //                 window.location.href = "http://local.domain.cn/";
            //             } else if (data.code == 202) {
            //                 console.log(data.data);
            //             }
            //         }
            //     }
            // )
        }
    )
</script>
</html>