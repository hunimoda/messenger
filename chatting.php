<?php include_once('./dbconn.php'); ?>
<?php include_once('./function.php'); ?>

<?php
    if (!isset($_GET['friend_no']) || $_GET['friend_no'] == '')
        error_handling('올바르지 않은 URL입니다.', './chats.php');
    
    if (!isset($_GET['friend_name']) || $_GET['friend_name'] == '')
        error_handling('올바르지 않은 URL입니다.', './chats.php');
        
    $my_userno = $_SESSION['userno'];
    $friend_no = $_GET['friend_no'];
    $friend_name = $_GET['friend_name'];

    if (isset($_SERVER['REQUEST_METHOD']) && 
        $_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if (!isset($_POST['message']) || $_POST['message'] == '')
            error_handling('메시지가 전달되지 않았습니다!', "{$_SERVER['PHP_SELF']}?friend_no=$friend_no&friend_name=$friend_name");
            $message = $_POST['message'];
            
            $query =   "INSERT INTO chats
                    VALUES (
                        DEFAULT, 
                        $my_userno, 
                        $friend_no, 
                        '$message', 
                        DEFAULT
                    )";
            $result = mysqli_query($conn, $query);
            if (!$result)
                error_handling('쿼리 오류가 발생했습니다.', '#');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAT WITH <?php echo strtoupper($friend_name); ?> - MODA TALK</title>
    <link rel="stylesheet" href="./css/page/chatting.css" />
</head>
<body>
    <header class="main-header">
        <a href="./chats.php" class="main-header__link-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="main-header__title">
            <?php echo $friend_name; ?>
        </h1>
    </header>

    <main class="messages">
        <?php
            $query = "SELECT *
                        FROM chats
                        WHERE chat_from = $my_userno AND chat_to = $friend_no
                            OR chat_from = $friend_no AND chat_to = $my_userno
                        ORDER BY chat_datetime ASC";
            $result = mysqli_query($conn, $query);
            if (!$result)
                error_handling('쿼리 오류가 발생했습니다.', './chats.php');

            if (mysqli_num_rows($result) > 0) {
                while ($message = mysqli_fetch_assoc($result)) {
                    if ($message['chat_from'] == $friend_no)
                        $sent_by = 'sent-by-friend';
                    else
                        $sent_by = 'sent-by-me';

                    //

                    echo    "<div class=\"message__row $sent_by\">
                                <div class=\"message__text\">
                                    <p>{$message['chat_message']}</p>
                                </div>
                                <div class=\"message__info\">
                                    <span class=\"message__read-status\">
                                    </span>
                                </div>
                            </div>";
                }
                echo "<div id=\"last-chat\"></div>";
            } else {
                echo "<div class=\"user-notification\" id=\"user-note-btn\">대화를 시작해보세요!<div>";
            }
        ?>
    </main>

    <form class="send-message__form" method="POST">
        <div class="send-message__container" id="message-box">
            <input type="text" class="send-message__input" id="message-input" name="message">
            <button class="send-message__button" id="submit-button">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>
    <script src="./js/chatting.js"></script>
    <script src="https://kit.fontawesome.com/953e29909a.js" crossorigin="anonymous"></script>
</body>
</html>