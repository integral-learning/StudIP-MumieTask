<?php

/**
 * PermissionService checks permissions and interrupts executing if neccessary.
 */
class PermissionService
{
    /**
     * Prevent execution, if the user isn't a teacher.
     *
     * @return void
     */
    public static function requireTeacherPermission()
    {
        return self::requirePermission(self::hasTeacherPermission());
    }
    
    /**
     * Is the user a teacher?
     *
     * @return void
     */
    public static function hasTeacherPermission()
    {
        return $GLOBALS['perm']->have_studip_perm("dozent", \Context::getId()) || $GLOBALS['perm']->have_perm("root");
    }
    
    /**
     * Prevent execution, if the user isn't an admin
     *
     * @return void
     */
    public static function requireAdminPermission()
    {
        return self::requirePermission(self::hasAdminPermission());
    }
    
    /**
     * Is the user an admin?
     *
     * @return void
     */
    public static function hasAdminPermission()
    {
        return $GLOBALS['perm']->have_perm("root") || $GLOBALS['perm']->have_perm("admin");
    }
    
    /**
     * Prevent execution, if the user lacks permission for the current action
     *
     * @param  boolean $hasPermission
     * @return void
     */
    private static function requirePermission($hasPermission)
    {
        if ($hasPermission) {
            return;
        }
        echo "forbidden";
        exit;
    }
}
