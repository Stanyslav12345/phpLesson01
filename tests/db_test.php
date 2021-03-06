<?php

require __DIR__ . '/../App/autoload.php';

use App\Db;
use App\Models\Article;

echo '<h3>Поиск новостей с id от -5 до 20:</h3>';
$articles = [];
for ($i = -5; $i <= 20; $i++) {
    $article = Article::findById($i);
    if ($article !== false) {
        echo $i . ': True<br>';
        $articles[] = $article;
    } else {
        echo $i . ': False<br>';
    }
};

echo '<h3>Текущие даты найденных новостей</h3>';
foreach ($articles as $article) {
    echo $article->id . ': ' . $article->createDate . '<br>';
}

echo '<h3>Замена дат новостей на рандомное время</h3>';
$db = new Db();

foreach ($articles as $article) {
    $randTime = rand(1000000000, 2000000000);
    var_dump($db->execute('UPDATE articles SET createDate = :c_date WHERE id=:id', [
        ':c_date' => date('Y-m-d H-i-s', $randTime),
        ':id' => $article->id
    ]));
    echo '<br>';
}

echo '<h3>Новое время</h3>';
$articles = Article::findAll();
foreach ($articles as $article) {
    echo $article->id . ': ' . $article->createDate . '<br>';
}

echo '<h3>Попытка замены поля времени на букву Х</h3>';
foreach ($articles as $article) {
    var_dump($db->execute('UPDATE articles SET createDate = :c_date WHERE id=:id', [
        ':c_date' => 'Х',
        ':id' => $article->id
    ]));
    echo '<br>';
}

echo '<h3>Ищем последние 2 новости</h3>';
foreach (Article::findLast(2) as $article) {
    echo $article->header . '<br>';
}

echo '<h3>Ищем последние 0 новости</h3>';
foreach (Article::findLast(0) as $article) {
    echo $article->header . '<br>';
}

echo '<h3>Ищем последние -2 новости</h3>';
foreach (Article::findLast(0) as $article) {
    echo $article->header . '<br>';
}

echo '<h3>Ищем последние 100 новости</h3>';
foreach (Article::findLast(100) as $article) {
    echo $article->header . '<br>';
}
