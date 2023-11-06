<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Admin', [
            'create',
            'read',
            'update',
            'delete',
            'admin'
        ])->description('Les Admins ont tous les droits');

        Jetstream::role('manager', 'Gestionnaire', [
            'read',
            'create',
            'update',
            'manager'
        ])->description('Les Gestionnaires ont tous les droits sur les EDL, y compris l\'attribution à un expert');

        Jetstream::role('consultant', 'Consultant', [
            'read',
            'create',
            'update',
            'consultant'
        ])->description('Les Consultants ont un droit limité sur les EDL.');
        Jetstream::role('assistant', 'Assistant', [
            'read',
            'create',
            'update',
            'consultant'
        ])->description('Les Assistants ont un droit limité sur les EDL.');

        Jetstream::role('expert-senior', 'Expert Senior', [
            'read',
            'create',
            'update',
            'expert'
        ])->description('Les Experts peuvent fixer des RDV, voir les EDL.');

        Jetstream::role('expert-beginner', 'Expert Junior', [
            'read',
            'create',
            'update',
            'expert'
        ])->description('Les Experts peuvent fixer des RDV, voir les EDL.');
    }
}
