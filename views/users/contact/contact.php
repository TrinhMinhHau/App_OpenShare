<?php include('../layout/header.php'); ?>

<body>
    <div class="content contact-main">
        <!----start-contact---->
        <div class="contact-info">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.7062240321243!2d109.20018721429832!3d12.268148933243067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317067ed3a052f11%3A0xd464ee0a6e53e8b7!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBOaGEgVHJhbmc!5e0!3m2!1svi!2s!4v1667818564124!5m2!1svi!2s" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="wrap">
                <div class="contact-grids">
                    <div class="col_1_of_bottom span_1_of_first1">
                        <h5>Địa chỉ</h5>
                        <ul class="list3" style="padding: 0;">
                            <li>
                                <img src="../assests/images/homepro.png" alt="">
                                <div class="extra-wrap">
                                    <p>Số 2 Nguyễn Đình Chiểu<br>Vĩnh Thọ, Nha Trang, Khánh Hòa.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col_1_of_bottom span_1_of_first1">
                        <h5>Số điện thoại</h5>
                        <ul class="list3" style="padding: 0;">
                            <li>
                                <img src="../assests/images/phone.png" alt="">
                                <div class="extra-wrap">
                                    <p><span>Di động:</span> 0355587440</p>
                                </div>
                                <img src="../assests/images/zalo-removebg-preview.png" width="25px" height="25px" alt="">
                                <div class="extra-wrap">
                                    <!-- <p><span>Zalo:</span> 0355587440</p> -->
                                    <p><span class="zalo">Zalo:<a href="https://zalo.me/0355587440"> 0355587440</a></span> </p>

                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col_1_of_bottom span_1_of_first1">
                        <h5>Email</h5>
                        <ul class="list3" style="padding: 0;">
                            <li>
                                <img src=" ../assests/images/email.png" alt="">
                                <div class="extra-wrap">
                                    <p><span class="mail"><a href="mailto:yoursite.com">hau.tm.61cntt@ntu.edu.vn</a></span></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!----//End-contact---->
    </div>
</body>


</html>

<?php include('../layout/footer.php'); ?>

<style>
    .contact-main {
        padding-top: 0;
        border-top: 1px solid #eee;
        margin: -0em 0 9em;
    }

    /*----*/
    .wrap {
        margin-left: 100px;
    }

    /*  Contact Form  */
    .contact form {
        font-family: "Open Sans", sans-serif;
    }

    .map {
        margin-bottom: 30px;
    }

    .list3 li>img {
        float: left;
        margin-right: 10px;
    }

    .extra-wrap {
        overflow: hidden;
    }

    .extra-wrap p {
        color: #a5a5a5;
        line-height: 1.8em;
        font-size: 0.85em;
        margin-bottom: 5px;
        font-family: "Open Sans", sans-serif;
    }

    span.mail a,
    span.zalo a {
        color: #e45d5d;
    }

    span.mail a:hover,
    span.zalo a:hover {
        color: #626262;
    }

    ul {
        list-style: none;
        margin: 0px;
        /* padding: 0px; */
    }

    .span_1_of_first1 h5 {
        color: #08080b;
        font-weight: 700;
        font-size: 1.2em;
        padding-bottom: 0.5em;
        text-transform: uppercase;
    }

    .span_1_of_first1 {
        width: 29.5%;
    }

    .col_1_of_bottom:first-child {
        margin-left: 0;
    }

    .col_1_of_bottom {
        display: block;
        float: left;
        margin: 1% 0 1% 3.6%;
    }

    .contact-grids {
        margin-bottom: 1em;
    }

    .clear {
        clear: both;
    }

    /* Style for contact section */
    @media (max-width: 900px) {
        .wrap {
            width: 70%;
        }

        .text2 input[type="text"],
        .text2 textarea {
            width: 96.2%;
            resize: none;
        }

        .col_1_of_bottom {
            width: 50%;
        }

    }
</style>