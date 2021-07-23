<?php
  include_once('./dbconn.php');
  include_once('./function.php');

  if (isset($_SESSION['userid']))
    redirect('./friends.php');

  if (isset($_SERVER['REQUEST_METHOD']) && 
      $_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['userid'] && $_POST['password']) {

      if (isset($_POST['remember_id']) && 
          $_POST['remember_id'] == 'on')
        setcookie('userid', $_POST['userid'], time() + 86400*365*100);
      else
        setcookie('userid', null, -1);
          
      $userid = $_POST['userid'];
      $password = $_POST['password'];

      $query = "SELECT user_no, user_id, user_password
                FROM users
                WHERE user_id = '$userid' AND
                      user_password = PASSWORD('$password')";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) == 0)
        error_handling('존재하지 않는 아이디이거나 비밀번호가 틀립니다.', './login.php');
      
      $user = mysqli_fetch_assoc($result);
      mysqli_close($conn);

      $_SESSION['userid'] = $user['user_id'];
      $_SESSION['userno'] = $user['user_no'];
      
      redirect('./friends.php');
    }
    else
      error_handling('유저 정보가 틀립니다', './login.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN - MODA TALK</title>
    <link rel="stylesheet" href="css/page/login.css" />
  </head>
  <body class="login-page">
    <form id="login-page__form" method="POST">
      <h1 class="moda-logo">moda</h1>

      <?php
        $userid = '';
        $checked = '';
        if (isset($_COOKIE['userid'])) {
          $userid = $_COOKIE['userid'];
          $checked = 'checked';
        }
      ?>
      <label for="userid">아이디</label>
      <input type="text" name="userid" id="userid" value="<?php echo $userid; ?>" required/>

      <label for="password">비밀번호</label>
      <input type="password" name="password" id="password" required/>

      <div class="form__row">
        <div class="form__column">
          <input type="checkbox" id="remember-id" name="remember_id" <?php echo $checked; ?> />
          <label for="remember-id">아이디 저장</label>
        </div>
        <div class="form__column">
          <a href="signup.php">회원가입</a>
        </div>
      </div>
      <button>login</button>
    </form>
  </body>
</html>
