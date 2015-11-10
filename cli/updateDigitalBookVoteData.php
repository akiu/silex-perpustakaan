<?php

include "../vendor/autoload.php";

use ExpressLibrary\Db\Db;

$conn = Db::getInstance();

$allId = $conn->fetchAll("SELECT voteForDigitalBookId FROM Digitalvote");

$filteredId = [];

//$filteredId = array_keys(array_flip($filteredId));

for ($i = 0; $i < count($allId); $i++ )
{
    echo $i . "\n";
    $filteredId[] = $allId[$i]["voteForDigitalBookId"];
}

$resArray = array_unique($filteredId);

$secondFilteredId = array_values($resArray);

$sql = "TRUNCATE TABLE  voteResult";

$stmt = $conn->prepare($sql);

$stmt->execute();

for ($ii = 0; $ii < count($secondFilteredId); $ii++)
{
    $likeData = $conn->fetchAll("SELECT id FROM Digitalvote WHERE voteForDigitalBookId = ? AND voteValue = ?",
        [
            $secondFilteredId[$ii],
            'like'
        ]
    );

    $unLikeData = $conn->fetchAll("SELECT id FROM Digitalvote WHERE voteForDigitalBookId = ? AND voteValue = ?",
        [
            $secondFilteredId[$ii],
            'unlike'
        ]
    );

    if ($likeData) {

        $conn->insert('voteResult',
            [
                'bookId' => (int)$secondFilteredId[$ii],
                'value' => "like",
                'result' => count($likeData)
            ]
        );
    }
    else
    {
        $conn->insert('voteResult',
            [
                'bookId' => (int)$secondFilteredId[$ii],
                'value' => "like",
                'result' => 0
            ]
        );
    }

    if ($unLikeData) {

        $conn->insert('voteResult',
            [
                'bookId' => (int)$secondFilteredId[$ii],
                'value' => "unlike",
                'result' => count($unLikeData)
            ]
        );
    }
    else
    {
        $conn->insert('voteResult',
            [
                'bookId' => (int)$secondFilteredId[$ii],
                'value' => "unlike",
                'result' => 0
            ]
        );
    }
}

