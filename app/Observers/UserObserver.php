<?php

namespace App\Observers;

use App\Entities\User;
// use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUser;
class UserObserver
{
    // Deleta o cache
    public function clearCache()
    {
        $cache_name  = 'list_users';
        cache()->tags($cache_name)->flush();
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\Entities\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //Deleta o cache
        $this->clearCache();

        // Envia email para os usuários cadastrados
        \Mail::to($user->email)->send(new SendMailUser($user));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Entities\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //Deleta o cache
        $this->clearCache();
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Entities\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //Deleta o cache
        $this->clearCache();
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Entities\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Entities\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
