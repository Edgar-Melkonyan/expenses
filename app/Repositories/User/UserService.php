<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements UserRepository
{
    /**
     * Defining Items per page
     *
     * @const PER_PAGE
     */
    const PER_PAGE = 10;

    /**
     * @var $user
     */
    protected $user;

    /**
     * UserService constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get paginated users.
     *
     * @return LengthAwarePaginator
     */
    public function getAllUsers(): LengthAwarePaginator
    {
        return $this->user->with(['role'])->paginate(self::PER_PAGE);
    }

    /**
     * Get User Object by id.
     *
     * @param int $id
     *
     * @return User
     */
    public function getUser(int $id): User
    {
        return $this->user->with(['role'])->findOrFail($id);
    }

    /**
     * Create a new User.
     *
     * @param array $data
     *
     * @return User
     */
    public function createUser(array $data): User
    {
        $user = $this->user->create($data);
        return $user->load(['role']);
    }

    /**
     * Update User by id.
     *
     * @param int $id
     * @param array $data
     *
     * @return User
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);
        return $user->load(['role']);
    }

    /**
     * Delete User by id.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteUser(int $id): void
    {
        if (auth()->id() === $id) {
            abort(Response::HTTP_FORBIDDEN, 'You can\'t delete yourself');
        }
        $this->user->findOrFail($id)->delete();
    }
}
