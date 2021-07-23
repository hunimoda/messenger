<?php include_once('./dbconn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHATS - MODA TALK</title>
    <link rel="stylesheet" href="./css/page/chats.css" />
</head>
<body>
    <?php include_once('./chats_header.php'); ?>

    <main class="chats-list">
        <?php
            $user_no = $_SESSION['userno'];

            $query = "SELECT
                            u.user_no, 
                            u.user_name AS chat_with, 
                            sub.chat_message, 
                            sub.chat_datetime
                        FROM (
                            SELECT *
                            FROM (
                                SELECT
                                    chat_no, 
                                    CASE
                                        WHEN chat_from = $user_no THEN chat_to
                                        WHEN chat_to = $user_no THEN chat_from
                                    END AS chat_with, 
                                    chat_message, 
                                    chat_datetime
                                FROM chats
                            ) temp
                            WHERE temp.chat_with IS NOT NULL
                            ORDER BY chat_datetime ASC LIMIT 999999
                        ) AS sub
                        JOIN users u
                            ON sub.chat_with = u.user_no
                        GROUP BY chat_with";
            $result = mysqli_query($conn, $query);

            if (!$result)
                error_handling('쿼리 오류가 발생했습니다.', './friends.php');
            
            if (mysqli_num_rows($result) > 0) {
                while ($friend = mysqli_fetch_assoc($result)) {
                    $image = "https://picsum.photos/id/{$friend['user_no']}0/300/300.jpg";
                    $friend_userno = $friend['user_no'];
                    $friend_name = $friend['chat_with'];
                    $last_message = $friend['chat_message'];
                    $last_timestamp = $friend['chat_datetime'];
                    include('./chat.php');
                }
            }
            else
                echo "<h3 class=\"user-notification\">친구와 대화를 시작해보세요!</h3>";
        ?>
    </main>

    <?php include_once('./navbar.php'); ?>
    <script>
        const link = document.querySelector('.main-navbar__link:last-child');
        link.classList.add('selected');
    </script>
    <script src="https://kit.fontawesome.com/953e29909a.js" crossorigin="anonymous"></script>
</body>
</html>