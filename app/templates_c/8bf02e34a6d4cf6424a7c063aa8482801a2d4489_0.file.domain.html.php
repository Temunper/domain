<?php
/* Smarty version 3.1.33, created on 2019-05-22 17:42:19
  from 'C:\dev\domain\app\view\domain\domain.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5ce5197b0d1b35_45472157',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8bf02e34a6d4cf6424a7c063aa8482801a2d4489' => 
    array (
      0 => 'C:\\dev\\domain\\app\\view\\domain\\domain.html',
      1 => 1558513568,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ce5197b0d1b35_45472157 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<a href="http://local.domain.cn/Account/account " >子账号管理</a>
<a href="http://local.domain.cn/Server/server" >主机管理</a>
<a href="http://local.domain.cn/Login/logout" >退出</a>
<a href="http://local.domain.cn/Domain/domain?less_thirty=1" >您有
   <?php if (isset($_smarty_tpl->tpl_vars['less_count']->value)) {
echo $_smarty_tpl->tpl_vars['less_count']->value;
}?>条接近到期的域名</a>
<a href="http://local.domain.cn/Domain/domain?over_due=1">到期域名</a>&nbsp;&nbsp;
<a href="http://local.domain.cn/Domain/domain">返回</a>
<p/>
账号类型：<input type="text" id="search-account_type">（如：百度云）&nbsp;&nbsp;<p/>
<i style="right: 13px;position: relative">使用账号:<select id="search-a_id"
                                                       onchange="give_ip(type = 'search')">
        <option id="search-domain-not1"></option>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_account']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
        <option data-acc="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['account_name'];?>
</option>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </select></i>
<i style="right: 13px;position: relative">主机IP:<select id="search-d_ip">
        <option id="search-domain-not2"></option>
    </select></i><input type="button" id="search-confirm1" value="确认">
<p/>
<div>模糊搜索：<input type="text" id="search-obscure"></div>
<div>精确搜索：<input type="text" id="search-exact"></div>
<div>IP搜索：<input type="text" id="search-ip"></div>
</select>
<!--     表格开始           -->
<table border="1" align="center">
    <tr>
        <td></td>
        <td>域名</td>
        <td>所属子账号</td>
        <td>子账号类型</td>
        <td>当前状态</td>
        <td>IP地址</td>
        <td>批量续期</td>
        <td>到期时间</td>
        <td>创建时间</td>
        <td colspan="4">操作</td>
    </tr>
    <?php if (isset($_smarty_tpl->tpl_vars['all_domain']->value)) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_domain']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
    <tr class="domain-table" data-domain-id="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
        <td><input type="checkbox" class="d_id" name="check_id"></td>
        <td class="d_name1"><?php echo $_smarty_tpl->tpl_vars['value']->value['d_name'];?>
</td>
        <td class="account_name"><?php echo $_smarty_tpl->tpl_vars['value']->value['account_name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['account_type'];?>
</td>
        <td class="domain-status" data-domain-status="<?php echo $_smarty_tpl->tpl_vars['value']->value['status'];?>
">
            <?php if ($_smarty_tpl->tpl_vars['value']->value['status'] == '1') {?>
            未到期
        <?php } else { ?>
            已到期
            <?php }?>
        </td>
        <td><select class="d_account">
                <option class="d_ip" selected><?php echo $_smarty_tpl->tpl_vars['value']->value['d_ip'];?>
</option>
            </select></td>
        <td><select class="e-time-domain">
                <option></option>
            </select></td>
        <td class="d_time1"><?php echo $_smarty_tpl->tpl_vars['value']->value['d_time'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['value']->value['option_time'];?>
</td>
        <td><input type="button" value="二级域名管理" class="record-manage" domain-data="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"></td>
        <td><input type="button" value="管理" class="domain-manage" domain-id="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
"></td>
        <td><input type="button" value="续期" class="extend-domain" data-domain-status="<?php echo $_smarty_tpl->tpl_vars['value']->value['status'];?>
"></td>
    </tr>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
   <?php } else { ?>
    <tr><td colspan="11">没有数据</td></tr>
    <?php }?>
    <tr>
        <td colspan="12">
            <input type="button" value="批量更改" style="float: right" id="change-all-domain">
            <input type="button" value="添加域名" style="float: right" id="add-domain">
            <input type="button" value="过滤过期域名" style="float: right" id="not-over_due-domain">
            <input type="button" value="筛选过期域名" style="float: right" id="over_due-domain">
        </td>
    </tr>

    <!-- 续期弹窗      -->
    <div style="width: 100%;height: 100%;position: fixed;display: none" id="extend-domain-windows">
        <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
            <div style="font-size: x-large;float:right" id="extend-domain-close">
                <button>X</button>
            </div>
            <div style="width: 300px;padding-left: 100px">
                <h1 style="left: 15%;position: relative">续期</h1>
                <p/>
                <div>
                    <i>域名:<input type="text" id="extend-d_name" date-d_status="" data-d_id="">
                        <p/></i>
                    <p/>
                    <i>结束日期:<i id="extend-end_date"></i></i>
                    <p/>
                    <i style="right: 29px;position: relative">延长期限期:<select id="extend-d_time">
                            <option></option>
                            <option>1</option>
                            <option>3</option>
                            <option>6</option>
                            <option>12</option>
                        </select>月</i>
                    <p/>
                    <input type="button" value="确认" id="extend-date">
                </div>
            </div>
        </div>
    </div>

    <!--  续期弹窗end  -->
    <!--  添加域名弹窗  -->
    <div style="width: 100%;height: 100%;position: fixed;display: none" id="add-domain-windows">
        <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
            <div style="font-size: x-large;float:right" id="add-domain-close">
                <button>X</button>
            </div>
            <div style="width: 300px;padding-left: 100px">
                <h1 style="left: 15%;position: relative">域名添加</h1>
                <p/>
                <div>
                    <i>域名:<input type="text" id="add-d_name"><a href="#" id="domain-check-d_name">域名检测</a>
                        <p/><i
                                id="check-result"></i></i>
                    <p/>
                    <i style="right: 29px;position: relative">域名类型:<select id="add-d_type">
                            <option>个人</option>
                            <option>公司</option>
                        </select></i>
                    <i style="right: 29px;position: relative">有效期:<select id="add-d_time">
                            <option></option>
                            <option>1</option>
                            <option>3</option>
                            <option>6</option>
                            <option>12</option>
                        </select>月</i>
                    <p/>
                    <i style="right:15px;position: relative">所有者:<input type="text" id="add-d_owner"
                                                                        style="left: 100px"></i>
                    <p/>
                    <i style="right: 62px;position: relative">所有人身份证:<input type="text" id="add-d_identify"></i>
                    <p/>
                    <i style="right: 13px;position: relative">使用账号:<select id="add-a_id"
                                                                           onchange="give_ip(type = 'add')">
                            <option id="add-domain-not"></option>
                            <?php if (isset($_smarty_tpl->tpl_vars['all_account']->value)) {?>
                           <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_account']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
                            <option><?php echo $_smarty_tpl->tpl_vars['value']->value['account_name'];?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            <?php }?>
                        </select></i>
                    <i style="right: 13px;position: relative">主机IP:<select id="add-d_ip">
                            <option></option>
                        </select></i>
                    <p/>
                    <i style="right: 31px;position: relative">主用DNS:<input type="text" id="add-d_dns_active"></i>
                    <p/>
                    <i style="right: 31px;position: relative">备用DNS:<input type="text" id="add-d_dns_standby"></i>
                    <p/>
                    <i>备注:<input type="text" id="add-remark"></i>
                    <p/>
                    <input type="button" value="confirm" id="add-confirm">
                </div>
            </div>
        </div>
    </div>
    <!--  添加域名弹窗end  -->
    <!--  管理弹窗  -->
    <div style="width: 100%;height: 100%;position: fixed;display: none" id="update-domain-windows" +>
        <div style="width:400px;height: 600px;top: 100px;z-index: 100;left:40% ;position: fixed;border: groove;background-color: grey">
            <div style="font-size: x-large;float:right" id="update-domain-close">
                <button>X</button>
            </div>
            <div style="width: 300px;padding-left: 100px">
                <h1 style="left: 15%;position: relative">域名管理</h1>
                <p/>
                <div>
                    <i>域名:<i id="update-d_name"></i></i>
                    <p/>
                    <i style="right: 29px;position: relative">域名类型:<i id="update-d_type"></i></i>
                    <p/>
                    <i style="right:15px;position: relative">所有者:<input type="text" id="update-d_owner"
                                                                        style="left: 100px" readonly></i>
                    <p/>
                    <i style="right: 62px;position: relative">所有人身份证:<input type="text" id="update-d_identify" readonly></i>
                    <p/>
                    <i style="right: 13px;position: relative">使用账号:<select id="update-a_id"
                                                                           onchange="give_ip(type = 'upd')" disabled>
                            <option id="upd-domain-not1"></option>
                            {foreach  $all_account as $value}
                            <option data-acc="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">{$value.account_name}</option>
                            {/foreach}
                        </select></i>
                    <i style="right: 13px;position: relative">主机IP:<select id="update-d_ip" disabled>
                            <option id="upd-domain-not2"></option>
                        </select></i>
                    <p/>
                    <i style="right: 31px;position: relative">主用DNS:<input type="text" id="update-d_dns_active"
                                                                           readonly></i>
                    <p/>
                    <i style="right: 31px;position: relative">备用DNS:<input type="text" id="update-d_dns_standby"
                                                                           readonly></i>
                    <p/>
                    <i>备注:<input type="text" id="update-remark" readonly></i>
                    <p/>
                    <!--                    <input type="button" value="提交修改" id="update-confirm">&nbsp;&nbsp;-->
                    <input type="button" value="修改IP和备注" id="change-ip">
                    <input type="button" value="确认修改" id="update-confirm">
                    <input type="button" value="删除域名" id="delete-confirm">
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--  管理弹窗end    -->
</table>
<!--     表格结束          -->
</body>
<?php echo '<script'; ?>
 src="../public/static/jquery/jquery-3.3.1.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../public/static/jquery/jQuery.md5.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

    //    添加域名弹窗
    $("#add-domain").click(function () {
        $("#add-domain-windows").fadeIn("slow");
    });
    $("#add-domain-close").click(function () {
        $("#add-domain-windows").fadeOut("slow");
        $("#add-a_id").find("option").eq(0).prop("selected", true);
        give_ip(type = "add");
    });
    //管理域名弹窗
    $(".domain-manage").click(function () {
        var d_id = $(this).closest('tr').attr("data-domain-id");
        $.ajax(
            {
                url: "http://local.domain.cn/Domain/get_id_domain",
                dataType: "json",
                data: {
                    "d_id": d_id
                },
                type: "POST",
                success: function (data) {
                    $("#update-d_name").val(data.domain_result['id']);
                    $("#update-d_name").text(data.domain_result['d_name']);
                    $("#update-d_type").text(data.domain_result['d_type']);
                    $("#update-d_owner").val(data.domain_result['d_owner']);
                    $("#update-d_identify").val(data.domain_result['d_identify']);
                    $("#upd-domain-not1").text(data.domain_result['account_name']);
                    $("#upd-domain-not2").text(data.domain_result['d_ip']);
                    $("#update-d_dns_active").val(data.domain_result['d_dns_active']);
                    $("#update-d_dns_standby").val(data.domain_result['d_dns_standby']);
                    $("#update-remark").val(data.domain_result['remark']);
                    $("#update-option_time").text(data.domain_result['option_time']);
                }
            }
        );
        // give_ip(type="upd");
        $("#update-domain-windows").fadeIn("slow");
    });
    $("#update-domain-close").click(function () {
        $("#update-domain-windows").fadeOut("slow");
        $("#update-d_owner").attr("readonly", "readonly");
        $("#update-d_identify").attr("readonly", "readonly");
        $("#update-d_ip").attr("disabled", "disabled");
        $("#update-a_id").attr("disabled", "disabled");
        $("#update-d_dns_active").attr("readonly", "readonly");
        $("#update-d_dns_standby").attr("readonly", "readonly");
        $("#update-remark").attr("readonly", "readonly");
        $("#update-a_id").find("option").eq(0).prop("selected", true);
        $("#update-d_ip").find("option").eq(0).prop("selected", true);
    });

    //   续期弹窗
    $(".extend-domain").click(function () {
        $("#extend-domain-windows").fadeIn("slow");
        $("#extend-d_name").val($(this).closest("tr").find(".d_name1").text()).attr("readonly", "readonly");
        $("#extend-end_date").text($(this).closest("tr").find(".d_time1").text());
        $("#extend-d_name").attr("date-d_id", $(this).closest("tr").attr("data-domain-id"));
        $("#extend-d_name").attr("date-d_status", $(this).attr("data-domain-status"));
    });
    $("#extend-domain-close").click(function () {
        $("#extend-domain-windows").fadeOut("slow");
    });
    //  确认续期
    $("#extend-date").click(function () {
        var domain = {
            "id": $("#extend-d_name").attr("date-d_id"),
            "status": $("#extend-d_name").attr("date-d_status"),
            "d_time": $("#extend-end_date").text(),
            "e_date": $("#extend-d_time option:selected").val()
        };
        $.ajax({
            url: "http://local.domain.cn/Domain/extend_domain",
            dataType: "json",
            type: "POST",
            data: {
                "domain": domain
            },
            success: function (data) {
                if (data.code === 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code === 202) {
                    alert(data.data);
                }
            }
        })
    });
    //   添加域名
    $("#add-confirm").click(function () {
        var data = {
            "d_name": $("#add-d_name").val(),
            "d_time": $("#add-d_time option:selected").val(),
            "d_type": $("#add-d_type option:selected").val(),
            "d_owner": $("#add-d_owner").val(),
            "d_identify": $("#add-d_identify").val(),
            "a_id": $("#add-a_id option:selected").val(),
            "d_ip": $("#add-d_ip option:selected").val(),
            "d_dns_active": $("#add-d_dns_active").val(),
            "d_dns_standby": $("#add-d_dns_standby").val(),
            "remark": $("#add-remark").val()
        };
        $.ajax({
            url: "http://local.domain.cn/Domain/add_domain",
            type: "POST",
            dataType: "json",
            data: {
                "data": data
            },
            success: function (data) {
                if (data.code === 200) {
                    alert(data.data);
                    window.location.reload();
                } else if (data.code === 202) {
                    alert(data.data);
                }
            }
        })

    });

    //选择账号并根据账号下的pc给出其下的IP地址
    function give_ip(type) {
        var ip = $("update-domain-not2").text();
        if (type == "add") {
            var account_name = $("#add-a_id option:selected").val();
        } else if (type == "upd") {
            var account_name = $("#update-a_id option:selected").val();
        } else if (type == "search") {
            var account_name = $("#search-a_id option:selected").val();
        }
        $.ajax({
            url: "http://local.domain.cn/Server/get_server_ip",
            dataType: "json",
            type: "POST",
            data: {
                "a_name": account_name
            },
            success: function (data) {
                $("#add-d_ip").html("<option></option>");
                $("#update-d_ip").html("<option id='upd-domain-not2'>" + ip + "</option>");
                $("#search-d_ip").html("<option></option>");
                for (i = 0; i < data.data.length; i++) {
                    if (type == "add") {
                        $("#add-d_ip").append("<option>" + data.data[i]['server_ip'] + "</option>");
                    } else if (type == "upd") {
                        $("#update-d_ip").append("<option>" + data.data[i]['server_ip'] + "</option>");
                    } else if (type == "search") {
                        $("#search-d_ip").append("<option>" + data.data[i]['server_ip'] + "</option>");
                    }
                }
            }
        })
    }

    //domain上的下拉框获取IP地址
    $(".d_id").click(function () {
        var _this = $(this);
        var d_ip = _this.closest("tr").find(".d_ip").text();
        if ($(this).prop("checked") == true) {
            $(this).closest("tr").find(".e-time-domain").html("<option></option><option>1</option><option>3</option>6<option>12</option>");
            var account_name = $(this).closest("tr").find(".account_name").text();
            $.ajax({
                url: "http://local.domain.cn/Server/get_server_ip",
                dataType: "json",
                type: "POST",
                data: {
                    "a_name": account_name
                }, success: function (data) {
                    _this.closest("tr").find(".d_account").html("<option class='d_ip'>" + d_ip + "</option>");
                    for (i = 0; i < data.data.length; i++) {
                        _this.closest("tr").find(".d_account").append("<option>" + data.data[i]['server_ip'] + "</option>");
                    }
                }
            });
        } else {
            _this.closest("tr").find(".d_account").html("<option class='d_ip'>" + d_ip + "</option>");
        }
    });
    //测试域名是否正确
    $("#domain-check-d_name").click(function () {
        $.ajax({
                url: "http://local.domain.cn/Domain/check_domain_button",
                type: "POST",
                dateType: "json",
                data: {
                    "d_name": $("#add-d_name").val()
                },
                success: function (data) {
                    var dat = jQuery.parseJSON(data);
                    $("#check-result").text(dat.data);
                }
            }
        )
    });

    // //更改域名信息
    // //    持有人
    // $("#change-owner").click(function () {
    //     $("#update-d_owner").removeAttr("readonly");
    //     $("#update-d_identify").removeAttr("readonly");
    // });
    // //    类型
    // $("#change-type").click(function () {
    //     var d_type = $("#update-d_type").text();
    //     if (d_type == "个人") {
    //         $("#update-d_type").text("公司");
    //     } else {
    //         $("#update-d_type").text("个人");
    //     }
    // });
    //   ip

    $("#change-ip").click(function () {
        $("#update-d_ip").removeAttr("disabled");
        $("#update-a_id").removeAttr("disabled");
        $("#update-d_dns_active").removeAttr("readonly");
        $("#update-d_dns_standby").removeAttr("readonly");
        $("#update-remark").removeAttr("readonly");
    });

    // //    备注
    // $("#change-remark").click(function () {
    //     $("#update-remark").removeAttr("readonly");
    // });
    //    确认提交

    $("#update-confirm").click(function () {
        var data = {
            "d_name": $("#update-d_name").text(),
            // "d_type": $("#update-d_type").text(),
            // "d_owner": $("#update-d_owner").val(),
            // "d_identify": $("#update-d_identify").val(),
            "a_id": $("#update-a_id option:selected").val(),
            "d_ip": $("#update-d_ip option:selected").val(),
            "d_dns_active": $("#update-d_dns_active").val(),
            "d_dns_standby": $("#update-d_dns_standby").val(),
            "remark": $("#update-remark").val()
        };
        $.ajax({
            url: "http://local.domain.cn/Domain/update_domain",
            dateType: "json",
            type: "POST",
            data: {
                "data": data
            },
            success: function (data) {
                var data = jQuery.parseJSON(data);
                if (data.code == 200) {
                    var id = $("#update-d_name").val();
                    update_domain_msg(id);
                    alert("修改成功");
                } else {
                    alert("修改失败");
                }

            }
        })
    });

    function update_domain_msg(id) {
        d_id = id;
        $.ajax(
            {
                url: "http://local.domain.cn/Domain/get_id_domain",
                dataType: "json",
                data: {
                    "d_id": d_id
                },
                type: "POST",
                success: function (data) {
                    console.log(data);
                    $("#update-d_name").text(data.domain_result['d_name']);
                    $("#update-d_type").text(data.domain_result['d_type']);
                    $("#update-d_owner").val(data.domain_result['d_owner']);
                    $("#update-d_identify").val(data.domain_result['d_identify']);
                    $("#upd-domain-not1").val(data.domain_result['account_name']);
                    $("#upd-domain-not2").val(data.domain_result['d_ip']);
                    $("#update-d_dns_active").val(data.domain_result['d_dns_active']);
                    $("#update-d_dns_standby").val(data.domain_result['d_dns_standby']);
                    $("#update-remark").val(data.domain_result['remark']);
                    $("#update-option_time").text(data.domain_result['option_time']);
                    $("#update-d_owner").attr("readonly", "readonly");
                    $("#update-d_identify").attr("readonly", "readonly");
                    $("#update-d_ip").attr("disabled", "disabled");
                    $("#update-a_id").attr("disabled", "disabled");
                    $("#update-d_dns_active").attr("readonly", "readonly");
                    $("#update-d_dns_standby").attr("readonly", "readonly");
                    $("#update-remark").attr("readonly", "readonly");
                }
            }
        );
    }

    // //    域名状态更改
    // $(".domain-status1").click(function () {
    //     var id = $(this).closest("tr").attr("data-domain-id");
    //     if ($(this).attr("data-domain-status") == 1) {
    //         var status = 0;
    //     } else {
    //         var status = 1;
    //     }
    //     $.ajax(
    //         {
    //             url: " http://local.domain.cn/Domain/update_domain_status",
    //             data: {
    //                 "status": status,
    //                 "id": id
    //             },
    //             dataType: "json",
    //             type: "POST",
    //             success: function (data) {
    //                 if (data.code == 200) {
    //                     alert(data.data);
    //                     window.location.href = "http://local.domain.cn/Domain/domain";
    //                 } else if (data.code == 202) {
    //                     alert(data.data);
    //                 }
    //             }
    //         }
    //     )
    // });
    //域名删除

    $("#delete-confirm").click(function () {

        var r = confirm('确认要删除吗?若删除顶级域名那么二级域名将会被删除');
        if (r == true) {
            goDelete();
        }
    });

    function goDelete() {
        var d_name = $("#update-d_name").text();
        $.ajax({
            url: "http://local.domain.cn/Domain/delete_domain",
            data: {"d_name": d_name},
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

    //    解析
    $(".record-manage").click(function () {
        var d_id = $(this).closest("tr").attr("data-domain-id");
        var account_name = $(this).closest("tr").find(".account_name").text();
        window.location.href="http://local.domain.cn/Record/record?d_id=" + d_id + "&account_name=" + account_name + "&init=1";
    });

    //    批量更改
    $("#change-all-domain").click(function () {
        var bool = 0;
        $("input[name='check_id']").each(function () {
            if ($(this).prop("checked") == true) {
                bool = bool + 1;
                var domain = {
                    "id": $(this).closest("tr").attr("data-domain-id"),
                    "d_ip": $(this).closest("tr").find(".d_account option:selected").val()
                };
                var e_date = $(this).closest("tr").find(".e-time-domain option:selected").val();
                $.ajax({
                    url: "http://local.domain.cn/Domain/update_domain2",
                    dataType: "json",
                    type: "POST",
                    data: {
                        "domain": domain
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });
                if (e_date != 0) {
                    var domain = {
                        "id": $(this).closest("tr").attr("data-domain-id"),
                        "status": $(this).closest("tr").find(".extend_domain").attr("data-domain-status"),
                        "d_time": $(this).closest("tr").find(".d_time1").text(),
                        "e_date": e_date
                    };
                    $.ajax({
                        url: "http://local.domain.cn/Domain/extend_domain",
                        dataType: "json",
                        type: "POST",
                        data: {
                            "domain": domain
                        },
                        success: function (data) {
                            console.log(data);
                        }
                    })
                }
            }
        });
        if (bool == 0) {
            alert("请先勾选");
        } else {
            alert("更改完成");
            window.location.reload();
        }
    });

    //    查找
    //    查找类型
    $("#search-account_type").keyup(function () {
        if (event.keyCode == 13) {
            var text = $(this).val();
            window.location.href="http://local.domain.cn/Domain/domain?search_account_type=1&account_type=" + text;
        }
    });
    // 账号和账号IP搜索
    $("#search-confirm1").click(function () {
        var a_id = $("#search-a_id option:selected").val();
        var d_ip = $("#search-d_ip option:selected").val();
        window.location.href="http://local.domain.cn/Domain/domain?search_account_id=1&a_id=" + a_id + "&d_ip=" + d_ip;
    });
    //    根据IP地址搜索
    $("#search-ip").keyup(function () {
        if (event.keyCode == 13) {
            var d_ip = $(this).val();
            window.location.href="http://local.domain.cn/Domain/domain?search_d_ip=1&d_ip=" + d_ip;
        }
    });
    //     模糊搜索
    $("#search-obscure").keyup(function () {
        if (event.keyCode == 13) {
            var d_name = $(this).val();
            window.location.href="http://local.domain.cn/Domain/domain?search_obscure=1&d_name=" + d_name;
        }
    });
    //    精确搜索
    $("#search-exact").keyup(function () {
        if (event.keyCode == 13) {
            var d_name = $(this).val();
            window.location.href="http://local.domain.cn/Domain/domain?search_exact=1&d_name=" + d_name;
        }
    })
    //    过滤过期域名
    $("#not-over_due-domain").click(function () {
        $(".domain-table").each(function () {
            var status = $(this).find(".domain-status").attr("data-domain-status");
            if (status == 0) {
                $(this).css("display", "none");
            } else {
                $(this).css("display", "table-row");
            }
        })
    })
    //    过滤未过期域名
    $("#over_due-domain").click(function () {
        $(".domain-table").each(function () {
            var status = $(this).find(".domain-status").attr("data-domain-status");
            if (status == 1) {
                $(this).css("display", "none");
            } else {
                $(this).css("display", "table-row");
            }
        })
    });
<?php echo '</script'; ?>
>
</html><?php }
}
