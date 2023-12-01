<?php

namespace app\services;

class AuthorService
{
    public static function getTop($year): array
    {
        $sql = '
select a.id,
       a.name,
       (select count(b.id)
        from book b
                 inner join author_has_book ahb on b.id = ahb.book_id and ahb.author_id = a.id
        where b.year = :year) as books
from author a
having books > 0
order by books desc, a.name, a.id
limit 10
';
        return \Yii::$app->db->createCommand($sql, [':year' => $year])->queryAll();
    }
}