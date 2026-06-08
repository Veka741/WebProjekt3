<?php

namespace Config;

/**
 * App-level Ion Auth configuration override.
 * This file is loaded instead of IonAuth\Config\IonAuth.
 */
class IonAuth extends \IonAuth\Config\IonAuth
{
    /** Site title shown in emails */
    public $siteTitle = 'Portál adopce koček';

    /** Admin contact email */
    public $adminEmail = 'admin@admin.com';

    /**
     * Identity column – the column used to log in with.
     * We use "email" (Ion Auth default).
     */
    public $identity = 'email';

    /** No email activation required */
    public $emailActivation  = false;
    public $manualActivation = false;
}
