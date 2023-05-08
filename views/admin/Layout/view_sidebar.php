<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="../Trangchu/Trangchu.php">
                <i class="bi bi-grid"></i>
                <span>Tổng quan</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people-fill"></i><span>Quản lý Tài khoản</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <?php if ($result['user']['idRole'] == 1) { ?>
                    <li>
                        <a href="../EmployeeManager/view_displayEmployee.php">
                            <i class="bi bi-circle"></i><span>Quản lý nhân viên</span>
                        </a>
                    </li>
                <?php } else {
                } ?>
                <li>
                    <a href="../UserManager/view_displayUser.php">
                        <i class="bi bi-circle"></i><span>Quản lý người dùng</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <!-- LoaiDoDung -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav1" data-bs-toggle="collapse" href="#">
                <i class="bi bi-text-left"></i><span>Loại đồ dùng</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="../ItemManager/view_displayItem.php">
                        <i class="bi bi-circle"></i><span>Quản lý loại đồ dùng</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- EndLoaiDoDung -->
        <!-- Quanlybaiviet-->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav2" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-post"></i></i><span>Quản lý bài cho</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav2" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="../PostManager/view_displayUnapprovedPost.php">
                        <i class="bi bi-circle"></i><span>Đang đợi duyệt</span>
                    </a>
                </li>
                <li>
                    <a href="../PostManager/view_displayPost.php">
                        <i class="bi bi-circle"></i><span>Bài cho</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- EndLoaiDoDung -->
        <!-- StartThongKe -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-graph-up-arrow"></i><span>Thống kê</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="../Statistical/view_AccountUser.php">
                        <i class="bi bi-circle"></i><span>Tài khoản người dùng</span>
                    </a>
                </li>
                <li>
                    <a href="../Statistical/view_Typefrompost.php">
                        <i class="bi bi-circle"></i><span>Số bài viết theo từng loại</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Thongke -->



</aside><!-- End Sidebar-->