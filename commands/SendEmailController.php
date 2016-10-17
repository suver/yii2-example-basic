<?php
/**
 * Created by IntelliJ IDEA.
 * User: suver
 * Date: 13.10.16
 * Time: 2:17
 */

namespace app\commands;

use suver\notifications\models\Notifications as NotificationsModel;
use suver\notifications\Notifications;
use Yii;
use yii\console\Controller;

/**
 * SendEmail generator
 */
class SendEmailController extends Controller
{
    /**
     * Generates roles
     */
    public function actionIndex()
    {

        $notifications = NotificationsModel::find()->andWhere(['sent_at' => null, 'channel' => 'email'])->all();
        if($notifications) {
            foreach ($notifications as $notification) {
                $notify = Notifications::load($notification->id);
                if($notify) {
                    if($notify->send()) {
                        echo "Message sended\n";
                    }
                }
            }
        }
        echo "Done!\n";
    }
}
