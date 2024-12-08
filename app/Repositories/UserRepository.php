<?php
namespace App\Repositories;
use App\Exceptions\UserExistsException;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository implements CrudByIdRepositoryInterface
{
    use CrudByIdRepository;

    private User|string $model;

    public function __construct()
    {
        $this->initModel(User::class);
    }

    /**
     * 創建用戶.
     *
     * @throws UserExistsException
     */
    public function createUser(array $user_data): User
    {
        $user = new User;
        $query = $user
            ->whereName($user_data['name'])
            ->whereEmail($user_data['email'])
        ;
        if ($query->exists()) {
            throw new UserExistsException('用戶已經存在');
        }
        $user->name = $user_data['name'];
        $user->email = $user_data['email'];
        $user->password = Hash::make($user_data['password']);
        $user->role_id = $user_data['role_id'];
        $user->save();

        return $user->refresh();
    }

    /**
     * 查詢或創建用戶.
     */
    public function findOrCreateUser(array $user_data): User
    {
        return User::firstOrCreate(
            [
                'email' => $user_data['email'],
            ],
            [
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'password' => Hash::make($user_data['password']),
                'role_id' => $user_data['role_id'],
            ],
        );
    }

    public function getPage(
        int $page,
        int $perPage = 10,
        array $search = [],
        array $asc = [],
        array $desc = [],
        array $columns = ['*'],
        string $pageName = 'page'
    ): LengthAwarePaginator
    {
        $model = User::query();
        $model->with('role');
        if (! empty($search)) {
            $model = $model->where($search);
        }
        foreach ($asc as $column) {
            $model = $model->orderBy($column, 'asc');
        }
        foreach ($desc as $column) {
            $model = $model->orderBy($column, 'desc');
        }
        return $model->paginate($perPage, $columns, $pageName, $page);
    }
}
