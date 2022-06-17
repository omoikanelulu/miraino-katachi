<?php
class Validation
{
    /**
     * 文字数チェック
     */
    public static function lengthLimit($item)
    {
        if (mb_strlen($item) >= 100 || $item == '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 正しい年月日かチェック
     * checkdate(int $month, int $day, int $year): bool
     */
    public static function checkCorrectDate($date)
    {
        list($year, $month, $day) = explode('-', $date);
        if (!checkdate($month, $day, $year)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 担当者を選択しているか
     */
    public static function isSelectedRep($rep)
    {
        if (empty($rep)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 登録済みの担当者かチェックする
     */
    public static function registeredCheck($userInfo, $post)
    {
        $hasErr = false;
        foreach ($userInfo as $info => $v) {
            if ($post != ($v['id'])) {
                $_SESSION['err']['unRegRep'] = '登録されていない担当者です';
                $hasErr = true;
            } else {
                unset($_SESSION['err']['unRegRep']);
                $hasErr = false;
                break;
            }
        }
        return $hasErr;
    }
}
