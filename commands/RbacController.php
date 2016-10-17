<?php
/**
 * Created by IntelliJ IDEA.
 * User: suver
 * Date: 13.10.16
 * Time: 2:17
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * RBAC generator
 */
class RbacController extends Controller
{
    /**
     * Generates roles
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $updateNews = $auth->createPermission('updateNews');
        $updateNews->description = 'Update News';
        $auth->add($updateNews);

        $createNews = $auth->createPermission('createNews');
        $createNews->description = 'Create News';
        $auth->add($createNews);

        $deleteNews = $auth->createPermission('deleteNews');
        $deleteNews->description = 'Delete News';
        $auth->add($deleteNews);

        $viewFullNews = $auth->createPermission('viewFullNews');
        $viewFullNews->description = 'View Full News';
        $auth->add($viewFullNews);

        $viewShortNews = $auth->createPermission('viewShortNews');
        $viewShortNews->description = 'View Short News';
        $auth->add($viewShortNews);

        $updateOwnNews = $auth->createPermission('updateOwnNews');
        $updateOwnNews->description = 'Upate Own News';
        $auth->add($updateOwnNews);


        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update User';
        $auth->add($updateUser);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create User';
        $auth->add($createUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete User';
        $auth->add($deleteUser);

        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'View Full User';
        $auth->add($viewUser);


        $backendAccess = $auth->createPermission('backendAccess');
        $backendAccess->description = 'Backend Access';
        $auth->add($backendAccess);


        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);


        $auth->addChild($user, $viewFullNews);
        $auth->addChild($user, $viewShortNews);
        $auth->addChild($user, $updateOwnNews);
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $createNews);
        $auth->addChild($moderator, $updateNews);
        $auth->addChild($moderator, $deleteNews);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $backendAccess);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $viewUser);

        $this->stdout('Done!' . PHP_EOL);
    }
}
