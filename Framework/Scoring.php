<?php

namespace Framework;

/**
 * Calculate the score
 */

class Scoring {
    public static function score(array $answersInfo, int $totalQuestion) : array {

        $correctScore = 0;

        foreach($answersInfo as $answer) {
            if ($answer->is_correct != 1)
                continue;

            $correctScore++;
        }

        $score = round(($correctScore / $totalQuestion) * 100, 2);

        $wrong = $totalQuestion - $correctScore;

        return [$score, $correctScore, $wrong];
    }
}