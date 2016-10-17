<?php
namespace app\modules\users\models;


/**
 * User interface
 *
 */
interface UserInterface
{
    /**
     * Вернет статус в текущем языке
     * @return string|null
     */
    public function getStatusLabel();

    /**
     * Вернет статус в текущем языке
     * @return string|null
     */
    public function getFullname();

    /**
     * Список всех статусов [status => label]
     * @return array
     */
    public static function getStatusList();
}
