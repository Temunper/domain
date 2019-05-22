<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<a href="http://local.domain.cn/Domain/domain">返回主页</a>
<div>
    <table border="1" align="center">
        <tr>
            <td>主机名</td>
            <td>主机状态</td>
            <td>主机IP</td>
            <td>备注</td>
            <td>所在地</td>
            <td>关联子账号</td>
            <td colspan="3">操作</td>
        </tr>
        <?php
        if (isset($this->data['user_server'])) {
            $user_server = $this->data['user_server'];
            foreach ($user_server as $value) {
                if ($value['status'] == 1) {
                    $status = "停用";
                    $status1 = "已启用";
                } elseif ($value['status'] == 0) {
                    $status = "启用";
                    $status1 = "已禁用";
                } else {
                    $status = "!";
                }
                $domain = '<tr data-server-id="' . $value['id'] . '">' .
                    '<td class="server-name">' . $value['server_name'] . '</td>' .
                    '<td>' . $status1 . '</td>' .
                    '<td class="server-ip">' . $value['server_ip'] . '</td>' .
                    '<td class="server-remark">' . $value['remark'] . '</td>' .
                    '<td class="server-place">' . $value['place'] . '</td>' .
                    '<td class="server-account-name">' . $value['account_name'] . '</td>' .
                    '<td><input type="button" value="删除" class="server-del" server-id=' . $value['id'] . '></td>' .
                    '<td><input type="button" value="修改资料" class="server-update" server-id=' . $value['id'] . '></td>' .
                    '<td><input type="button"  value= ' . $status . ' class="server-status1"  data-server-status=' . $value['status'] . '></td>' .
                    '</tr>';
                echo $domain;
            }
        } else {
            echo '<tr><td colspan="6" align="right">没有数据</td></tr>';
        }
        //    <tr><td></td></tr>
        ?>
        <tr>
            <td colspan="9"><input type="button" value="添加主机" style="float: right" id="add-server"></td>
        </tr>
    </table>
</div>
<!-- 管理ip弹窗  -->
<div style="width: 100%;height: 100%;position: fixed;display: none" id="upd-server-windows">
    <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
        <div style="font-size: x-large;float:right" id="upd-server-close">
            <button>X</button>
        </div>
        <div style="width: 300px;padding-left: 100px">
            <h1 style="left: 15%;position: relative">主机添加</h1>
            <p/>
            <div>
                <i>主机名:<input type="text" id="upd-server_name" data-upd-server-id="">
                    <p/><i
                            id="check-result-2"></i></i>
                <p/>
                <i style="right:15px;position: relative">账号选择:<select id="upd_server_account">
                        <option id="upd-server-option"></option>
                        <?php
                        $user_account = $this->data['user_account'];
                        foreach ($user_account as $value) {
                            $ip = '<option data-account-id = ' . $value['id'] . '>' . $value['account_name'] . '</option>';
                            echo $ip;
                        }
                        ?>
                    </select></i>
                <p/>
                <i style="right: 3px;position: relative">备注:<input type="text" id="upd-server_remark"></i>
                <p/>
                <input type="button" value="更改" id="upd-server-change">
                <input type="button" value="确认" id="upd-server-confirm">
            </div>
        </div>
    </div>
</div>

<!--  管理IPend  -->
<!--  添加IP弹窗  -->
<div style="width: 100%;height: 100%;position: fixed;display: none" id="add-server-windows">
    <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
        <div style="font-size: x-large;float:right" id="add-server-close">
            <button>X</button>
        </div>
        <div style="width: 300px;padding-left: 100px">
            <h1 style="left: 15%;position: relative">主机添加</h1>
            <p/>
            <div>
                <i>主机名:<input type="text" id="add-server_name">
                    <p/><i
                            id="check-result"></i></i>
                <p/>
                <i style="right:15px;position: relative">主机IP地址:<input type="text" id="add-server_ip"
                                                                       style="left: 100px"></i>
                <p/>
                <i style="right:15px;position: relative">账号选择:<select id="add_server_account">
                        <option></option>
                        <?php
                        $user_account = $this->data['user_account'];
                        foreach ($user_account as $value) {
                            $ip = '<option data-account-id = ' . $value['id'] . '>' . $value['account_name'] . '</option>';
                            echo $ip;
                        }
                        ?>
                    </select> </i>
                <p/>
                <i style="right: 3px;position: relative">备注:<input type="text" id="add-server_remark"></i>
                <p/>
                <input type="button" value="confirm" id="add-server-confirm">
            </div>
        </div>
    </div>
