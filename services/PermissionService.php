<?php

class PermissionService
{
    public static function requireTeacherPermission()
    {
        return self::requirePermission(self::hasTeacherPermission());
    }

    public static function hasTeacherPermission()
    {
        return $GLOBALS['perm']->have_studip_perm("dozent", \Context::getId()) || $GLOBALS['perm']->have_perm("root");
    }

    public static function requireAdminPermission()
    {
        return self::requirePermission(self::hasAdminPermission());
    }

    public static function hasAdminPermission()
    {
        return $GLOBALS['perm']->have_perm("root") || $GLOBALS['perm']->have_perm("admin");
    }

    private static function requirePermission($hasPermission)
    {
        if ($hasPermission) {
            return;
        }
        echo "forbidden";
        exit;
    }
}
