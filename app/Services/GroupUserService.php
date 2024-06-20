<?php

namespace App\Services;

use App\Http\Requests\GroupUserRequest;
use App\Models\GroupUser;
use Illuminate\Support\Facades\DB;

class GroupUserService extends ParentService
{
    public function storeGroupUser(GroupUserRequest $request): GroupUser
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            return GroupUser::createOrFirst($validatedData);
        });
    }

    public function destroyGroupUser(GroupUserRequest $request): ?bool
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validated();
            $this->validateUser($request);

            return GroupUser::where($validatedData)
                ->delete();
        });

    }
}
