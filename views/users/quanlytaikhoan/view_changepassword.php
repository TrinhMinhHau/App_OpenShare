<?php include('../layout/header.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<!-- <link rel="stylesheet" href="../../../assets/vendor/bootstrap/css/bootstrap.min.css"> -->
<div class="row col-lg-8 border rounded mx-auto mt-5 p-2 shadow-lg bg-white">
    <?php if (isset($_SESSION['cpw_error'])) {
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $_SESSION['cpw_error'];
            unset($_SESSION['cpw_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    } ?>
    <div class="col-md-4 text-center" style="display: block; justify-content: center; margin-top: auto; margin-bottom: auto;">

        <img src="<?= $result['user']['photoURL'] ?>" class="img-fluid rounded" style="width: 180px;height:180px;object-fit: cover;">

        <div>
            <a href="../TrangChu/index.php">
                <button class="mx-auto m-1 btn-sm btn btn-warning text-white">Về trang chủ</button>
            </a>
        </div>
    </div>
    <div class="col-md-8">

        <div class="h2" style="font-weight: bold;">Đổi mật khẩu</div>

        <form method="post" action="./scrip_changpassword.php" id="form">
            <table class="table">
                <tr>
                    <th> Mật khẩu cũ</th>
                    <td>
                        <input type="hidden" name="idUser" value="<?= $result['user']['idUser'] ?>">
                        <input type="password" name="password" class="form-control" pattern=".{6,}" required>
                    </td>
                </tr>
                <tr>
                    <th> Mật khẩu mới</th>
                    <td>
                        <input type="password" name="newpassword" id="newPassword" class="form-control" pattern=".{6,}" required>
                    </td>
                    <td>
                        <span id="err_ms1" class="err"></span>

                    </td>

                </tr>
                <tr>
                    <th> Nhập lại mật khẩu mới</th>
                    <td>
                        <input type="password" id="renewPassword" class="form-control" pattern=".{6,}" required>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><span id="err_ms2" class="text-warning err"></span></td>
                </tr>
            </table>
            <div id="err_dl" style="margin-bottom: 5px;"></div>
            <div class="p-2">
                <button type="submit" class="btn btn-primary float-end" id="changepassword" name="submit">Đổi mật khẩu</button>
            </div>
        </form>

    </div>
</div>

</body>
<?php include('../layout/footer.php'); ?>

<script>
    $(document).ready(function() {
        $("#renewPassword").blur(function() {
            const newPassword = $('#newPassword').val();
            const confirmPassword = $('#renewPassword').val();
            if (newPassword !== confirmPassword) {
                $('#err_ms2').html('Mật khẩu không khớp');
            }
        });
        $("#form").submit(function(event) {
            const newPassword = $('#newPassword').val();
            const confirmPassword = $('#renewPassword').val();
            if (newPassword !== confirmPassword) {
                $('#err_ms2').html('Mật khẩu không khớp');
                event.preventDefault();
            }
        });
    });
</script>