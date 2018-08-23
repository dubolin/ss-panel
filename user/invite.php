<?php
require_once '_main.php';
$I = new \Ss\User\Invite($uid);
$key = $U->InviteKey();
?>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                邀请
                <small>Invite</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">我的邀请码</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <p><code><?php echo $key;?></code></p>
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?php echo $site_url."user/before.php?invite=".$key;?>">
                            </div>

                            <div id="msg-error" class="alert alert-warning alert-dismissable" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-warning"></i> 出错了!</h4>
                                <p id="msg-error-p"></p>
                            </div>

                        </div><!-- /.box -->

                        <div class="box-header">
                            <h3 class="box-title">我邀请的朋友</h3>
                        </div><!-- /.box-header -->

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>###</th>
                                    <th>邮件</th>
                                    <th>时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $a = 0;
                                $list = $I->InviteArray($uid);
                                foreach($list as $data ){
                                    ?>
                                    <tr>
                                        <td><?php echo $a;$a++; ?></td>
                                        <td><?php 
                                        $s = split('@', $data['email']);
                                        echo substr($s[0], 0,-4) .'****@'.$s[1];
                                        ?></td>
                                        <td><?php echo $data['reg_date']?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-body">

                            <div class="callout callout-warning">
                                <h4>注意！</h4>
                                <p>邀请码请给认识的需要的人。</p>
                                <p>邀请有记录，若被邀请的人违反用户协议，您将会有连带责任。</p>
                            </div>

                            <div class="callout callout-info">
                                <h4>说明</h4>
                                <p>邀请朋友注册可获得<?php echo $user_invite_get ?>M流量。</p>
                            </div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col (right) -->




            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
<?php
require_once '_footer.php'; ?>

<script>
    $(document).ready(function(){
        $("#invite").click(function(){
            $.ajax({
                type:"GET",
                url:"_invite.php",
                dataType:"json",
                success:function(data){
                    if(data.ok){
                        window.location.reload();
                    }else{
                        $("#msg-error").show();
                        $("#msg-error-p").html(data.msg);
                    }
                },
                error:function(jqXHR){
                    alert("发生错误："+jqXHR.status);
                    // 在控制台输出错误信息
                    console.log(removeHTMLTag(jqXHR.responseText));
                }
            })
        })
    })
</script>
<script type="text/javascript">
    // 过滤HTML标签以及&nbsp 来自：http://www.cnblogs.com/liszt/archive/2011/08/16/2140007.html
    function removeHTMLTag(str) {
        str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
        str = str.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
        str = str.replace(/\n[\s| | ]*\r/g, '\n'); //去除多余空行
        str = str.replace(/&nbsp;/ig, ''); //去掉&nbsp;
        return str;
    }
</script>
