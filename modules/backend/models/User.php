<?php namespace Backend\Models;

use Mail;
use Event;
use Backend;
use BackendAuth;
use Winter\Storm\Auth\Models\User as UserBase;

/**
 * Administrator user model
 *
 * @package winter\wn-backend-module
 * @author Alexey Bobkov, Samuel Georges
 */
class User extends UserBase
{
    use \Winter\Storm\Database\Traits\SoftDelete;

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'backend_users';

    /**
     * Validation rules
     */
    public $rules = [
        'email' => 'required|between:6,255|email|unique:backend_users',
        'login' => 'required|between:2,255|unique:backend_users',
        'password' => 'required:create|min:4|confirmed',
        'password_confirmation' => 'required_with:password|min:4'
    ];

    /**
     * @var array Attributes that should be cast to dates
     */
    protected $dates = [
        'activated_at',
        'last_login',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Relations
     */
    public $belongsToMany = [
        'groups' => [UserGroup::class, 'table' => 'backend_users_groups']
    ];

    public $belongsTo = [
        'role' => UserRole::class
    ];

    public $attachOne = [
        'avatar' => \System\Models\File::class
    ];

    /**
     * Purge attributes from data set.
     */
    protected $purgeable = ['password_confirmation', 'send_invite'];

    /**
     * @var string Login attribute
     */
    public static $loginAttribute = 'login';

    /**
     * @return string Returns the user's full name.
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Gets a code for when the user is persisted to a cookie or session which identifies the user.
     * @return string
     */
    public function getPersistCode()
    {
        // Option A: @todo config
        // return parent::getPersistCode();

        // Option B:
        if (!$this->persist_code) {
            return parent::getPersistCode();
        }

        return $this->persist_code;
    }

    /**
     * Returns the public image file path to this user's avatar.
     */
    public function getAvatarThumb($size = 25, $options = null)
    {
        if (is_string($options)) {
            $options = ['default' => $options];
        }
        elseif (!is_array($options)) {
            $options = [];
        }

        // Default is "mm" (Mystery man)
        $default = array_get($options, 'default', 'mm');

        if ($this->avatar) {
            return $this->avatar->getThumb($size, $size, $options);
        }

        return '//www.gravatar.com/avatar/' .
            md5(strtolower(trim($this->email))) .
            '?s='. $size .
            '&d='. urlencode($default);
    }

    /**
     * After create event
     * @return void
     */
    public function afterCreate()
    {
        $this->restorePurgedValues();

        if ($this->send_invite) {
            $this->sendInvitation();
        }
    }

    /**
     * After login event
     * @return void
     */
    public function afterLogin()
    {
        parent::afterLogin();

        /**
         * @event backend.user.login
         * Provides an opportunity to interact with the Backend User model after the user has logged in
         *
         * Example usage:
         *
         *     Event::listen('backend.user.login', function ((\Backend\Models\User) $user) {
         *         Flash::success(sprintf('Welcome %s!', $user->getFullNameAttribute()));
         *     });
         *
         */
        Event::fire('backend.user.login', [$this]);
    }

    /**
     * Sends an invitation to the user using template "backend::mail.invite".
     * @return void
     */
    public function sendInvitation()
    {
        $data = [
            'name' => $this->full_name,
            'login' => $this->login,
            'password' => $this->getOriginalHashValue('password'),
            'link' => Backend::url('backend'),
        ];

        Mail::send('backend::mail.invite', $data, function ($message) {
            $message->to($this->email, $this->full_name);
        });
    }

    public function getGroupsOptions()
    {
        $result = [];

        foreach (UserGroup::all() as $group) {
            $result[$group->id] = [$group->name, $group->description];
        }

        return $result;
    }

    public function getRoleOptions()
    {
        $result = [];

        foreach (UserRole::all() as $role) {
            $result[$role->id] = [$role->name, $role->description];
        }

        return $result;
    }

    /**
     * Check if the user is suspended.
     * @return bool
     */
    public function isSuspended()
    {
        return BackendAuth::findThrottleByUserId($this->id)->checkSuspended();
    }

    /**
     * Remove the suspension on this user.
     * @return void
     */
    public function unsuspend()
    {
        BackendAuth::findThrottleByUserId($this->id)->unsuspend();
    }

    //
    // Impersonation
    //

    /**
     * Returns an array of merged permissions based on the user's individual permissions
     * and their group permissions filtering out any permissions the impersonator doesn't
     * have access to (if the current user is being impersonated)
     *
     * @return array
     */
    public function getMergedPermissions()
    {
        if (!$this->mergedPermissions) {
            $permissions = parent::getMergedPermissions();

            // If the user is being impersonated filter out any permissions the impersonator doesn't have access to already
            if (BackendAuth::isImpersonator()) {
                $impersonator = BackendAuth::getImpersonator();
                if ($impersonator && $impersonator !== $this) {
                    foreach ($permissions as $i => $permission) {
                        if (!$impersonator->hasAccess($permission)) {
                            unset($permissions[$i]);
                        }
                    }
                    $this->mergedPermissions = $permissions;
                }
            }
        }

        return $this->mergedPermissions;
    }

    /**
     * Check if this user can be impersonated by the provided impersonator
     * Super users cannot be impersonated and all users cannot be impersonated unless there is an impersonator
     * present and the impersonator has access to `backend.impersonate_users`, and the impersonator is not the
     * user being impersonated
     *
     * @param \Winter\Storm\Auth\Models\User|false $impersonator The user attempting to impersonate this user, false when not available
     * @return boolean
     */
    public function canBeImpersonated($impersonator = false)
    {
        if (
            $this->isSuperUser() ||
            !$impersonator ||
            !($impersonator instanceof static) ||
            !$impersonator->hasAccess('backend.impersonate_users') ||
            $impersonator === $this
        ) {
            return false;
        }

        // Clear the merged permissions before the impersonation starts
        // so that they are correct even if they had been loaded prior
        // to the impersonation starting
        $this->mergedPermissions = null;

        return true;
    }
}
