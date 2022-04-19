<?php

namespace App\Repositories\ResetPasswords;

use App\Exceptions\InvalidResetCode;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface ResetPasswordRepositoryInterface extends RepositoryInterface
{
    /**
     * Check reset code is valid or not
     * @param array $attributes
     * @return void
     * @throws InvalidResetCode
     */
    public function resetCodeCheck($attributes);

    /**
     * Delete all password reset records match email
     * @param string $email
     * @return void
     */
    public function clearPasswordReset($email);

    /**
     * Create a password resets
     * @param array $attributes
     * @return Model
     */
    public function create($attributes);

    /**
     * Find latest password reset by email
     * @param string $email
     * @return Model
     */
    public function findByEmail($email);

    /**
     * Generate reset code
     * @return string
     */
    public function generateCode();
}
