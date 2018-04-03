<?php

function footerNotification($bottom , $event , $time)
{
    return " 
    <div class='fixed-panel col-md-12 p-fixed bottom row-fluid footer affix' >
        <div class='container text-center'>
            <p class='text-white small' >" . trans("subscription.$event" , ['time' => \Carbon\Carbon::parse($time)->diffForHumans()])  ."
                <a href='" .  url('/admin/account/plans') . "' >" . $bottom ."</a>
            </p>
        </div>
    </div>";
}

if (!function_exists('cache_subdomain')){
    function cache_subdomain($subdomain) 
    {
        \Illuminate\Support\Facades\Cache::forget($subdomain ."_store");
    }
}