<?php

namespace App\Models;

use App\Models\UserRole;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string'
    ];

    protected $primaryKey = 'id';

    public static function get_users_by_group()
    {
        $users = array();

        $user_ids = User::get_userid_in_group();

        foreach($user_ids as $user_id)
        {
            $user = User::find($user_id->id);

            $users[] = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'roles' => UserRole::where('user_id', $user->id)->get('role_id')
            ];
        }

        return $users;
    }

    public static function get_users_by_village()
    {
        $users = array();

        $user_ids = User::get_userid_in_village();

        foreach($user_ids as $user_id)
        {
            $user = User::find($user_id->id);

            $users[] = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'roles' => UserRole::where('user_id', $user->id)->get('role_id')
            ];
        }

        return $users;
    }

    public static function get_users()
    {
        $users = array();

        $user_ids = User::all(['id']);

        foreach($user_ids as $user_id)
        {
            $user = User::find($user_id->id);

            $users[] = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'roles' => UserRole::where('user_id', $user->id)->get('role_id')
            ];
        }

        return $users;
    }

    private static function get_userid_in_group()
    {
        $query = DB::table('users')
                ->leftJoin('user_roles', 'users.id','=','user_roles.user_id')
                ->leftJoin('roles','user_roles.role_id','=','roles.id')
                ->where('roles.group_code',session('group'))
                ->select(['users.id'])
                ->distinct()
                ->get();

        return $query;
    }

    private static function get_userid_in_village()
    {
        $query = DB::table('users')
                ->leftJoin('user_roles', 'users.id','=','user_roles.user_id')
                ->leftJoin('roles','user_roles.role_id','=','roles.id')
                ->where('roles.village_code',session('village'))
                ->where('roles.group_code','=',null)
                ->select(['users.id'])
                ->distinct()
                ->get();

        return $query;
    }
}
