<?php include('../layout/header.php'); ?>

<body>
    <?php


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // include "PHPMailer/src/PHPMailer.php";
    // include "PHPMailer/src/Exception.php";
    // include "PHPMailer/src/OAuth.php";
    // include "PHPMailer/src/POP3.php";
    // include "PHPMailer/src/SMTP.php";


    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

        $mail->SMTPAuth = true;
        if (isset($_POST['submit'])) {                             // Enable SMTP authentication
            $mail->Username = $_POST['email'];                 // SMTP username
            $mail->Password = $_POST['password'];                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($_POST['email'], $_POST['name']);
            $mail->addAddress('hau.tm.61cntt@ntu.edu.vn', 'TrinhMinhHau');     // Add a recipient              // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');

            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $_POST['subject'];
            $mail->Body    = $_POST['message'];
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // echo "<h2 style='text-align:center;color:red;'>" . 'Gửi phản hồi thành công, chúng tôi sẽ phản hồi bạn sớm nhất!!!' . "</h2>";
            echo "<script>
			alert('Gửi phản hồi thành công, chúng tôi sẽ phản hồi bạn sớm nhất!!!');
			</script>";
        }
    } catch (Exception $e) {
        echo "<script>
        alert('Gửi thất bại: $mail->ErrorInfo');
        </script>";
    }

    ?>
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
                <form method="post" action="">
                    <div class="contact-form">
                        <div class="contact-to">
                            <input type="text" class="text" name="name" value="Tên..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Tên...';}" required>
                            <input type="text" class="text" name="email" value="Email..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email...';}" required>
                            <input type="text" class="text" name="subject" value="Tiêu đề..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Chủ đề...';}" required>
                            <input type="password" class="text" name="password" placeholder="Mật khẩu App..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Mật khẩu...';} " style="margin-left: 10px;" required>
                        </div>
                        <div class="text2">
                            <textarea value="Nội dung..." name="message" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Nội dung...';}">Nội dung...</textarea>
                        </div>
                        <span><input type="submit" class="" value="Gửi" name="submit"></span>
                        <div class="clear"></div>
                    </div>
                </form>
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

    .contact-to input[type="text"] {
        padding: 12px 10px;
        width: 20%;
        font-family: "Open Sans", sans-serif;
        margin: 12px 0;
        border: 1px solid rgba(192, 192, 192, 0.61);
        color: #626262;
        background: #fff;
        float: left;
        outline: none;
        font-size: 0.85em;
        transition: border-color 0.3s;
        -o-transition: border-color 0.3s;
        -ms-transition: border-color 0.3s;
        -moz-transition: border-color 0.3s;
        -webkit-transition: border-color 0.3s;
        box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -webkit-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -o-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
    }

    .contact-to input[type="text"]:nth-child(2),
    .contact-to input[type="text"]:nth-child(3) {
        margin-left: 10px;
    }

    ul {
        list-style: none;
        margin: 0px;
        /* padding: 0px; */
    }

    .text2 input[type="text"],
    .text2 textarea {
        width: 82%;
        margin: 12px 0;
        border: 1px solid rgba(192, 192, 192, 0.61);
        color: #626262;
        font-family: "Open Sans", sans-serif;
        outline: none;
        margin-bottom: 25px;
        height: 100px;
        padding: 12px 10px;
        font-size: 0.85em;
        transition: border-color 0.3s;
        -o-transition: border-color 0.3s;
        -ms-transition: border-color 0.3s;
        -moz-transition: border-color 0.3s;
        -webkit-transition: border-color 0.3s;
        box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -webkit-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -o-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
    }

    .text2 textarea {
        height: 180px;
    }

    .text2 input[type="text"]:hover,
    .text2 textarea:hover,
    .contact-to input[type="text"]:hover {
        border: 1px solid rgba(228, 93, 93, 0.33);
    }

    .contact-form input[type="submit"] {
        background: #e45d5d;
        color: #fff;
        padding: 0.9em 3em;
        display: inline-block;
        text-transform: uppercase;
        transition: 0.5s all;
        -webkit-transition: 0.5s all;
        -moz-transition: 0.5s all;
        -o-transition: 0.5s all;
        border-radius: 0.3em;
        -webkit-border-radius: 0.3em;
        -moz-border-radius: 0.3em;
        -o-border-radius: 0.3em;
        font-size: 0.875em;
        border-top: none;
        border-right: none;
        border-left: none;
        border-bottom: 4px solid #b93838;
        outline: none;
        cursor: pointer;
        font-family: "Open Sans", sans-serif;
    }

    .contact-form input[type="submit"]:hover {
        background: #1c1c20;
        border-bottom: 4px solid #333;
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

    input[type='password'] {
        margin-left: 50px;
        padding: 12px 10px;
        width: 20%;
        font-family: "Open Sans", sans-serif;
        margin: 12px 0;
        border: 1px solid rgba(192, 192, 192, 0.61);
        color: #626262;
        background: #fff;
        float: left;
        outline: none;
        font-size: 0.85em;
        transition: border-color 0.3s;
        -o-transition: border-color 0.3s;
        -ms-transition: border-color 0.3s;
        -moz-transition: border-color 0.3s;
        -webkit-transition: border-color 0.3s;
        box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -webkit-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        -o-box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
    }

    .clear {
        clear: both;
    }

    /* Style for contact section */
</style>