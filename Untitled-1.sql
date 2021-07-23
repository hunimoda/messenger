SELECT
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
                                        WHEN chat_from = 16 THEN chat_to
                                        WHEN chat_to = 16 THEN chat_from
                                    END AS chat_with, 
                                    chat_message, 
                                    chat_datetime
                                FROM chats
                            ) temp
                            WHERE temp.chat_with IS NOT NULL
                            ORDER BY chat_datetime DESC LIMIT 999999
                        ) AS sub
                        JOIN users u
                            ON sub.chat_with = u.user_no
                        GROUP BY chat_with