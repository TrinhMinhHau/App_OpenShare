<?php include('../layout/header.php'); ?>



<div class="Menu" style="text-align:center; position:fixed">
    <a <?php if (isset($_GET['thamso']) and $_GET['thamso'] == '../history/view_historyGive.php') echo "class='active2'" ?>href="?thamso=../history/view_historyGive.php">Đã cho đi</a>
    <a <?php if (isset($_GET['thamso']) and $_GET['thamso'] == '../history/view_historyReceive.php') echo "class='active2'" ?> href="?thamso=../history/view_historyReceive.php">Đã nhận lại</a>
</div>
<div class="noidung">
    <?php if (isset($_GET['thamso'])) {
        include($_GET['thamso']);
    } else {
        include('../history/view_historyGive.php');
    }
    ?>

</div>
<style>
    .Menu {
        margin-top: 24px;
    }

    .Menu a {

        margin-left: 10px;
        padding: 10px 15px;
        background: #fff;
        color: #333;
        transition: 1s;
        max-width: 100%;
        border-radius: 3px;
        text-decoration: none;
        display: block;
        margin-bottom: 20px;
    }

    .Menu a.active2 {
        margin-left: 10px;
        background-color: #0056b3;
        color: #fff
    }

    .Menu a:hover {
        text-decoration: underline;

        background: #0056b3;
        color: #fff
    }
</style>

<?php include('../layout/footer.php'); ?>