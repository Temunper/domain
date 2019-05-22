<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<a href="http://local.domain.cn/Domain/domain">返回顶级域名</a>
<table border="1" align="center">
    <tr>
        <td>账号名</td>
        <td>账号类型</td>
        <td>账号状态</td>
        <td colspan="4">操作</td>
    </tr>
    <?php
    if (isset($this->data['all_account'])) {
        $user_account = $this->data['all_account'];
        foreach ($user_account as $value) {
            if ($value['status'] == 1) {
                $status = "停用";
                $status1 = "已启用";
            } elseif ($value['status'] == 0) {
                $status = "启用";
                $status1 = "已停用";
            } else {
                $status = "!";
            }
            $domain = '<tr data-account-id="' . $value['id'] . '">' .
                '<td class="account_name">' . $value['account_name'] . '</td>' .
                '<td class="account_type">' . $value['account_type'] . '</td>' .
                '<td>' . $status1 . '</td>' .
                '<td><input type="button" value="管理" class="account-manage" domain-id=' . $value['id'] . '></td>' .
                '<td><input type="button"  value= ' . $status . ' class="account-status1"  data-account-status=' . $value['status'] . '></td>' .
                '</tr>';
            echo $domain;
        }
    } else {
        echo '<tr><td colspan="6" align="right">没有数据</td></tr>';
    }
    //    <tr><td></td></tr>
    ?>
    <tr>
        <td colspan="7">
            <input type="button" value="添加账号" style="float: right" id="add-account"></td>
    </tr>
</table>
<!--   管理开始   -->
<div style="width: 100%;height: 100%;position: fixed;display: none" id="upd-account-windows">
    <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
        <div style="font-size: x-large;float:right" id="upd-account-close">
            <button>X</button>
        </div>
        <div style="width: 300px;padding-left: 100px">
            <h1 style="left: 15%;position: relative">子账号添加添加</h1>
            <p/>
            <div>
                <i>用户名:<input type="text" id="upd-account_name" data-account-id="">
                    <p/>
                    <p/>
                    <i style="right: 29px;position: relative">账号类型:<input type="text" id="upd-account_type">
                        <p/>
                        <input type="button" value="更改" id="upd-start">
                        <input type="button" value="确认" id="upd-confirm-account">
                        <input type="button" value="删除" id="del-confirm-account">
            </div>
        </div>
    </div>
</div>
<!--   管理结束   -->
<!--    添加开始      -->
<div style="width: 100%;height: 100%;position: fixed;display: none" id="add-account-windows">
    <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
        <div style="font-size: x-large;float:right" id="add-account-close">
            <button>X</button>
        </div>
        <div style="width: 300px;padding-left: 100px">
            <h1 style="left: 15%;position: relative">子账号添加添加</h1>
            <p/>
            <div>
                <i>用户名:<input type="text" id="add-account_name"><a href="#" id="account-check-d_name">用户名检测</a>
                    <p/><i
                            id="check-result"></i></i>
                <p/>
                <i style="right: 29px;position: relative">账号类型:<input type="text" id="add-account_type">
                    <p/>
                    <input type="button" value="confirm" id="add-confirm-account">
            </div>
        </div>
    </div>
</div>
<!--    添加结束      -->
</body>
<script src="../public/static/jquery/jquery-3.3.1.js"></script>
<script>
    //添加窗口
    $("#add-account").click(function () {
        $("#add-account-windows").fadeIn("slow");
    });
    $("#add-account-close").click(function () {
        $("#add-account-windows").fadeOut("slow");
    });
    // 管理窗口
    $(".account-manage").click(function () {
        $("#upd-account-windows").fadeIn("slow");
        $("#upd-account_name").val($(this).closest("tr").find(".account_name").text()).attr("readonly", "readonly").attr("data-account-id", $(this).closest("tr").attr("data-account-id"));
        $("#upd-account_type").val($(this).closest("tr").find(".account_type").text()).attr("readonly", "readonly");
    });
    $("#upd-account-close").click(function () {
        $("#upd-account-windows").fadeOut("slow");
    });
    //更改开始
    $("#upd-start").click(function () {
        $("#upd-account_name").removeAttr("readonly");
        $("#upd-account_type").removeAttr("readonly");
    });
    //确认更改
    $("#upd-confirm-account").click(function () {
        var account_id = $("#upd-account_name").attr("data-account-id");
        var account_name = $("#upd-account_name").val();
        var account_type = $("#upd-account_type").val();
        $.ajax({
            url: "http://local.domain.cn/Account/update_account",
            dataType: "json",
            data: {
                "id": account_id,
                "account_name": account_name,
                "account_type": account_type
            },
            type: "POST",
            success: function (data) {
                if (data.code == 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code == 202) {
                    alert(data.data);
                }
            }
        })
    });
    //状态更改
    $(".account-status1").click(function () {
        var status = $(this).attr("data-account-status");
        var id = $(this).closest("tr").attr("data-account-id");
        $.ajax({
            url: "http://local.domain.cn/Account/update_status",
            dataType: "json",
            data: {
                "status": status,
                "id": id
            },
            type: "POST",
            success: function (data) {
                if (data.code == 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code == 202) {
                    alert(data.data);
                }
            }
        })
    });
    //添加
    $("#add-confirm-account").click(function () {
        var account = {
            "account_name": $("#add-account_name").val(),
            "account_type": $("#add-account_type").val()
        };
        $.ajax({
            url: "http://local.domain.cn/Account/add_account",
            data: {
                "account": account
            },
            type: "POST",
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code == 202) {
                    alert(data.data);
                }
            }
        })
    });
//    删除
    $("#del-confirm-account").click(function () {
        var id = $("#upd-account_name").attr("data-account-id");
        $.ajax({
            url:"http://local.domain.cn/Account/del_account",
            dataType:"json",
            type:"POST",
            data:{
                "id":id
            },
            success:function (data) {
                if (data.code == 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code == 202) {
                    alert(data.data);
                }
            }
        })
    });
</script>
</html>