</div>
<!--  添加IP弹窗end  -->
</body>
<script src="../public/static/jquery/jquery-3.3.1.js"></script>
<script>
    //    添加主机弹窗
    $("#add-server").click(function () {
        $("#add-server-windows").fadeIn("slow");
    });
    $("#add-server-close").click(function () {
        $("#add-server-windows").fadeOut("slow");
        $("#add_server_account").find("option").eq(0).prop("selected",true);
    });

    //修改主机资料弹窗
    $(".server-update").click(function () {
        $("#upd-server-windows").fadeIn("slow");
        $("#upd-server_name").val($(this).closest("tr").find(".server-name").text()).attr("readonly", "readonly");
        $("#upd-server_remark").val($(this).closest("tr").find(".server-remark").text()).attr("readonly", "readonly");
        $("#upd-server-option").text($(this).closest("tr").find(".server-account-name").text());
        $("#upd_server_account").attr("disabled", "disabled");
        $("#upd-server_name").attr("data-upd-server-id",$(this).closest("tr").attr("data-server-id"));

    });
    $("#upd-server-close").click(function () {
        $("#upd-server-windows").fadeOut("slow");
        $("#upd_server_account").find("option").eq(0).prop("selected",true);
    });

    //更改按钮
    $("#upd-server-change").click(function () {
        $("#upd-server_name").removeAttr("readonly");
        $("#upd-server_remark").removeAttr("readonly");
        $("#upd_server_account").removeAttr("disabled");
    });

    //确认更改
    $("#upd-server-confirm").click(function () {
        var id = $("#upd-server_name").attr("data-upd-server-id");
        var name = $("#upd-server_name").val();
        var a_name = $("#upd_server_account option:selected").text();
        var remark = $("#upd-server_remark").text();
        if (name == null){
            alert("用户名为空");return false;
        }
        $.ajax({
            url:"http://local.domain.cn/Server/update_server",
        data:{
                "id":id,
                "name":name,
                "a_name":a_name,
                "remark":remark
        },
            dataType:"json",
            type:"POST",
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

    //    添加主机
    $("#add-server-confirm").click(function () {
        var data = {
            "a_id": $("#add_server_account option:selected").attr("data-account-id"),
            "server_name": $("#add-server_name").val(),
            "server_ip": $("#add-server_ip").val(),
            "remark": $("#add-server_remark").val(),
            "u_id":<?php print_r($_SESSION['user_id']);?>
        };
        $.ajax({
                url: "http://local.domain.cn/Server/add_server",
                data: {
                    "data": data
                },
                dataType: "json",
                type: "POST",
                success: function (data) {
                    if (data.code == 200) {
                        alert(data.data);
                        window.location.reload();
                    } else if (data.code == 202) {
                        alert(data.data);
                    }
                }
            }
        )
    });
    //    删除主机
    $(".server-del").click(function () {
        var id = $(this).closest("tr").attr("data-server-id");
        var ip = $(this).closest("tr").find(".server-ip").text();
        $.ajax({
            url: "http://local.domain.cn/Server/delete_server",
            data: {
                "id": id,
                "ip": ip
            },
            dataType: "json",
            type: "POST",
            success: function (data) {
                if (data.code == 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code == 202) {
                    var r = confirm(data.data);
                    if (r) {
                        force_delete(id, ip);
                    }
                }
            }
        })
    });

    //强制删除
    function force_delete(id, ip) {
        $.ajax({
            url: "http://local.domain.cn/Server/force_delete",
            data: {
                "id": id,
                "ip": ip
            },
            dataType: "json",
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
    }

    //    状态更改
    $(".server-status1").click(function () {
        var id = $(this).closest("tr").attr("data-server-id");
        var status = $(this).attr("data-server-status");
        $.ajax({
            url: "http://local.domain.cn/Server/showdown_server",
            data: {
                "status": status,
                "id": id
            },
            dataType: "json",
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
    })

</script>
</html>