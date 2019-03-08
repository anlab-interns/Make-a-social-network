<?php
/**
 * Created by PhpStorm.
 * User: quy
 * Date: 07/03/2019
 * Time: 15:27
 */

namespace App\Traits;

use App\Friend;

trait Friendable
{
    public function test()
    {
        return 'hi';
    }

    /**
     * @param $id
     * @return string|void
     */
    public function addFriend($id)
    {
        $friend = Friend::create([
            'requester' => $this->id,
            'user_requested' => $id,
        ]);
        if ($friend) {
            return $friend;
        }
        return 'fail';
    }
}