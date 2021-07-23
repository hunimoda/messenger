<?php
    session_start();

    include_once('./function.php');
    if (isset($_SESSION['userid']))
        redirect('./friends.php');

    if (isset($_SERVER['REQUEST_METHOD']) && 
        $_SERVER['REQUEST_METHOD'] == 'POST') {

        include_once('./connect_db.php');
        
        if (isset($_POST['userid'])) {
            $post_username = isset($_POST['username']) ? $_POST['username'] : '';
            $post_email = isset($_POST['email']) ? $_POST['email'] : '';

            $post_userid = $_POST['userid'];
            $query = "SELECT * FROM users WHERE user_id = '$post_userid'";
            
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {

                setcookie('su_userid', $post_userid, time() + 86400);
                setcookie('su_username', $post_username, time() + 86400);
                setcookie('su_email', $post_email, time() + 86400);

                error_handling('이미 존재하는 아이디입니다.', './signup.php');
            }

            if (!isset($_POST['password']) || $_POST['password'] == '')
                error_handling('비밀번호를 입력해주세요.', './signup.php');
            $post_password = $_POST['password'];

            if (!isset($_POST['password-re']) || $_POST['password-re'] == '')
                error_handling('비밀번호를 확인해주세요.', './signup.php');
            $post_password_re = $_POST['password-re'];

            if ($post_password != $post_password_re)
                error_handling('비밀번호가 일치하지 않습니다.', './signup.php');

            $query = "INSERT INTO users
                        VALUES (
                            DEFAULT, 
                            '$post_userid', 
                            PASSWORD('$post_password'), 
                            '$post_username', 
                            '$post_email', 
                            ''
                        )";
            if (!mysqli_query($conn, $query))
                error_handling('입력하신 정보를 데이터베이스에 저장하던 중 오류가 발생했습니다.', './signup.php');
            
            setcookie('su_userid', null, -1);
            setcookie('su_username', null, -1);
            setcookie('su_email', null, -1);

            error_handling('회원가입을 축하드립니다!\\n로그인해주세요.', './login.php');
        }
    }
    
    $userid = '';
    $username = '';
    $email = '';

    if (isset($_COOKIE['su_userid']))
        $userid = $_COOKIE['su_userid'];
    if (isset($_COOKIE['su_username']))
        $username = $_COOKIE['su_username'];
    if (isset($_COOKIE['su_email']))
        $email = $_COOKIE['su_email'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIGN UP - MODA TALK</title>
    <link rel="stylesheet" href="css/page/signup.css" />
  </head>
  <body class="signup-page">
    <form id="signup-page__form" method="POST">
      <a href="./login.php" class="link__back-to-login">
          <i class="fas fa-arrow-left"></i>
      </a>
      <h1 class="signup-header">
        회원 가입
      </h1>

      <label for="userid">아이디</label>
      <input type="text" name="userid" id="userid" value="<?php echo $userid; ?>"required/>

      <label for="password">비밀번호</label>
      <input type="password" name="password" id="password" required/>

      <div class="password-check">
        <label for="password-re">비밀번호 확인</label>
        <span class="password-check__message"></span>
      </div>
      <input type="password" name="password-re" id="password-re" required/>

      <label for="username">이름</label>
      <input type="text" name="username" id="username" placeholder="홍길동" value="<?php echo $username; ?>" required/>

      <label for="email">이메일 계정</label>
      <input type="email" name="email" id="email" placeholder="example@email.com" value="<?php echo $email; ?>" required/>

      <button id="signup-btn">sign up</button>
    </form>

    <script src="./js/signup.js"></script>
    <script src="https://kit.fontawesome.com/953e29909a.js" crossorigin="anonymous"></script>
  </body>
</html>
