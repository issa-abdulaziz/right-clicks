<?php

function userCompletedTasks()
{
    return auth()->user()->tasks()->where('status', 'completed')->count();
}
function userInProgressTasks()
{
    return auth()->user()->tasks()->where('status', 'in_progress')->count();
}
function userPendedTasks()
{
    return auth()->user()->tasks()->where('status', 'pended')->count();
}
function userCanceledTasks()
{
    return auth()->user()->tasks()->where('status', 'canceled')->count();
}
