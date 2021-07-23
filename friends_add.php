<?php
    include_once('./function.php');
    include_once('./dbconn.php');

    if (isset($_GET['user_no']) && $_GET['user_no'] != '') {
        $my_userno = $_SESSION['userno'];
        $friend_userno = $_GET['user_no'];

        $query = "SELECT * FROM friends
                    WHERE friend_self = $my_userno
                        AND friend_other = $friend_userno";
        $result = mysqli_query($conn, $query);
        if (!$result)
            error_handling('쿼리 오류가 발생했습니다.', './friends.php');
        
        if (mysqli_num_rows($result) > 0)
            error_handling('이미 친구 추가되었습니다.', './friends.php');

        $query = "INSERT INTO friends
                    VALUES (DEFAULT, $my_userno, $friend_userno)";
        $result = mysqli_query($conn, $query);
        if (!$result)
            error_handling('쿼리 오류가 발생했습니다.', './friends.php');

        alert_and_redirect('친구 추가되었습니다.', './friends.php');
    }

    if (!isset($_GET['add_by']) || 
            !in_array($_GET['add_by'], ['id', 'name', 'recommendation']))
        error_handling('올바르지 않은 URL입니다.', './friends.php');

    $add_by = $_GET['add_by'];
    $header_title = [
        'id' => 'ID로 추가', 
        'name' => '이름으로 추가', 
        'recommendation' => '추천 친구'
    ][$add_by];
    $placeholder = [
        'id' => '친구 ID', 
        'name' => '친구 이름', 
        'recommendation' => ''
    ][$add_by];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD BY <?php echo strtoupper($add_by); ?> - MODA TALK</title>
    <link rel="stylesheet" href="./css/page/friends_add.css" />
</head>
<body>
    <header class="main-header">
        <h1 class="main-header__title">
            <a href="./friends.php">
                <i class="fas fa-arrow-left"></i>
            </a>
            <?php echo $header_title; ?>
        </h1>
        <?php if ($add_by != 'recommendation') { ?>
        <div class="main-header__icons">
            <a href="#" id="submit-button">확인</a>
        </div>
        <?php } ?>
    </header>

    <main class="search-friend">
        <?php if ($add_by != 'recommendation') { ?>
        <form class="search-friend__form" action="?add_by=<?php echo $add_by; ?>" method="POST">
            <input type="text" placeholder="<?php echo $placeholder; ?>" maxlength=20 name="<?php echo $add_by; ?>">
            <button type="reset" class="search-friend__reset-input hidden">
                <i class="fas fa-times"></i>
            </button>
            <span class="search-friend__character-count">
                <span id="character-count">0</span>/20
            </span>
        </form>
        <?php } ?>

        <section class="search-friend__list">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    if (isset($_POST['id']))
                        $query = "SELECT * FROM users WHERE user_id = '{$_POST['id']}'";
                    else if (isset($_POST['name']))
                        $query = "SELECT * FROM users WHERE user_name = '{$_POST['name']}'";

                    $post_result = mysqli_query($conn, $query);
                    
                    if (mysqli_num_rows($post_result) > 0) {
                        while ($found_user = mysqli_fetch_assoc($post_result)) {
                            $my_id = $_SESSION['userid'];
                            $search_id = $found_user['user_id'];

                            if ($search_id == $my_id)
                                $relation = 'self';
                            else {
                                $query = "SELECT
                                                self.user_id AS my_id, 
                                                other.user_id AS other_id
                                            FROM friends
                                            JOIN users self
                                                ON friend_self = self.user_no
                                            JOIN users other
                                                ON friend_other = other.user_no
                                            WHERE self.user_id = '$my_id'
                                                AND other.user_id = '$search_id'";

                                $result = mysqli_query($conn, $query);
                                $row = mysqli_num_rows($result);

                                $relation = ($row > 0) ? 'friend' : 'not-friend';
                            }


                            switch ($relation) {
                                case 'self':
                                    $friend_status = '';
                                    $button_message = '나와의 채팅';
                                    $href = '#';
                                    break;
                                case 'friend':
                                    $friend_status = '이미 등록된 친구입니다.';
                                    $button_message = '1:1채팅';
                                    $href = '#';
                                    break;
                                case 'not-friend':
                                    $friend_status = '';
                                    $button_message = '친구 추가';
                                    $href = "?user_no={$found_user['user_no']}";
                                    break;
                                default:
                                    error_handling('오류가 발생했습니다.\\n관리자에게 알려주시기 바랍니다.', './friends.php');
                            }

                            echo "<div class=\"found-user\">
                                        <img src=\"https://picsum.photos/id/{$found_user['user_no']}0/300/300.jpg\">
                                        <h3 class=\"found-user__name\">
                                            {$found_user['user_name']}
                                        </h3>";
                            if ($friend_status)
                                echo    "<span class=\"found-user__friend-status\">$friend_status</span>";

                            echo        "<button><a href=\"$href\">$button_message</a></button>
                                    </div>";
                        }
                    }
                    else
                        echo "<h3 class=\"no-result-found\">검색 결과가 없습니다.</h3>";
                }
                else if ($add_by == 'recommendation') {
                    $my_id = $_SESSION['userid'];

                    $query = "SELECT user_no, user_name
                                FROM (
                                    SELECT friend_self AS who_friended_me
                                    FROM friends
                                    JOIN users
                                        ON friend_other = user_no
                                    WHERE user_id = '$my_id'
                                ) result1
                                LEFT JOIN (
                                    SELECT friend_other AS who_i_friended
                                    FROM friends
                                    JOIN users
                                        ON friend_self = user_no
                                    WHERE user_id = '$my_id'
                                ) result2
                                    ON result1.who_friended_me = result2.who_i_friended
                                JOIN users
                                    ON who_friended_me = users.user_no
                                WHERE who_i_friended IS NULL";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($found_user = mysqli_fetch_assoc($result)) {
                            echo "<div class=\"found-user\">
                                        <img src=\"https://picsum.photos/id/{$found_user['user_no']}0/300/300.jpg\">
                                        <h3 class=\"found-user__name\">
                                            {$found_user['user_name']}
                                        </h3>
                                        <button><a href=\"?user_no={$found_user['user_no']}\">친구 추가</a></button>
                                    </div>";
                        }
                    } else
                        echo "<h3 class=\"no-recommendation\">추천 친구가 없습니다.</h3>";
                }
            ?>
        </section>
    </main>
    <script src="./js/friends_add.js"></script>
    <script src="https://kit.fontawesome.com/953e29909a.js" crossorigin="anonymous"></script>
</body>
</html>