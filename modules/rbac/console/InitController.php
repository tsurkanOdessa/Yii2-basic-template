<?php

namespace modules\rbac\console;

use Yii;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use app\components\helpers\Console;
use modules\rbac\models\Role;
use modules\rbac\models\Permission;
use modules\rbac\Module;

/**
 * Class RbacController
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 *
 * @package console\controllers
 */
class InitController extends Controller
{
    const TYPE_ROLE = 'Roles';
    const TYPE_PERMISSION = 'Permissions';

    /**
     * Initialize RBAC
     */
    public function actionIndex()
    {
        if ($this->processInit()) {
            $this->stdout(Console::convertEncoding(Module::t('module','Done!')), Console::FG_GREEN, Console::BOLD);
            $this->stdout(PHP_EOL);
        } else {
            $this->stderr(Console::convertEncoding(Module::t('module','Fail!')), Console::FG_RED, Console::BOLD);
        }
    }

    /**
     * @return bool
     */
    public function processInit()
    {
        /** @var yii\rbac\ManagerInterface|yii\rbac\BaseManager|yii\rbac\DbManager|yii\rbac\PhpManager $auth */
        $auth = Yii::$app->authManager;
        $this->processClear($auth);
        $roles = $this->processCreate($auth, $this->getRoles(), self::TYPE_ROLE);
        $permissions = $this->processCreate($auth, $this->getPermissions(), self::TYPE_PERMISSION);
        $this->processAddPermissionToRoles($auth, $roles, $permissions);
        //$this->processAddChildRoles($auth, $roles); // Inheritance of roles - If you uncomment, the roles are inherited

        // Assign a super administrator role to the user from id 1
        $role = ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN);
        return $this->processAssignUserToRole($auth, $role, 1);
    }

    /**
     * Clear
     *
     * @param $auth yii\rbac\ManagerInterface
     * @return bool
     */
    protected function processClear($auth)
    {
        $auth->removeAll();
        return true;
    }

    /**
     * Create Roles and Permissions
     *
     * @param object $auth
     * @param array $array
     * @param string $type
     * @return array
     */
    protected function processCreate($auth, $array = [], $type = self::TYPE_ROLE)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$key] = ($type === self::TYPE_ROLE) ? $auth->createRole($key) : $auth->createPermission($key);
            $result[$key]->description = Module::t('module', $value);
            // Add rules
            if ($key == Permission::PERMISSION_UPDATE_OWN_POST) {
                $authorRule = new \modules\rbac\components\AuthorRule;
                $auth->add($authorRule);
                $result[$key]->ruleName = $authorRule->name;
            }
            $auth->add($result[$key]);
        }
        return $result;
    }

    /**
     * Add Permissions for Roles
     *
     * @param object $auth
     * @param array $roles
     * @param array $permissions
     */
    protected function processAddPermissionToRoles($auth, $roles = [], $permissions = [])
    {
        // ROLE_SUPER_ADMIN
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_POST));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_USERS));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_RBAC));

        // ROLE_ADMIN
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_POST));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_USERS));

        // ROLE_MANAGER
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_MANAGER),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_MANAGER),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_POST));

        // ROLE_EDITOR
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_EDITOR),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_EDITOR),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_UPDATE_OWN_POST));
    }

    /**
     * Add Child role for Roles
     *
     * @param object $auth
     * @param array $roles
     */
    protected function processAddChildRoles($auth, $roles = [])
    {
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($roles, Role::ROLE_ADMIN));

        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($roles, Role::ROLE_MANAGER));

        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_MANAGER),
            ArrayHelper::getValue($roles, Role::ROLE_EDITOR));

        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_EDITOR),
            ArrayHelper::getValue($roles, Role::ROLE_DEFAULT));
    }

    /**
     * Assign Role to User
     * @param object $auth
     * @param array $role
     * @param int $userId
     * @return bool
     */
    protected function processAssignUserToRole($auth, $role, $userId = 1)
    {
        $auth->assign($role, $userId);
        return true;
    }

    /**
     * Roles
     *
     * @return array
     */
    protected function getRoles()
    {
        $role = new Role();
        return $role->getRolesArray();
    }

    /**
     * Permissions
     *
     * @return array
     */
    protected function getPermissions()
    {
        $permission = new Permission();
        return $permission->getPermissionsArray();
    }
}
