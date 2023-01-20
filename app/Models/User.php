<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
    ];

    public function rulesLogin() {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function feedbackLogin() {
        return [
            'email.required' => 'O campo email é obrigatório',
            'password.required' => 'O campo senha é obrigátorio',

            'email.email' => 'O email é inválido',
        ];
    }

    public function rulesRegister() {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required'
        ];
        return $rules;
    }

    public function feedbackRegister() {
        return [
            'name.required' => 'O campo nome é obrigátorio',
            'email.required' => 'O campo email é obrigatório',
            'password.required' => 'O campo de senha é obrigatório',

            'name.max' => 'O nome deve conter no máximo 255 caracteres',
            'email.max' => 'O email deve conter no máximo 255 caracteres',

            'email.unique' => 'Email já existe',

            'email.email' => 'O email é inválido',
        ];
    }

    public function installments() {
        return $this->hasMany(Installment::class, 'users_id');
    }
}
