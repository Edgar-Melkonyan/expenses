<?php

namespace App\Http\Controllers\Api;

use App\Repositories\User\UserRepository;
use App\Http\Requests\UserRequest;
use Exception;

class UserController extends Controller
{
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->getAllUsers();
        return response()->json(['success' => $users], self::HTTP_OK);
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = $this->userRepository->getUser($id);
        return response()->json(['success' =>  $user ], self::HTTP_OK);
    }

    /**
     * Store a newly created user.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->createUser($request->validated());
        return response()->json(['success' =>  $user ] ,self::HTTP_CREATED );
    }

    /**
     * Update the specified user.
     *
     * @param  int  $id
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id , UserRequest $request)
    {
        $user = $this->userRepository->updateUser($id, $request->validated());
        return response()->json(['success' => $user], self::HTTP_OK);
    }

    /**
     * Remove the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->userRepository->deleteUser($id);
            return response()->json(null , self::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json(['error' => ['message' => $e->getMessage()]], $e->getStatusCode() );
        }
    }
}
