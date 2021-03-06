<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Swagger\Annotations as SWG;

/**
 * Class User
 * @package App
 *
 * @SWG\Definition(
 *     definition="AuthRequest",
 *     @SWG\Property(
 *          property="name",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="password",
 *          type="string"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="CreateUserRequest",
 *     @SWG\Property(
 *          property="name",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="fullName",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="password",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="passwordConf",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="roleId",
 *          type="number"
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="UpdateUserRequest",
 *     @SWG\Property(
 *          property="name",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="fullName",
 *          type="string"
 *     ),
 *     @SWG\Property(
 *          property="roleId",
 *          type="number"
 *     )
 * )
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'password',
        'full_name',
        'role_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * This user's role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * This user's access tokens.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accessTokens()
    {
        return $this->hasMany(AccessToken::class);
    }
}
