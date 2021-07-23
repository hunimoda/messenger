<?php include_once('./dbconn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRIENDS - MODA TALK</title>
    <link rel="stylesheet" href="./css/page/friends.css" />
</head>
<body>
    <?php include_once('./friends_header.php'); ?>

    <main class="friends-main">
        <div class="friends-main__user">
            <?php                
                $query = "SELECT *
                            FROM users
                            WHERE user_id = '{$_SESSION['userid']}'";
                $result = mysqli_query($conn, $query);
                $user = mysqli_fetch_assoc($result);

                $user_name = $user['user_name'];
                $user_message = $user['user_message'];
                
                include('./user.php');
            ?>
        </div>
        <div class="friends-main__friends">
            <?php
                $query = "SELECT *
                            FROM friends f
                            JOIN users u
                                ON f.friend_other = u.user_no
                            WHERE friend_self = '{$user['user_no']}'";
                $result = mysqli_query($conn, $query);

                echo "<div class=\"friends-main__tab\">
                        <h4 class=\"friends-main__friend-count\">
                            친구 ".mysqli_num_rows($result)."
                        </h4>
                        <i class=\"fas fa-chevron-up\"></i>
                      </div>";

                echo "<div class=\"friends-main__list\">";
                while ($user = mysqli_fetch_assoc($result)) {    
                    $user_name = $user['user_name'];
                    $user_message = $user['user_message'];
                    
                    include('./user.php');
                }
                echo "</div>";
            ?>
        </div>
    </main>

    <dialog class="add-friend add-friend--hidden">
        <div class="add-friend__modal">
            <div class="add-friend__row title-bar">
                <i class="fas fa-arrow-left"></i>
                <h3 class="add-friend__title">친구 추가</h3>
            </div>
            <div class="add-friend__row add-by-tab">
                <div class="add-friend__column">
                    <a href="./friends_add.php?add_by=id">
                        <i class="fas fa-fingerprint"></i>
                        <h4>ID로 추가</h4>
                    </a>
                </div>
                <div class="add-friend__column">
                    <a href="./friends_add.php?add_by=name">
                        <i class="fas fa-id-card"></i>
                        <h4>이름으로 추가</h4>
                    </a>
                </div>
                <div class="add-friend__column">
                    <a href="./friends_add.php?add_by=recommendation">
                        <i class="fas fa-user-plus"></i>
                        <h4>추천 친구</h4>
                    </a>
                </div>
            </div>
        </div>
    </dialog>

    <dialog class="search-friend search-friend--hidden">
        <div class="search-friend__modal">
            <div class="search-friend__row title-bar">
                <i class="fas fa-arrow-left"></i>
                <h3 class="search-friend__title">친구 추가</h3>
            </div>
        </div>
    </dialog>

    <?php include_once('./navbar.php'); ?>
    <script src="./js/friends.js"></script>
    <script src="https://kit.fontawesome.com/953e29909a.js" crossorigin="anonymous"></script>
</body>
</html>