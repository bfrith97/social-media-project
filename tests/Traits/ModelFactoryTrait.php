<?php

namespace Tests\Traits;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

trait ModelFactoryTrait {
    protected function createUser() {
        return User::factory()->create();
    }

    protected function createPost($user) {
        return Post::factory()->create(['user_id' => $user->id]);
    }

    protected function createComment($user, $post) {
        return Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $post->id,
            'item_type' => Post::class,
        ]);
    }
}
